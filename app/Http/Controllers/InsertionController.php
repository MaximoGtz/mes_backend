<?php

namespace App\Http\Controllers;
use App\Models\Insertion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\InsertionRequest;
class InsertionController extends Controller
{
    public function index(Request $request)
    {
        //if you send parameters to the route, we can access it via Request by using query
        $per_page = $request->query("per_page", 12);
        $page = $request->query("page", 0);
        $offset = $page * $per_page;
        $total_insertions = Insertion::all()->count();
        $last_page = $total_insertions / $per_page;
        $residue = $total_insertions % $per_page;
        // dd($residue);

        if ($residue > 0) {
            // echo "La división tiene residuo: " . $residue;
            $last_page = floor($total_insertions / $per_page);
        } else {
            // echo "La división no tiene residuo";
            $last_page--;
        }
        $insertions = Insertion::skip($offset)->take($per_page)->get();
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
}
