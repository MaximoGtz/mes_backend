<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProfilerRequest;
use Illuminate\Http\Request;
use App\Models\Insertion;
use App\Models\Profiler;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
class ProfilerController extends Controller
{
    public function getProfilerCardInfo(int $id)
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
    public function index()
    {
        $profilers = Profiler::all();
        if (!$profilers) {
            return response()->json([
                'message' => 'No profilers found'
            ], 404);
        }
        return response()->json([
            'message' => 'Profilers taken correctly',
            'profilers' => $profilers
        ]);
    }
    public function show($id)
    {
        $profiler = Profiler::find($id);

        if (!$profiler) {
            return response()->json([
                "message" => "Machine not found"
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json($profiler);
    }
    public function store(ProfilerRequest $request)
    {
        $validated_data = $request->validated();
        $profiler = Profiler::create($validated_data);
        return response()->json([
            "message" => "Profiler created",
            "profiler" => $profiler
        ]);
    }
    public function update(ProfilerRequest $request, $id)
    {
        $profiler = Profiler::find($id);
        if (!$profiler) {
            return response()->json([
                "message" => "Profiler not found"
            ], Response::HTTP_NOT_FOUND);
        }
        $validated_data = $request->validated();
        $profiler->update($validated_data);
        return response()->json([
            "message" => "Profiler updated",
            "profiler" => $profiler
        ]);

    }
    public function destroy($id)
    {
        $profiler = Profiler::find($id);
        if (!$profiler) {
            return response()->json([
                "message" => "Profiler not found"
            ], Response::HTTP_NOT_FOUND);
        }
        $profiler->delete();
        return response()->json([
            "message" => "Profiler succesfully deleted"
        ], 200);
    }

    public function getInsertions($id)
    {
        $profiler = Profiler::find($id);
        $insertions = Insertion::where("machine_number", "=", $profiler->number)->get();
        return response()->json($insertions);
    }

}
