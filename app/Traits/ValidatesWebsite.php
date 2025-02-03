<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ValidatesWebsite
{
    /**
     * Validate website request data.
     */
    public function validateWebsiteRequest(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255', 'unique:websites'],
        ]);
    }
}
