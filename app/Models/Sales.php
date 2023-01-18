<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        'user_id',
        'store_id',
        'product_id',
        'price',
        'quantity',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return Collection
     */
    public function fetchDailyAccounts(): Collection
    {
        return $this
            ->select('date')
            ->selectRaw('sum(price * quantity) as amount')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->withCasts([
                'amount' => 'integer',
            ])->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $date
     * @return Collection
     */
    public static function fetchDailySales($date): Collection
    {
        return self::query()
            ->select('stores.name as store', 'products.name as product', 'price')
            ->selectRaw('sum(quantity) as quantity')
            ->selectRaw('sum(products.price * quantity) as total')
            ->where('date', $date)
            ->join('stores', 'stores.id', '=', 'sales.store_id')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('store', 'product', 'price')
            ->withCasts([
                'quantity' => 'integer',
                'total' => 'integer',
            ])->get();
    }
}
