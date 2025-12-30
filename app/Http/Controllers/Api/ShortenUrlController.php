<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ShortenedUrl;
use Illuminate\Support\Str;

class ShortenUrlController extends Controller
{
    public function shortenUrl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $shortCode = Str::random(6);

        // Ensure unique short code
        while (ShortenedUrl::where('short_code', $shortCode)->exists()) {
            $shortCode = Str::random(6);
        }

        $shortenedUrl = ShortenedUrl::create([
            'user_id' => auth()->id(),
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'URL shortened successfully',
            'shortened_url' => url('/api/redirect/' . $shortCode),
            'short_code' => $shortCode
        ]);
    }

    public function redirect($shortCode)
    {
        $shortenedUrl = ShortenedUrl::where('short_code', $shortCode)->first();

        if (!$shortenedUrl) {
            return response()->json([
                'success' => false,
                'message' => 'Short URL not found'
            ], 404);
        }

        return redirect($shortenedUrl->original_url);
    }

    public function getUrls(Request $request)
    {
        $urls = auth()->user()->shortenedUrls;

        return response()->json([
            'success' => true,
            'urls' => $urls
        ]);
    }
}
