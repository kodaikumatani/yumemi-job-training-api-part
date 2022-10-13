<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSalesDailyController extends Controller
{
    /**
     * 直近１ヶ月の売上データを取得する
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
