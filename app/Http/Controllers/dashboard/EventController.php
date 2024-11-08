<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use App\Models\SeminarInstructor;
use App\Models\SeminarMedia;
use App\PeopleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\AutoEncoder;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $quotes = Seminar::get();
            return DataTables::of($quotes)
            ->rawColumns(['action'])
            ->addColumn('action', function(Seminar $event){
                $action = "<div class='d-flex align-items-center justify-content-center gap-2'>";

                
                if($event->date <= now())
                {
                    $action .= "<a href='" . route('dashboard.event.review.index', $event) . "'><i class='ri-message-2-line fs-4' type='submit'></i></a>";
                }
                
                $action .= "<a href='" . route('dashboard.events.edit', $event) . "'><i class='ri-settings-5-line fs-4' type='submit'></i></a>";
                $action .=
                "
                    <form id='remove_event' data-id='".$event->id."' onsubmit='remove_event(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                </div>";

                return $action;
            })
            ->addColumn('reviews', function(Seminar $event){
                return $event->reviews()->count();
            })
            ->addColumn('status', function(Seminar $event){
                return $event->date > now() ? "<span class='badge bg-info'>". __('dashboard.events.comming') ."</span>" : "<span class='badge bg-success'>". __('dashboard.events.finished') ."</span>";
            })
            ->editColumn('description', function(Seminar $event){
                return truncatePostAndRemoveImages($event->description ?? '');
            })
            ->editColumn('cover', function(Seminar $event){
                return "<img src='". asset('storage/' . $event->cover) ."' width='70'>";
            })
            ->editColumn('date', function(Seminar $event){
                return $event->date->format('Y-m-d h:i:sa');
            })
            ->rawColumns(['cover', 'status', 'action'])
            ->make(true);
        }
        return view('dashboard.events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:2'],
            'description' => ['required', 'min:2'],
            'cover' => ['required', 'image', 'mimes:png,jpg,gif,jpeg', 'max:2048'],
            'date' => ['required', 'date'],
            'instructor_id' => ['required', 'array'],
            'instructor_id.*' => ['required', 'numeric', Rule::exists('people', 'id')->where('type', PeopleType::Instructor->value)]
        ]);

        $image = $request->file('cover');

        $imagePath = 'events/' . uniqid() . '.' . $image->getClientOriginalExtension();

        $manager = new ImageManager(new GdDriver());
        $optimizedImage = $manager->read($image)
            ->resize(250, 250, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode(new AutoEncoder(quality: 75));

        Storage::disk('public')->put($imagePath, (string) $optimizedImage);

        $event = Seminar::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'cover' => $imagePath
        ]);

        foreach($request->instructor_id as $instructor)
        {
            SeminarInstructor::create([
                'instructor_id' => $instructor,
                'seminar_id' => $event->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function upload_images(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('file')) {
            $image = $request->file('file');

            $imagePath = 'temp/' . uniqid() . '.' . $image->getClientOriginalExtension();
    
            $manager = new ImageManager(new GdDriver());
            $optimizedImage = $manager->read($image)
                ->resize(250, 250, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode(new AutoEncoder(quality: 75));
    
            Storage::disk('public')->put($imagePath, (string) $optimizedImage);

            return response()->json(['message' => 'Image uploaded successfully', 'path' => $imagePath]);
        }

        return response()->json(['message' => 'Image upload failed'], 400);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seminar $event)
    {
        $data_images = $event->media->map(fn($image) => [
            'id' => $image->id,
            'name' => basename($image->source),
            'size' => Storage::disk('public')->size($image->source),
            'url' => asset('storage/' . $image->source)
        ]);
        return view('dashboard.events.edit', compact('event', 'data_images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seminar $event)
    {
        $cover_validation = [];

        if($request->file('cover'))
        {
            $cover_validation = ['cover' => ['required', 'image', 'mimes:png,jpg,gif,jpeg', 'max:2048']];
        }

        $request->validate([
            'title' => ['required', 'min:2'],
            'description' => ['required', 'min:2'],
            'date' => ['required', 'date'],
            'instructor_id' => ['required', 'array'],
            'instructor_id.*' => ['required', 'numeric', Rule::exists('people', 'id')->where('type', PeopleType::Instructor->value)],
            $cover_validation
        ]);

        $data = $request->except('instructor_id', 'upload_images', 'delete_images');

        if($request->file('cover'))
        {
            if(Storage::disk('public')->exists($request->cover))
            {
                Storage::disk('public')->delete($request->cover);
            }

            $image = $request->file('cover');

            $imagePath = 'events/' . uniqid() . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(new GdDriver());
            $optimizedImage = $manager->read($image)
                ->resize(250, 250, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode(new AutoEncoder(quality: 75));

            Storage::disk('public')->put($imagePath, (string) $optimizedImage);

            $data['cover'] = $imagePath;
        }

        $event->update($data);

        if($event->date <= now())
        {
            foreach($request->delete_images ?? [] as $image_id)
            {
                $image = $event->media()->findOrFail($image_id);

                if(Storage::disk('public')->exists($image->source))
                {
                    Storage::disk('public')->delete($image->source);
                }

                $image->delete();
            }

            foreach ($request->upload_images ?? [] as $filePath) {
                $new_path = str_replace('temp/', 'events/media/', $filePath);
                Storage::disk('public')->move($filePath, $new_path); // Move to final location
                SeminarMedia::create([
                    'url' => $new_path,
                    'event_id' => $event->id
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seminar $event)
    {
        if(Storage::disk('public')->exists($event->cover))
        {
            Storage::disk('public')->delete($event->cover);
        }

        $event->delete();
    }
}
