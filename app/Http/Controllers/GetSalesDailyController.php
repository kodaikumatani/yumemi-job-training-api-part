<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSalesDailyController extends Controller
{
    /**
     * Obtain sales data for the most recent month
     *
     * @param Sales $sales
     * @return JsonResponse
     */
    public function __invoke(Sales $sales)
    {
        return response()->json([
            'summary' => $sales->fetchDailyAccounts(),
        ]);
    }
}
