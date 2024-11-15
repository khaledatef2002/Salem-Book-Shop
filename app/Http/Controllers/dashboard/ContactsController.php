<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContactsController extends Controller implements HasMiddleware
{
    public static function Middleware()
    {
        return [
            new Middleware('can:contacts_show', only: ['show', 'index']),
            new Middleware('can:contacts_delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $articles = Contact::get();
            return DataTables::of($articles)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                "
                    <a href='tel:+".$row['country_code']. $row['phone'] ."'><i class='ri-phone-line fs-4'></i></a>
                    <a href='https::/wa.me/+".$row['country_code']. $row['phone'] ."'><i class='ri-whatsapp-line fs-4'></i></a>
                    <a href='mailto:".$row['email']."'><i class='ri-mail-line fs-4'></i></a>
                    <button class='remove_button' onclick='openMessage({$row['id']})'><i class='ri-eye-line fs-4' type='submit'></i></button>
                "
                .
                ( Auth::user()->hasPermissionTo('contacts_delete') ?
                "
                    <form id='remove_contact' data-id='".$row['id']."' onsubmit='remove_contact(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":""
                )
                .
                "</div>";
            })
            ->addColumn('user', function(Contact $contact){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($contact->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$contact->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('email', function(Contact $contact){
                return $contact->user->email;
            })
            ->editColumn('message', function(Contact $contact){
                return truncatePostAndRemoveImages($contact->message, 150);
            })
            ->editColumn('phone', function(Contact $contact){
                return "+" . $contact->user->country_code . $contact->user->phone;
            })
            ->rawColumns(['message', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.contacts.index');
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
    public function show(Contact $contact)
    {
        $contact->load('user');
        return response()->json($contact);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
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
    public function destroy(Contact $contact)
    {
        $contact->delete();
    }
}
