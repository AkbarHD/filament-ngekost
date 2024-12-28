<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarding_house_id',
        'photo',
        'content',
        'rating',
    ];

    // karena 1 testimonial hanya ada di 1 kos
    public function BoardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
