<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuilderController extends Controller
{
    /**
     * Handle image uploads coming from the content builder.
     * Returns the public URL of the stored image as JSON.
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $path = $request->file('image')->store('builder', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }
}
