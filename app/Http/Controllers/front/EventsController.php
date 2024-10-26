<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Attendant;
use App\Models\Seminar;
use App\Models\SeminarReview;
use Dflydev\DotAccessData\Exception\DataException;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private const page_limit = 13;
    public function index()
    {
        $events = Seminar::orderByDesc('date')->paginate(self::page_limit);
        return view('front.events.view-all', compact('events'));
    }

    public function getAllEventsAjax(Request $request)
    {
        $limit = $request->query('limit', self::page_limit);
        $search = $request->query('search', '');
        $status = $request->query('status', []);

        $events = Seminar::where('title', 'like' , "%$search%");

        if(in_array('comming', $status) && !in_array('ended', $status))
        {
            $now = now();
            $events = $events->where('date', '>', $now);
        }
        else if(!in_array('comming', $status) && in_array('ended', $status))
        {
            $now = now();
            $events = $events->where('date', '<', $now);
        }

        switch($request->query('sort_by'))
        {
            case 'publish-old':
                $events->orderBy('date');
                break;
            case 'name-a':
                $events->orderBy('title');
                break;
            case 'name-z':
                $events->orderByDesc('title');
                break;
            case 'rating-highest':
                $events->withCount([
                    'attendants as attendants_count' => function ($query) {
                        $query->select(\DB::raw('coalesce(sum(*), 0)'));
                    }
                ])
                ->orderByDesc('book_review_avg_rating');
                break;
            case 'rating-highest':
                $events->withCount([
                    'attendants as attendants_count' => function ($query) {
                        $query->select(\DB::raw('coalesce(sum(*), 0)'));
                    }
                ])
                ->orderBy('attendants_count');
                break;
            default:
                $events->orderByDesc('date');
        }

        $events = $events->paginate($limit);

        return view('front.parts.events-list', compact('events'));
    }

    public function attend_auth(Request $request)
    {
        $user_id = auth()->user()->id;

        $is_attended = Attendant::where([
            ['seminar_id', $request->event_id],
            ['user_id', $user_id]
        ])->count();

        if($is_attended > 0)
        {
            return response()->json(['errors' => ['invalid' => [__('custom-errors.events.already-attended')]]], 422);
        }

        $request->validate([
            'event_id' => ['required', 'exists:seminars,id']
        ]);

        $attendance = Attendant::create([
            'seminar_id' => $request->event_id,
            'user_id' => $user_id
        ]);

        return view('front.parts.events-auth-attendance', ['attendance' => $attendance]);
    }

    public function unattend_auth(Request $request)
    {
        $request->validate([
            'event_id' => ['required', 'exists:seminars,id']
        ]);

        $user_id = auth()->user()->id;

        $attend = Attendant::where([
            ['seminar_id', $request->event_id],
            ['user_id', $user_id]
        ]);

        $attend->delete();

        return Attendant::count();
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'review_star' => ['required', 'min:0', 'max:5', 'numeric'],
            'review_text' => ['required', 'max:70'],
            'seminar_id' => ['required', 'exists:seminars,id'],
        ]);

        $user_id = auth()->user()->id;

        $check_review_exist = SeminarReview::where('seminar_id', $request->seminar_id)->where('user_id', $user_id)->count();

        if($check_review_exist)
        {
            return response()->json(['errors' => ['invalid' => [__('custom-errors.events.already-reviews')]]], 422);
        }

        $review = SeminarReview::create([
            'seminar_id' => $request->seminar_id,
            'review_star' => $request->review_star,
            'review_text' => $request->review_text,
            'user_id' => $user_id
        ]);
        

        return view('front.parts.events-auth-review', ['review' => $review]);
    }

    public function deleteReview(Request $request)
    {
        $request->validate([
            'seminar_id' => ['required', 'exists:seminars,id']
        ]);
        $user_id = auth()->user()->id;
        $review = SeminarReview::where('seminar_id', $request->seminar_id)->where('user_id', $user_id)->delete();
    }

    public function getReview(Request $request)
    {
        $request->validate([
            'seminar_id' => ['required', 'exists:seminars,id']
        ]);
        $user_id = auth()->user()->id;
        $get_review = SeminarReview::where('seminar_id', $request->seminar_id)->where('user_id', $user_id)->first();
        return json_encode($get_review);
    }

    public function updateReview(Request $request)
    {
        $request->validate([
            'review_star' => ['required', 'min:0', 'max:5', 'numeric'],
            'review_text' => ['required', 'max:70'],
            'seminar_id' => ['required', 'exists:seminars,id'],
        ]);

        $user_id = auth()->user()->id;

        $review = SeminarReview::where('seminar_id', $request->seminar_id)->where('user_id', $user_id)->first();

        $review->review_star = $request->review_star;
        $review->review_text = $request->review_text;

        $review->save();

        return view('front.parts.events-auth-review', ['review' => $review]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Seminar $event)
    {
        $reviews = $event->reviews()->paginate(5, ['*'], 'reviews_page');
        $attendance = $event->attendants()->orderBy('created_at')->paginate(5, ['*'], 'attendance_page');
        return view('front.events.single-event', compact('event', 'reviews', 'attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
