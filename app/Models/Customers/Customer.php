<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone_1', 'phone_2', 'birth_date', 'document'];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }
}
