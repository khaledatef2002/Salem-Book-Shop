<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $quotes = User::get();
            return DataTables::of($quotes)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                "
                    <a href='" . route('dashboard.users.edit', $row) . "'><i class='ri-settings-5-line fs-4' type='submit'></i></a>
                "
                .

                "
                    <form id='remove_user' data-id='".$row['id']."' onsubmit='remove_user(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                "
                .
                "</div>";
            })
            ->editColumn('user', function(User $user){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$user->full_name}</span>
                    </div>
                ";
            })
            ->editColumn('is_admin', function(User $user){
                return $user->is_admin ? '<span class="badge bg-success">'. __("dashboard.admin") .'</span>' : '<span class="badge bg-danger">'. __("dashboard.not-admin") .'</span>';
            })
            ->editColumn('phone', function(User $user){
                return "+" . $user->country_code . $user->phone;
            })
            ->editColumn('role', function(User $user){
                return $user->is_admin ? '<span class="badge bg-primary">'. $user->getRoleNames()[0] .'</span>' : '';
            })
            ->rawColumns(['user', 'is_admin', 'role', 'action'])
            ->make(true);
        }
        return view('dashboard.users.index');
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
    public function show(string $id)
    {
        //
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
    public function destroy(User $user)
    {
        self::delete_user_articles($user);
        if(Storage::disk('public')->exists($user->image))
        {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();
    }

    private static function delete_user_articles(User $user)
    {
        foreach($user->articles() as $article)
        {
            if(Storage::disk('public')->exists($article->cover))
            {
                Storage::disk('public')->delete($article->cover);
            }

            foreach($article->images() as $image)
            {
                if(Storage::disk('public')->exists($image->url))
                {
                    Storage::disk('public')->delete($image->url);
                }
    
                $image->delete();
            }
            $article->delete();
        }
    }
}
