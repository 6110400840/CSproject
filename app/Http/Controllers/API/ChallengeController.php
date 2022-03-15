<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ImageTrait;
use App\Models\Challenge;
use App\Models\Image;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    use ImageTrait;
    
    public function getAllChallenge()
    {
        return Challenge::all();
    }
    
    public function getChallenge(Request $request)
    {
        return Challenge::find($request->id);
    }
    
    public function imageStore(Request $request)
    {
        //store image to app.
        //not done yet.
        $validatedData = $request->validate([
         'image' => 'required|image|mimes:jpg,png,jpeg,svg|max:2048',
        ]);
        
        if (!$validatedData) {
            return response()->json([
                'message' => 'Data must be (jpg,png,jpeg,svg).'
            ]);
        }

        if($fileData = $this->uploads($request->file('image'), $request->name)) {
            return response()->json([
                "success" => true,
                "message" => "test succesfully"
            ]);
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
        $challenge = Challenge::where('name', $request->name);
        if ($challenge->exists()) {
            $challenge->delete();
            return response()->json([
                "message" => "Challenge " . $request->name . " successfully deleted."
            ]);
        }

        return response()->json([
            "message" => "Challenge " . $request->name . " not found."
        ]);
    }

    public function test(Request $request)
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

    public function test2(Request $request)
    {
        //store image to app
        $validatedData = $request->validate([
         'image' => 'required|image|mimes:jpg,png,jpeg,svg|max:2048',
        ]);
        
        if (!$validatedData) {
            return response()->json([
                'message' => 'Data must be (jpg,png,jpeg,svg).'
            ]);
        }

        if($fileData = $this->uploads($request->file('image'), $request->name)) {
            return response()->json([
                "success" => true,
                "message" => "test succesfully"
            ]);
        }
        return response()->json([
            "success" => false,
            "message" => "test fail"
        ]);
    }
}