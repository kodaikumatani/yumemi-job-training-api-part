<?php

namespace App\Http\Controllers;

use App\Http\Resources\YearlySalesResource;
use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSalesYearController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param string $year
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $year)
    {
        return response()->json(
            YearlySalesResource::collection(Sales::fetchYearlySales($year))
        , 200, [], JSON_UNESCAPED_UNICODE);
    }
}
