<?php

namespace App\Http\Controllers;
use App\Models\Insertion;
use Illuminate\Http\Request;

class InsertionController extends Controller
{
    public function getAll()
    {
        $insertions = Insertion::all();
        return response()->json([
            "message" => "Insertions correctly taken",
            "data" => $insertions
        ], 200);
    }
}
