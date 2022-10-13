<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function fetchDailyAccounts()
    {
        return $this
            ->selectRaw('sum(price * quantity) as amount')
            ->where('date', 'like', date('Y-m').'%')
            ->value('amount');
    }
}
