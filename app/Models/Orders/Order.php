<?php

namespace App\Models\Orders;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodsEnum;
use App\Models\Customers\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'status', 'payment_method', 'total', 'items', 'date', 'start_hour', 'end_hour', 'animal_objects', 'observations'];

    protected $casts = [
        'status'         => OrderStatusEnum::class,
        'payment_method' => PaymentMethodsEnum::class,
        'items'          => 'array',
        'animal_objects' => 'array',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
