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

    public function createChallenge(Request $request)
    {
        $json_data = json_decode($request->json);
        $fileData = $this->uploads($request->file('image'), $json_data->name);
        $json_fileData = json_decode(json_encode($fileData));

        $challenge = Challenge::create([
            'name'        => $json_data->name,
            'description' => $json_data->description,
            'hint'        => $json_data->hint,
            'chapter_id'  => $json_data->chapter_id
        ]);

        if ($fileData) {

            $image = Image::create([
                'name'         => $json_fileData->name,
                'type'         => $json_fileData->type,
                'path'         => $json_fileData->path,
                'size'         => $json_fileData->size,
                'challenge_id' => $challenge->id
            ]);

            return response()->json([
                "success" => true,
                "message" => "Challenge create succesfully."
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Challenge created fail."
        ]);
        
        return response()->json([
            "message" => "Chapter " . $request->name . " successfully created."
        ]);
    }
    
    public function updateChallenge(Request $request)
    {
        $chapter = Challenge::updateOrCreate(
            ['id' => $request->id],
            [
                'name'        => $request->name,
                'description' => $request->description,
                'hint'        => $request->hint,
                'chapter_id'  => $request->chapter_id
            ]
        );

        return response()->json([
            "message" => "Chapter " . $request->id . " successfully updated."
        ]);
    }

    public function getAllChallenge()
    {
        return Challenge::all();
    }
    
    public function getChallenge(Request $request)
    {
        return Challenge::findOrFail($request->id);
    }
    
    public function deleteChallenge(Request $request)
    {
        $challenge = Challenge::findOrFail($request->id);
        if ($challenge->exists()) {
            $challenge->image->delete();
            $challenge->delete();
            return response()->json([
                "message" => "Challenge " . $request->id . " successfully deleted."
            ]);
        }

        return response()->json([
            "message" => "Challenge  " . $request->id . " not found."
        ]);
    }
    
    public function getDeletedChallenges()
    {
        return Challenge::onlyTrashed()->get();
    }
    
    public function getDeletedChallenge(Request $request)
    {
        return Challenge::withTrashed()->find($request->id)->get();
    }
    
    public function deletedChallengesRestore()
    {
        return Challenge::withTrashed()->restore();
    }
    
    public function deletedChallengeRestore(Request $request)
    {
        return Challenge::withTrashed()->find($request->id)->restore();
    }
    
    public function permanentDeleteChallenges()
    {
        return Challenge::withTrashed()->forceDelete();
    }
    
    public function permanentDeleteChallenge(Request $request)
    {
        return Challenge::withTrashed()->find($request->id)->forceDelete();
    }

    public function imageCompare(Request $request)
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