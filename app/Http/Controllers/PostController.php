<?php

namespace App\Http\Controllers;

use App\Interfaces\Custom\ResponseInterface;
use App\Interfaces\PostInterface;
use App\Models\Post;
use App\Traits\ValidatesPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index()
    {
        //
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
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatePostRequest($request);
        return $this->postService->createPost($request->user(), $validated);
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        $posts = $post::with('websites')->get()->toArray();
        return $this->responseService->responseJson($posts, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
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
