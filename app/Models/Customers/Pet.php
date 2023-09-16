<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'name', 'birth_date', 'animal_id', 'breed_id', 'weight', 'observation'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
