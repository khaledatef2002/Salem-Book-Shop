<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role as ModelsRole;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Spatie\Permission\Models\Role;


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
                (Auth::id() != $row['id'] ?
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
                : '')
                .
                "</div>";
            })
            ->editColumn('user', function(User $user){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$user->full_name} ". (Auth::id() == $user->id ? '(You)' : '') ."</span>
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
        $roles = ModelsRole::all();
        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role_validation  = [];
        $request['is_admin'] = $request->is_admin == 'on' ? 1 : 0;
        if($request->is_admin)
            $role_validation = ['role' => ['required', 'exists:roles,id']];

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:12'],
            'last_name' => ['required', 'string', 'max:12'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', Rule::unique(User::class)],
            'password' => ['required', Rules\Password::defaults()],
            'country_code' => ['required', 'numeric', 'digits_between:1,4'],
            'is_admin' => ['boolean'],
            'phone' => ['required', 'numeric'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg|max:10240'],
            ...$role_validation
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imagePath = 'users/' . uniqid() . '.' . $image->getClientOriginalExtension();
    
            $manager = new ImageManager(new GdDriver());
            $optimizedImage = $manager->read($image)
                ->cover(250, 250)
                ->encode(new AutoEncoder(quality: 75));

            Storage::disk('public')->put($imagePath, (string) $optimizedImage);
    
            $data['image'] = $imagePath;
        }

        $user = User::create($data);

        $role = Role::find($request->role);

        $user->assignRole($role->name);

        return response()->json(['redirectUrl' => route('dashboard.users.edit', $user)]);
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
    public function edit(User $user)
    {
        $roles = ModelsRole::all();
        return view('dashboard.users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $role_validation  = [];
        $password_validation = [];
        $image_validation = [];

        if($request->password)
            $password_validation = ['password' => ['required', Rules\Password::defaults()]];

        if($request->hasFile('image'))
        {
            $image_validation = ['image' => ['required', 'image', 'mimes:jpeg,png,jpg|max:10240']];
        }

        $request['is_admin'] = $request->is_admin == 'on' ? 1 : 0;
        if($request->is_admin)
            $role_validation = ['role' => ['required', 'exists:roles,id']];

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:12'],
            'last_name' => ['required', 'string', 'max:12'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', Rule::unique(User::class)->ignore($user->id)],
            ...$password_validation,
            'country_code' => ['required', 'numeric', 'digits_between:1,4'],
            'is_admin' => ['boolean'],
            'phone' => ['required', 'numeric'],
            ...$image_validation,
            ...$role_validation
        ]);

        if ($request->hasFile('image')) {

            if(Storage::disk('public')->exists($user->image))
            {
                Storage::disk('public')->delete($user->image);
            }

            $image = $request->file('image');
            $imagePath = 'users/' . uniqid() . '.' . $image->getClientOriginalExtension();
    
            $manager = new ImageManager(new GdDriver());
            $optimizedImage = $manager->read($image)
                ->cover(250, 250)
                ->encode(new AutoEncoder(quality: 75));

            Storage::disk('public')->put($imagePath, (string) $optimizedImage);
    
            $data['image'] = $imagePath;
        }

        $user->update($data);

        $role = Role::find($request->role);

        $user->assignRole($role->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        self::delete_user_articles($user);
        if(Storage::disk('public')->exists($user->image ?? ''))
        {
            Storage::disk('public')->delete($user->image ?? '');
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
