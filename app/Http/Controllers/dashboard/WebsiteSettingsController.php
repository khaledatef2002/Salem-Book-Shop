<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;

class WebsiteSettingsController extends Controller implements HasMiddleware
{
    public static function Middleware()
    {
        return [
            new Middleware('can:website_settings_show', only: ['index']),
            new Middleware('can:website_settings_edit', only: ['change_logo', 'change_banner', 'update']),
        ];
    }
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
            ->scale(width: 250)
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
            ->scale(height: 250)
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
        $data = $request->validate([
            'site_title' => ['required', 'array'],
            'site_title.*' => ['required', 'min:2'],
            'author' => ['required', 'string', 'min:2', 'max:15'],
            'keywords' => ['required'],
            'description' => ['required', 'array'],
            'description' => ['required']
        ]);

        $setting = WebsiteSetting::find(1);
        $setting->update($data);
    }
}
