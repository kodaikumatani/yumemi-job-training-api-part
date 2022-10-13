<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * 直近１ヶ月の売上データを取得する
     *
     * @return
     */
    public function getMonthSales(Sales $sales)
    {
        return response()->json([
            'summary' => $sales->fetchDailyAccounts(),
        ]);
    }
}
