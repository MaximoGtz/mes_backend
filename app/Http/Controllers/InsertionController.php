<?php

namespace App\Http\Controllers;
use App\Models\Insertion;
use App\Models\Profiler;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\InsertionRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class InsertionController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->query("per_page", 12);
        $page = $request->query("page", 0);
        $offset = $page * $per_page;

        $profiler_id = $request->query("profiler_id", null);
        $date = $request->query("date", null);
        //TRABAJANDO PARA QUE FILTRE LAS BUSQUEDAS DE LAS INSERCIONES
        if ($profiler_id !== null && $date == null) {
            $profiler = Profiler::find($profiler_id);
            if (!$profiler) {
                return response()->json([
                    "message" => "Profiler not found"
                ], 404);
            }
            $total_insertions = Insertion::where("machine_number", "=", $profiler->number)->count();
            $insertions = Insertion::where("machine_number", "=", $profiler->number)->skip($offset)->take($per_page)->get();
        } else {

            $insertions = Insertion::skip($offset)->take($per_page)->get();
            $total_insertions = Insertion::all()->count();
        }
        //if you send parameters to the route, we can access it via Request by using query


        $residue = $total_insertions % $per_page;
        $last_page = $total_insertions / $per_page;
        if ($residue > 0) {
            // echo "La división tiene residuo: " . $residue;
            $last_page = floor($total_insertions / $per_page);
        } else {
            // echo "La división no tiene residuo";
            $last_page--;
        }
        return response()->json([
            "message" => "Insertions correctly taken",
            "total_insertions" => $total_insertions,
            "last_page" => $last_page,
            "data" => $insertions
        ], 200);
    }
    public function store(InsertionRequest $request)
    {
        try {
            //code...
            $validated_data = $request->validated();
            $insertion = Insertion::create($validated_data);
            return response()->json($insertion);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => $exception->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy(Insertion $insertion)
    {
        $insertion->delete();
        return response()->json([
            'message' => 'Insertion eliminated',

        ], Response::HTTP_OK);
    }
    public function show($id)
    {
        $insertion = Insertion::find($id);

        if (!$insertion) {
            return response()->json([
                'message' => 'Insertion not found'
            ], 404);
        }

        return response()->json($insertion);
    }
    public function update(InsertionRequest $request, $id)
    {
        $insertion = Insertion::find($id);
        if (!$insertion) {
            return response()->json([
                'message' => 'Insertion not found'
            ], 404);
        }
        // Esta función previene tomar mas datos que se hayan enviado en el request y que no se hayan pedido o validado, es decir, solo toma los datos validados previamente
        try {
            //code...
            $validated_data = $request->validated();
            $insertion->update($validated_data);
            return response()->json([
                "message" => "Insertion updated successfully",
                "insertion" => $insertion
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            //throw $th;
            return response()->json([
                "error" => $e
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getInsertionsTable(Request $request)
    {
        // $request->validate([
        //     'date' => 'required|date',
        //     'profiler_id' => 'required|exists:profilers,id',
        // ]);

        $date = Carbon::parse($request->query('date'))->startOfDay();
        $endDate = $date->copy()->endOfDay();

        // Obtener el número de máquina
        $profiler = Profiler::findOrFail($request->query('profiler_id'));
        $machineNumber = $profiler->number;

        // Agrupar inserciones por hora
        $results = Insertion::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as count')
        )
            ->where('machine_number', $machineNumber)
            ->whereBetween('created_at', [$date, $endDate])
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour')
            ->get();
        // Formatear salida
        $formatted = $results->map(function ($item) {
            return [
                'range' => sprintf('%02d:00 - %02d:00', $item->hour, ($item->hour + 1) % 24),
                'count' => $item->count
            ];
        });

        return response()->json($formatted);
    }
}
