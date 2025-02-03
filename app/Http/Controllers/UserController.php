<?php

namespace App\Http\Controllers;

use App\Interfaces\Custom\ResponseInterface;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected ResponseInterface $responseService;
    protected UserInterface $userService;
    public function __construct(ResponseInterface $responseService, UserInterface $userService) {
        $this->responseService = $responseService;
        $this->userService = $userService;
    }

    public function current(): JsonResponse
    {
        $user = $this->userService->getCurrentUser();

        if (!$user) {
            return $this->responseService->responseJson(null, 404, "User not found");
        }

        return $this->responseService->responseJson($user, 200);
    }

    public function show(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->getUserById((int) $request->get('id'));

            if (!$user) {
                return $this->responseService->responseJson(null, 404, "User not found");
            }
            return $this->responseService->responseJson($user, 200);
        } catch (\Throwable $exception) {
            \Log::error("Failed to fetch user", ['error' => $exception->getMessage()]);

            return $this->responseService->responseJson(
                null,
                500,
                "Internal Server Error"
            );
        }
    }

}
