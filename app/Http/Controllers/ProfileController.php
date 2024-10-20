<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('front.profile.index');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg|max:10240']
            ]);
            
            if ($user->image) {
                Storage::delete($user->image);
            }

            $image = $request->file('image');
            $imagePath = 'users/' . uniqid() . '.' . $image->getClientOriginalExtension();
    
            
            $extension = strtolower($image->getClientOriginalExtension());
            $manager = new ImageManager(new GdDriver());
            $optimizedImage = $manager->read($image)
                ->resize(250, 250, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode(new AutoEncoder(quality: 75));

            Storage::disk('public')->put($imagePath, (string) $optimizedImage);
    
            $user->image = $imagePath;
        }

        $request->validate([
            'first_name' => ['required', 'string', 'max:12'],
            'last_name' => ['required', 'string', 'max:12'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', Rule::unique(User::class)->ignore($user->id)],
        ]);

        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'Profile general info updated successfully']);
    }

    public function update_password(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Profile password updated successfully']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
