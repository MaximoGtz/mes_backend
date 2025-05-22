<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Insertion;
use App\Models\Profiler;
class ProfilerController extends Controller
{
    //
    public function testRoute()
    {
        return response()->json([
            "message" => "Test correct",

        ], 200);
    }
    public function getProfiler(int $id)
    {
        $profiler = Profiler::find($id);
        $insertions = $profiler->insertions;
        return response()->json([
            "message" => "Profile and insertions correctly consulted.",
            "profiler" => $profiler
        ], 200);
    }
}
