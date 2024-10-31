<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;

class WebsiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.website_settings.index');
    }

    public function change_logo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg|max:10240']
        ]);

        $image = $request->file('logo');
        $imagePath = 'others/' . uniqid() . '.' . $image->getClientOriginalExtension();

        $manager = new ImageManager(new GdDriver());
        $optimizedImage = $manager->read($image)
            ->resize(250, 250, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode(new AutoEncoder(quality: 75));

        Storage::disk('public')->put($imagePath, (string) $optimizedImage);

        $setting = WebsiteSetting::find(1);

        if(Storage::disk('public')->exists($setting->logo))
        {
            Storage::disk('public')->delete($setting->logo);
        }

        $setting->logo = $imagePath;

        $setting->save();
    }

    public function change_banner(Request $request)
    {
        $request->validate([
            'banner' => ['required', 'image', 'mimes:jpeg,png,jpg|max:10240']
        ]);

        $image = $request->file('banner');
        $imagePath = 'others/' . uniqid() . '.' . $image->getClientOriginalExtension();

        $manager = new ImageManager(new GdDriver());
        $optimizedImage = $manager->read($image)
            ->resize(250, 250, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode(new AutoEncoder(quality: 75));

        Storage::disk('public')->put($imagePath, (string) $optimizedImage);

        $setting = WebsiteSetting::find(1);

        if(Storage::disk('public')->exists($setting->banner))
        {
            Storage::disk('public')->delete($setting->banner);
        }

        $setting->banner = $imagePath;

        $setting->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_title' => ['required', 'min:2', 'max:15'],
            'author' => ['required', 'string', 'min:2', 'max:15'],
            'keywords' => ['required'],
            'description' => ['required']
        ]);

        $setting = WebsiteSetting::find(1);
        $setting->update([
            'site_title' => $request->site_title,
            'author' => $request->author,
            'keywords' => $request->keywords,
            'description' => $request->description,
        ]);
    }
}
