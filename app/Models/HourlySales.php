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

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchHourlySales($date): Collection
    {
        return self::query()
            ->select('hour')
            ->selectRaw('sum(products.price * quantity) as amount')
            ->where('dateTime', 'like',  $date . '%')
            ->join('stores', 'stores.id', '=', 'hourly_sales.store_id')
            ->join('products', 'products.id', '=', 'hourly_sales.product_id')
            ->groupBy('hour')
            ->withCasts([
                'hour' => 'integer',
                'amount' => 'integer',
            ])->get();
    }
}
