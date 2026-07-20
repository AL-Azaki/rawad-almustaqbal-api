<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }
    /**
     * Display a listing of published blog posts with optional search and category filter.
     */
    public function index(Request $request)
    {
        $query = BlogPost::published();

        // Search filter
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('content_ar', 'like', "%{$search}%")
                  ->orWhere('content_en', 'like', "%{$search}%")
                  ->orWhere('excerpt_ar', 'like', "%{$search}%")
                  ->orWhere('excerpt_en', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->input('category') !== 'الكل' && $request->input('category') !== 'All') {
            $cat = $request->input('category');
            $query->where(function ($q) use ($cat) {
                $q->where('category_ar', $cat)
                  ->orWhere('category_en', $cat);
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->get();

        return response()->json($posts, 200);
    }

    /**
     * Display the specified blog post by ID or Slug.
     */
    public function show($idOrSlug)
    {
        $post = BlogPost::where('slug', $idOrSlug)
            ->orWhere('id', $idOrSlug)
            ->first();

        if (!$post) {
            return response()->json(['message' => 'Blog post not found'], 404);
        }

        // Fetch related posts (same category, excluding current)
        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                $q->where('category_ar', $post->category_ar)
                  ->orWhere('category_en', $post->category_en);
            })
            ->limit(3)
            ->get();

        // If not enough related in same category, fill with latest published posts
        if ($relatedPosts->count() < 3) {
            $additional = BlogPost::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->orderBy('published_at', 'desc')
                ->limit(3 - $relatedPosts->count())
                ->get();

            $relatedPosts = $relatedPosts->merge($additional);
        }

        return response()->json([
            'post' => $post,
            'related_posts' => $relatedPosts
        ], 200);
    }

    /**
     * Admin: Store a newly created blog post.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|unique:blog_posts,slug',
            'title_ar' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'category_ar' => 'nullable|string|max:100',
            'status' => 'nullable|in:published,draft',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->mediaService->uploadImage($request->file('image'), 'blog');
        }

        if (empty($data['published_at']) && ($data['status'] ?? 'published') === 'published') {
            $data['published_at'] = Carbon::now();
        }

        $post = BlogPost::create($data);

        return response()->json($post, 201);
    }

    /**
     * Admin: Update the specified blog post.
     */
    public function update(Request $request, $id)
    {
        $post = BlogPost::find($id);

        if (!$post) {
            return response()->json(['message' => 'Blog post not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'slug' => 'nullable|string|unique:blog_posts,slug,' . $post->id,
            'title_ar' => 'nullable|string|max:255',
            'content_ar' => 'nullable|string',
            'status' => 'nullable|in:published,draft',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $newImagePath = $this->mediaService->uploadImage($request->file('image'), 'blog');
            if ($post->image_path && $post->image_path !== $newImagePath) {
                $this->mediaService->deleteMedia($post->image_path);
            }
            $data['image_path'] = $newImagePath;
        }

        $post->update($data);

        return response()->json($post, 200);
    }

    /**
     * Admin: Remove the specified blog post from storage (soft delete).
     */
    public function destroy($id)
    {
        $post = BlogPost::find($id);

        if (!$post) {
            return response()->json(['message' => 'Blog post not found'], 404);
        }

        if ($post->image_path) {
            $this->mediaService->deleteMedia($post->image_path);
        }

        $post->delete();

        return response()->json(['message' => 'Blog post deleted successfully'], 200);
    }
}
