<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
        ]);
    }
}
