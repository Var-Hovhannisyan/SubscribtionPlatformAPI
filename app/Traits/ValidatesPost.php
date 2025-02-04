<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ValidatesPost
{
    /**
     * Validate website request data.
     */
    public function validatePostRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'website_id' => ['required', 'integer', 'exists:websites,id'],
        ]);
    }
}
