<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'category_id', 'product_id', 'qty', 'price'];

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the OrderItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
