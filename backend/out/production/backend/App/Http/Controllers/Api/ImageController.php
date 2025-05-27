<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image file found'], 400);
        }

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/images', $filename);

        $url = asset('storage/images/' . $filename);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'image_url' => $url
        ]);
    }
}

