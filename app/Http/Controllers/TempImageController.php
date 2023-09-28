<?php

namespace App\Http\Controllers;

use App\Models\TempImage;
use Illuminate\Http\Request;

class TempImageController extends Controller
{
    public function index(Request $request)
    {
        $image = $request->image;
        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $tempImage = new TempImage();
            $tempImage->name = 'name';
            $tempImage->save();
            $newName = $tempImage->id . '_' . time() . '.' . $ext;
            $tempImage->name = $newName;
            $tempImage->save();
            $image->move(public_path() . '/temp/', $newName);
            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'imagePath' => asset('/temp/' . $newName),
                'message' => 'image Uploaded'
            ]);
        }

    }

    public function allImages(Request $request)
    {
        $images = TempImage::get();

    }
}