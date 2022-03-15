<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function createChapter(Request $request)
    {
        $chapter = Chapter::create([
            'name' => $request->name
        ]);
        
        return response()->json([
            "message" => "Chapter " . $request->name . " successfully created."
        ]);
    }
    
    public function updateChapter(Request $request)
    {
        $chapter = Chapter::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name]
        );

        return response()->json([
            "message" => "Chapter " . $request->name . " successfully updated."
        ]);
    }

    public function getAllChapter()
    {
        return Chapter::all();
    }

    public function getChapterChallenges(Request $request)
    {
        return Chapter::find($request->id)->challenges;
    }
    
    public function deleteChapter(Request $request)
    {
        $chapter = Chapter::find($request->id);
        if ($chapter->exists()) {
            $chapter->delete();
            return response()->json([
                "message" => "Chapter " . $request->id . " successfully deleted."
            ]);
        }

        return response()->json([
            "message" => "Chapter " . $request->id . " not found."
        ]);
    }
}