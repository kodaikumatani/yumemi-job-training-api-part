<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Sales extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'hour',
        'user_id',
        'store_id',
        'product_id',
        'quantity',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDateStores($date): Collection
    {
        return self::query()
            ->select('store_id as id', 'stores.name as name')
            ->where('date', $date)
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->groupBy('store_id')
            ->withCasts([
                'id' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return Collection
     */
    public static function fetchDailySales(): Collection
    {
        return self::query()
            ->select('date')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('date')
            ->withCasts([
                'value' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDailyDateSales($date): Collection
    {
        return self::query()
            ->select('products.name as product', 'products.price')
            ->selectRaw('SUM(quantity) as quantity, SUM(products.price * quantity) as total')
            ->selectRaw('max(date) as date')
            ->where('date', $date)
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('product_id')
            ->withCasts([
                'quantity' => 'integer',
                'total' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDailyDateStoresSales($date): Collection
    {
        return self::query()
            ->select('stores.name')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->where('sales.date', $date)
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('stores.name')
            ->withCasts([
                'value' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDailyDateProductsSales($date): Collection
    {
        return self::query()
            ->select('products.name')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->where('sales.date', $date)
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('products.name')
            ->withCasts([
                'value' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDateHourlySales($date): Collection
    {
        return self::query()
            ->select('hour')
            ->selectRaw('SUM(products.price * quantity) as value')
            ->where('sales.date', $date)
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('hour')
            ->withCasts([
                'hour' => 'integer',
                'value' => 'integer',
            ])->get();
    }
}
