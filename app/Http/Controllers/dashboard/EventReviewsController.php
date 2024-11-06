<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use App\Models\SeminarReview;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventReviewsController extends Controller
{
    public function index(Request $request, int $event)
    {
        $event_title = Seminar::find($event)->get('title')->first()->title;
        if($request->ajax())
        {
            $quotes = SeminarReview::where('seminar_id', $event)->get();
            return DataTables::of($quotes)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "
                    <form id='remove_event_review' data-id='".$row['id']."' onsubmit='remove_event_review(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ";
            })
            ->editColumn('event', function(SeminarReview $review){
                return $review->seminar->title;
            })
            ->editColumn('user', function(SeminarReview $review){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($review->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$review->user->full_name}</span>
                    </div>
                ";
            })
            ->editColumn('stars', function(SeminarReview $review){
                $stars = "";
                for($i = 0; $i < $review->review_star; $i++)
                {
                    $stars .= "<i class='ri-star-fill text-warning fs-5'></i>";
                }
                for($i = 0; $i < 5 - $review->review_star; $i++)
                {
                    $stars .= "<i class='ri-star-line fs-5'></i>";
                }
                return $stars;
            })
            ->rawColumns(['user', 'stars', 'action'])
            ->make(true);
        }
        return view('dashboard.events.reviews', compact('event_title'));
    }

    public function destroy(SeminarReview $review)
    {
        $review->delete();
    }
}
