<?php

namespace App\Http\Controllers;

use App\Models\HourlySales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSalesDateHourlyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param string $date
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $date): JsonResponse
    {
        return response()->json([
            'details' => HourlySales::fetchHourlySales($date),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
