<?php

namespace App\Http\Controllers\front;

use App\ApproavedStatusType;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogLike;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;


class BlogsController extends Controller implements HasMiddleware
{
    const page_limit = 13;

    public function index()
    {
        $blogs = Blog::where('approaved', ApproavedStatusType::approaved->value)->orderByDesc('created_at')->paginate(self::page_limit);

        foreach ($blogs as $blog)
        {
            $blog->isTruncated = isTrunctable($blog->content, 50);
            $blog->content = truncatePost($blog->content, 50);
        }

        return view('front.blogs.view-all', compact('blogs'));
    }

    public static function middleware()
    {
        return [
            new Middleware('auth', only:['destroy', 'store', 'edit', 'update'])
        ];
    }

    public function likeAction(Request $request)
    {
        $request->validate([
            'id' => 'exists:blogs'
        ]);

        $blog = Blog::find('id');

        if(!$blog->approaved) abort(404);

        $like = BlogLike::where('blog_id', $request->id)->where('user_id', Auth::user()->id);

        $state = __('custom.liked');

        if($like->count() > 0)
        {
            $like->delete();
            $state = __('custom.like');
        }
        else
        {
            BlogLike::create([
                'blog_id' => $request->id,
                'user_id' => Auth::user()->id
            ]);
        }
        $likes = BlogLike::where('blog_id', $request->id)->count();

        return json_encode(['state' => $state, 'likes_count' => $likes]);
    }

    public function getAllBlogsAjax(Request $request)
    {
        $limit = $request->query('limit', self::page_limit);
        $search = $request->query('search', '');
        
        $blogs = Blog::where('approaved', ApproavedStatusType::approaved->value)->withCount('likes');
        if($search)
        {
            $blogs->whereHas('user', function($q) use ($search){
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        }

        switch($request->query('sort_by'))
        {
            case 'publish-old':
                $blogs->orderBy('created_at');
                break;
            case 'likes-highest':
                $blogs->orderByDesc('likes_count');
                break;
            case 'likes-lowest':
                $blogs->orderBy('likes_count');
                break;
            default:
                $blogs->orderByDesc('created_at');
        }

        if($request->query('type'))
        {
            if($request->type == 'my' && Auth::check())
            {
                $blogs = $blogs->where('user_id', Auth::user()->id);
            }
        }

        $blogs = $blogs->paginate($limit);
        

        return view('front.parts.blogs-list', compact('blogs'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $image = $request->file('upload');
        $manager = new ImageManager(new GdDriver());
        $optimizedImage = $manager->read($image)
            ->scale(height: 150)
            ->encode(new AutoEncoder(quality: 75));
            
        $imagePath = 'blogs/images/' . uniqid() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->put($imagePath, (string) $optimizedImage);
        $url = Storage::url($imagePath);

        return response()->json(['url' => $url]);
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
        $request->validate([
            'content' => 'required|string',
        ]);

        $blog = Blog::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response(__('custom.adding-blog-waiting-for-approave'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        if(!$blog->approaved) abort(404);

        $comments = $blog->comments()->orderByDesc('created_at')->paginate(13);
        return view('front.blogs.single-blog', compact('blog', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if(!$blog->approaved) abort(404);

        if ($blog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return json_encode($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        if(!$blog->approaved) abort(404);

        if ($blog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $blog->update($request->only('content'));

        return view('front.parts.blogs-list-item', compact('blog'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Blog $blog)
    {
        if(!$blog->approaved) abort(404);

        if ($blog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $blog->delete();

        if($request->return == 'all-blogs')
            return view('front.blogs.deleted');
    }

    public function addComment(Request $request)
    {
        $request->validate([
            'blog_id' => ['required', 'exists:blogs,id'],
            'comment' => ['required', 'min:1', 'max:400']
        ]);
        
        $blog = Blog::find($request->blog_id)->first();

        if(!$blog->approaved) abort(404);

        $user_id = Auth::user()->id;

        BlogComment::create([
            'blog_id' => $request->blog_id,
            'user_id' => $user_id,
            'comment' => $request->comment
        ]);


        return view('front.parts.single-blog-comments', compact('blog'));
    }

    public function deleteComment(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'comment_id' => ['required', 'exists:blog_comments,id'],
        ]);
        
        BlogComment::where('id', $request->comment_id)->where('user_id', $user_id)->first()->delete();
    }

    public function editComment(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'comment_id' => ['required', 'exists:blog_comments,id'],
            'comment' => ['required', 'min:1', 'max:400']
        ]);
        
        BlogComment::where('id', $request->comment_id)->where('user_id', $user_id)->first()->update([
            'comment' => $request->comment
        ]);

        return $request->comment;
    }
}
