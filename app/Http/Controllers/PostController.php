<?php

namespace App\Http\Controllers;

use App\Interfaces\Custom\ResponseInterface;
use App\Interfaces\PostInterface;
use App\Models\Post;
use App\Traits\ValidatesPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    use ValidatesPost;

    protected ResponseInterface $responseService;
    protected PostInterface $postService;

    public function __construct(ResponseInterface $responseService, PostInterface $postService)
    {
        $this->responseService = $responseService;
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatePostRequest($request);
        return $this->postService->createPost($validated);
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        $posts = $post::with('website')->get()->toArray();
        return $this->responseService->responseJson($posts, 200);
    }

    public function recent(Post $post): JsonResponse
    {
        $recentPosts = Cache::remember('recent_posts', 60, function () use ($post) {
            return $post::with('website')
                ->latest()
                ->take(5)
                ->get()
                ->toArray();
        });

        return $this->responseService->responseJson($recentPosts, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
