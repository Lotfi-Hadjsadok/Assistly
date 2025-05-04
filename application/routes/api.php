<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/knowledge/docs', function (Request $request) {
    $filePath = $request->get('filePath');

    if (!Storage::disk('local')->exists($filePath)) {
        return response()->json(['message' => 'File not found'], 404);
    }

    $file = Storage::disk('local')->path($filePath);

    return response()->file($file);
});
