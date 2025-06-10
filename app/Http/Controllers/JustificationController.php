<?php

namespace App\Http\Controllers;

use App\Models\Justification;
use App\Http\Requests\JustificationRequest;
use Illuminate\Http\Request;

class JustificationController extends Controller
{
    public function makeJustification(JustificationRequest $request)
    {
        $createdJustification = Justification::create($request->validated());
        return response()->json($createdJustification);
    }
}
