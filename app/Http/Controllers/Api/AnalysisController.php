<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Servises\AnalysisServise;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        $subQuery = Purchase::whereBetween('time',[ $request->startDate, $request->endDate] );

        if ($request->type === 'perDay') {
            [$data, $labels, $totals, $title]= AnalysisServise::perDay($subQuery, $request);
        }

        if ($request->type === 'perMonth') {
            [$data, $labels, $totals, $title]= AnalysisServise::perMonth($subQuery, $request);
        }

        if ($request->type === 'perYear') {
            [$data, $labels, $totals, $title]  = AnalysisServise::perYear($subQuery, $request);
        }      

        return response()->json([
            'data' => $data,
            'type' => $request->type,
            'labels' =>  $labels,
            'totals' =>  $totals,
            'title' => $title
        ], Response::HTTP_OK);
    }
    
}
