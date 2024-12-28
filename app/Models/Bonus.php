<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarding_house_id',
        'image',
        'name',
        'description',
    ];

    // karena 1 bonus hanya ada di 1 kos
    public function BoardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
