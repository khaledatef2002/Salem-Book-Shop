<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\PeopleType;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\AutoEncoder;
use Pest\Plugins\Only;

class PeopleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('can:people_show', only: ['index']),
            new Middleware('can:people_edit', only: ['edit', 'update']),
            new Middleware('can:people_delete', only: ['store']),
            new Middleware('can:people_create', only: ['create', 'store']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $people = Person::all();
            return DataTables::of($people)
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('people_edit') ?
                "
                    <a href='" . route('dashboard.people.edit', $row) . "'><i class='ri-settings-5-line fs-4' type='submit'></i></a>
                " : ''
                )
                .
                ( Auth::user()->hasPermissionTo('people_delete') ?
                "
                    <form id='remove_people' data-id='".$row['id']."' onsubmit='remove_people(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":""
                )
                .
                "</div>";
            })
            ->editColumn('name', function(Person $person){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($person->image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$person->name}</span>
                    </div>
                ";
            })
            ->editColumn('about', function(Person $person){
                return $person->about;
            })
            ->rawColumns(['name', 'action'])
            ->make(true);
        }
        return view('dashboard.people.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $PeopleType = [
            'author' => PeopleType::Author->value,
            'instructor' => PeopleType::Instructor->value
        ];
        return view('dashboard.people.create', compact('PeopleType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'array'],
            'name.*' => ['required', 'regex:/^[\p{Arabic}a-zA-Z\s]+$/u', UniqueTranslationRule::for('people'), 'min:2'],
            'type' => ['required', 'in:'. PeopleType::Author->value .',' . PeopleType::Instructor->value],
            'about' => ['required', 'array'],
            'about.*' => ['required', UniqueTranslationRule::for('people'), 'min:2'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg|max:10240']
        ]);

        $image = $request->file('image');

        $imagePath = 'persons/' . uniqid() . '.' . $image->getClientOriginalExtension();

        $manager = new ImageManager(new GdDriver());
        $optimizedImage = $manager->read($image)
            ->cover(250, 250, 'center')
            ->encode(new AutoEncoder(quality: 75));

        Storage::disk('public')->put($imagePath, (string) $optimizedImage);

        $data['image'] = 'storage/' . $imagePath;
        $person = Person::create($data);

        return response()->json(['redirectUrl' => route('dashboard.people.edit', $person)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        $PeopleType = [
            'author' => PeopleType::Author->value,
            'instructor' => PeopleType::Instructor->value
        ];
        return view('dashboard.people.edit', compact('PeopleType', 'person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        $data = $request->validate([
            'name' => ['required', 'array'],
            'name.*' => ['required', 'regex:/^[\p{Arabic}a-zA-Z\s]+$/u', UniqueTranslationRule::for('people')->ignore($person->id)->where('type', $person->type), 'min:2'],
            'type' => ['required', 'in:'. PeopleType::Author->value .',' . PeopleType::Instructor->value],
            'about' => ['required', 'array'],
            'about.*' => ['required', 'min:2'],
        ]);

        if($request->file('image'))
        {
            $request->validate([
                'image' => ['image', 'mimes:jpeg,png,jpg|max:10240']
            ]);

            if($person->image && Storage::disk('public')->exists($person->image))
            {
                Storage::disk('public')->delete($person->image);
            }

            $image = $request->file('image');

            $imagePath = 'persons/' . uniqid() . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(new GdDriver());
            $optimizedImage = $manager->read($image)
                ->cover(250, 250, 'center')
                ->encode(new AutoEncoder(quality: 75));

            Storage::disk('public')->put($imagePath, (string) $optimizedImage);

            $person->update([
                'image' => 'storage/' . $imagePath
            ]);
        }

        $person->update($data);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        if(Storage::disk('public')->exists($person->image))
        {
            Storage::disk('public')->delete($person->image);
        }
        $person->delete();
    }
}
