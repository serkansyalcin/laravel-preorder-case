<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_number', 'amount', 'total_product', 'total_purchase_qty', 'billing_address', 'shipping_address', 'status'];


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    }

    public function users(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
