<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Breed extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['animal_id', 'name'];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
