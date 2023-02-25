<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class HourlySales extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dateTime',
        'hour',
        'user_id',
        'store_id',
        'product_id',
        'price',
        'quantity',
    ];

    public static function fetchOneHourSales($date, $hour)
    {
        return self::query()
            ->selectRaw('sum(products.price * quantity) as amount')
            ->where('dateTime', 'like', $date.'%')
            ->where('hour', $hour)
            ->join('stores', 'stores.id', '=', 'hourly_sales.store_id')
            ->join('products', 'products.id', '=', 'hourly_sales.product_id')
            ->value('amount');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return array
     */
    public static function fetchHourlySales($date): array
    {
        $ary = [];
        $amount = 0;
        foreach (range(9, 20) as $hour) {
            $amount = self::fetchOneHourSales($date, $hour) - $amount;
            $ary[] = array('hour' => $hour, 'value' => $amount);
        }
        return $ary;
    }
}
