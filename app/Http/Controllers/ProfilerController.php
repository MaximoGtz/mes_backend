<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Insertion;
use App\Models\Profiler;
use Carbon\Carbon;
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
        if (!$profiler) {
            return response()->json([
                "message" => "Profiler not found"
            ], 404);
        }
        $today_inserctions = Insertion::where('machine_number', $profiler->number)
            ->whereDate('created_at', Carbon::today())->count();
        return response()->json([
            "message" => "Profile and insertions correctly consulted.",
            "insertions today" => $today_inserctions,
            "profiler" => $profiler
        ], 200);
    }
}
