<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ImageTrait;
use App\Models\Challenge;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    //not done yet.
    use ImageTrait;
    
    public function index()
    {
        return Image::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
         'image' => 'required|image|mimes:jpg,png,jpeg,svg|max:2048',
        ]);
        
        if (!$validatedData) {
            return response()->json([
                'message' => 'Data must be (jpg,png,jpeg,svg).'
            ]);
        }

        if($image = $request->file('image')) {
            $imageData = $this->uploads($image);
            $image = Image::updateOrCreate(
                        [
                           'name' => $imageData['imageName'],
                           'challenge_id' => $request->challenge_id,
                        ],
                        [
                           'type' => $imageData['imageType'],
                           'path' => $imageData['imagePath'],
                           'size' => $imageData['imageSize']
                        ]
                    );
                    return $image;
        }
        return response()->json([
            "success" => false,
            "message" => "test fail"
        ]);
    }
    
    public function show(Request $request)
    {
        $challenge = Challenge::where('name', $request->name);
        if ($challenge->exists()) {
            return Challenge::where('name', $request->name)->first();
        }

        return response()->json([
            "message" => "Challenge " . $request->name . " not found."
        ]);
    }
    
    public function destroy(Request $request)
    {
        $image = Image::where('name', $request->name);
        if ($image->exists()) {
            $image->delete();
            return response()->json([
                "message" => "Image " . $request->name . " successfully deleted."
            ]);
        }

        return response()->json([
            "message" => "Image " . $request->name . " not found."
        ]);
    }

    public function compare(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,svg|max:2048',
        ]);
        $name = $request->file('image')->getClientOriginalName();
        $path = storage_path().'/app/public/images/cat.png';
        
        $localImage = file_get_contents($path);
        $requestImage = file_get_contents($request->file('image'));
        $base64 = base64_encode($localImage);
        $test = base64_encode($requestImage);

        if ($base64 != $test) {
            return response()->json([
                "success" => true,
                "message" => "test Fail"
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "test Successfully"
        ]);
    }
}