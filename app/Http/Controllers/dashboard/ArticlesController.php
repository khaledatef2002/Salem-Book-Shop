<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $articles = Article::get();
            return DataTables::of($articles)
            ->rawColumns(['action'])
            ->addColumn('action', function($row){
                return 
                "<div class='d-flex align-items-center justify-content-center gap-2'>"
                .
                "
                    <a href='" . route('dashboard.article-comments.index', $row['id']) . "'><i class='ri-message-2-line fs-4' type='submit'></i></a>
                    <a href='" . route('dashboard.article-likes.index', $row['id']) . "'><i class='ri-thumb-up-line fs-4' type='submit'></i></a>
                    <a href='" . route('front.article.show', $row['id']) . "' target='_blank'><i class='ri-eye-line fs-4' type='submit'></i></a>
                    <a href='" . route('dashboard.articles.edit', $row) . "'><i class='ri-settings-5-line fs-4' type='submit'></i></a>    
                "
                .

                "
                    <form id='remove_book' data-id='".$row['id']."' onsubmit='remove_book(event, this)'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button class='remove_button' onclick='remove_button(this)' type='button'><i class='ri-delete-bin-5-line text-danger fs-4'></i></button>
                    </form>
                "
                .
                "</div>";
            })
            ->addColumn('user', function(Article $article){
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <img src='" . asset($article->user->display_image) ."' width='40' height='40' class='rounded-5'>
                        <span>{$article->user->full_name}</span>
                    </div>
                ";
            })
            ->addColumn('likes', function(Article $article){
                return $article->likes()->count();
            })
            ->addColumn('comments', function(Article $article){
                return $article->comments()->count();
            })
            ->editColumn('content', function(Article $article){
                return truncatePostAndRemoveImages($article->content, 150);
            })
            ->editColumn('cover', function(Article $article){
                return "<a href='" . asset('storage/' . $article->cover) . "' target='_blank'><img src='" . asset('storage/' . $article->cover) ."' width='80' class='rounded-2'></a>";
            })
            ->rawColumns(['cover', 'content', 'user', 'action'])
            ->make(true);
        }
        return view('dashboard.articles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.articles.create');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $image = $request->file('upload');
        $manager = new ImageManager(new GdDriver());
        $optimizedImage = $manager->read($image)
            ->resize(250, 250, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode(new AutoEncoder(quality: 75));
            
        $imagePath = 'temp/' . uniqid() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->put($imagePath, (string) $optimizedImage);
        $url = Storage::url($imagePath);

        return response()->json(['url' => $url]);
    }

    public function removeImage(Request $request)
    {
        $request->validate(['url' => 'required|string']);

        // Get the file path from the URL
        $url = $request->input('url');
        $path = parse_url($url, PHP_URL_PATH); // Extract file path from URL
        $path = str_replace('/storage/', '', $path); // Adjust if using 'storage' in the URL

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'min:2', 'max:40'],
            'content' => ['required', 'min:2', 'max:800'],
            'category_id' => ['required', 'exists:article_categories,id'],
            'keywords' => ['required'],
            'cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:20480']
        ]);

        $content = $data['content'];

        $uploadedImages = $request->images ?? [];

        $article_images = [];

        foreach ($uploadedImages as $tempPath) {
            // Generate the new permanent path
            $permanentPath = str_replace('/storage/temp', 'articles/images', $tempPath);

            $currentPublicPath = str_replace('/storage/', '', $tempPath);
            
            // Move the image to the permanent directory
            Storage::disk('public')->move($currentPublicPath, $permanentPath);
    
            // Replace temp URLs with the new URLs in the content
            $permanentUrl = Storage::url($permanentPath);
            $article_images[] = $permanentUrl;
            $content = str_replace($tempPath, $permanentUrl, $content);
        }

        $data['content'] = $content;
        $data['user_id'] = Auth::id();

        $cover = $request->file('cover');
        $manager = new ImageManager(new GdDriver());
        $optimizedCover = $manager->read($cover)
            ->resize(250, 250, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode(new AutoEncoder(quality: 75));
            
        $coverPath = 'articles/' . uniqid() . '.' . $cover->getClientOriginalExtension();
        Storage::disk('public')->put($coverPath, (string) $optimizedCover);
        $data['cover'] = $coverPath;
 
        $article = Article::create($data);

        foreach($article_images as $image)
        {
            ArticleImage::create([
                'article_id' => $article->id,
                'url' => $image
            ]);
        }

        return response()->json(['redirectUrl' => route('dashboard.articles.edit', $article)]);
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
    public function edit(Article $article)
    {
        return view('dashboard.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $cover_validation = [];

        if($request->file('cover'))
        {
            $cover_validation = ['cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:20480']];
        }
        $data = $request->validate([
            'title' => ['required', 'min:2', 'max:40'],
            'content' => ['required', 'min:2', 'max:800'],
            'category_id' => ['required', 'exists:article_categories,id'],
            'keywords' => ['required'],
            $cover_validation
        ]);

        $content = $data['content'];

        // Getiing all images urls
        $urls = extractImagesSrc($content);

        // Filter urls to get the already uploaded
        $oldURLS = [];
        foreach ($urls as $url)
        {
            if(!str_starts_with($url, '/storage/temp'))
            {
                $oldURLS[] = $url;
            }
        }

        // Check if the user removed any image and delete it
        $oldImages = $article->images;
        foreach($oldImages as $image)
        {
            if(!in_array($image->url, $oldURLS))
            {
                if(Storage::exists($image->url))
                {
                    Storage::delete($image->url);
                }

                $image->delete();
            }
        }

        // Upload the new images
        $uploadedImages = $request->images ?? [];

        $article_images = [];

        foreach ($uploadedImages as $tempPath) {
            // Generate the new permanent path
            $permanentPath = str_replace('/storage/temp', 'articles/images', $tempPath);

            $currentPublicPath = str_replace('/storage/', '', $tempPath);
            
            // Move the image to the permanent directory
            Storage::disk('public')->move($currentPublicPath, $permanentPath);
    
            // Replace temp URLs with the new URLs in the content
            $permanentUrl = Storage::url($permanentPath);
            $article_images[] = $permanentUrl;
            $content = str_replace($tempPath, $permanentUrl, $content);
        }

        $data['content'] = $content;
        $data['user_id'] = Auth::id();

        // upload the new cover if exists
        if($request->file('cover'))
        {
            // Delete the old one if exists
            if(Storage::disk('public')->exists($article->cover))
            {
                Storage::disk('public')->delete($article->cover);
            }

            $cover = $request->file('cover');
            $manager = new ImageManager(new GdDriver());
            $optimizedCover = $manager->read($cover)
                ->resize(250, 250, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode(new AutoEncoder(quality: 75));
                
            $coverPath = 'articles/' . uniqid() . '.' . $cover->getClientOriginalExtension();
            Storage::disk('public')->put($coverPath, (string) $optimizedCover);
            $data['cover'] = $coverPath;
        }
 
        $article->update($data);

        foreach($article_images as $image)
        {
            ArticleImage::create([
                'article_id' => $article->id,
                'url' => $image
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        foreach($article->images as $image)
        {
            if(Storage::exists($image->url))
            {
                Storage::delete($image->url);
            }

            $image->delete();
        }

        if(Storage::disk('public')->exists($article->cover))
        {
            Storage::disk('public')->delete($article->cover);
        }

        $article->delete();
    }
}
