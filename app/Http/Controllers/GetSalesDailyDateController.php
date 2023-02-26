<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSalesDailyDateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param String $date
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $date): JsonResponse
    {
        return response()->json([
            'details' => Sales::fetchDailyDateSales($date),
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
