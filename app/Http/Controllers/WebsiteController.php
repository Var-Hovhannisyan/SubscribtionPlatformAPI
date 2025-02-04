<?php

namespace App\Http\Controllers;

use App\Interfaces\Custom\ResponseInterface;
use App\Interfaces\WebsiteInterface;
use App\Models\Website;
use App\Traits\ValidatesWebsite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    use ValidatesWebsite;

    protected ResponseInterface $responseService;
    protected WebsiteInterface $websiteService;

    public function __construct(ResponseInterface $responseService, WebsiteInterface $websiteService) {
        $this->responseService = $responseService;
        $this->websiteService = $websiteService;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateWebsiteRequest($request);
        return $this->websiteService->createWebsite($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website): JsonResponse
    {
        $websites = $website::with('posts')->with('subscribers')->get()->toArray();
        return $this->responseService->responseJson($websites, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website)
    {
        //
    }
}
