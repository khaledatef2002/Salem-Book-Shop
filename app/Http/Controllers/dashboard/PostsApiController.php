<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ApiPost;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\AutoEncoder;

class PostsApiController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $posts = ApiPost::all();
            return DataTables::of($posts)
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                ( Auth::user()->hasPermissionTo('people_edit') && $row['approved'] == false ?
                "
                    <button class='remove_button' onclick='approve_api_post({$row['id']})'><i class='ri-check-double-line text-success fs-4' type='submit'></i></button>
                " : ''
                )
                .
                ( Auth::user()->hasPermissionTo('people_delete') ?
                "
                    <form id='remove_people' class='mb-0' data-id='".$row['id']."' onsubmit='remove_people(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                ":""
                )
                .
                "</div>";
            })
            ->editColumn('imageUrl', function(ApiPost $posts){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . $posts->imageUrl ."' width='40' height='40' class='rounded-5'>
                    </div>
                ";
            })
            ->editColumn('created_at', function(ApiPost $posts){
                return $posts->created_at->diffForHumans();
            })
            ->rawColumns(['imageUrl', 'action'])
            ->make(true);
        }
        return view('dashboard.api.posts.index');
    }

    public function delete(Request $request, ApiPost $post)
    {
        $post->delete();
    }

    public function approve(Request $request, ApiPost $post)
    {
        // dd($request->all());
        $data = $request->validate([
            'category_id' => ['required', 'exists:article_categories,id'],
        ]);

        $date = now()->format('Y-m-d H:i');
        
        $title = [];
        $content = [];
        foreach (LaravelLocalization::getSupportedLocales() as $locale)
        {
            $title[$locale['locale']] = $post->title;
            $content[$locale['locale']] = $post->content;
        }

        $data['slug'] = [];

        foreach (LaravelLocalization::getSupportedLocales() as $locale)
        {
            $data['slug'][$locale['locale']] = Str::of($title[$locale['locale']] . '-' . $date)->trim()->lower()->replace(' ', '-');
        }

        $data['user_id'] = Auth::id();

        $imageUrl = $post->imageUrl;
        $imageContent = file_get_contents($imageUrl);
        if ($imageContent === false) {
            throw new Exception('Unable to retrieve the image from the provided URL.');
        }
        $manager = new ImageManager(new GdDriver());
        $optimizedCover = $manager->read($imageContent)
            ->scale(height:450)
            ->encode(new AutoEncoder("image/jpeg", quality: 75));

        $coverPath = 'articles/' . uniqid() . '.jpg';
        Storage::disk('public')->put($coverPath, (string) $optimizedCover);
        $data['cover'] = $coverPath;

        $article = Article::create([
            'title' => $title,
            'content' => $content,
            'category_id' => $data['category_id'],
            'slug' => $data['slug'],    
            'user_id' => $data['user_id'],  
            'cover' => $data['cover'],  
            'keywords' => " ",
        ]);

        $post->approved = true;
        $post->save();
        
        return response()->json(['message' => 'Post approved successfully']);

    }
}
