<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
  public function upload(ImageUploadRequest $request)
  {
    // FLOW: 1
    $file = $request->file('file');
    $directory = $request->input('directory');

    // FLOW: 2
    $path = $file->store($directory, 'public');
    $url = asset(Storage::url($path));

    // FLOW: 3
    $image = Image::create([
      'url'       => $url,
      'directory' => $directory,
    ]);

    // FLOW: 4
    return response()->json([
      'id'  => $image->id,
      'url' => $image->url,
    ]);
  }
}
