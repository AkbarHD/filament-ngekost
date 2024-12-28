<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'slug',
    ];

    // karena 1 category memiliki banyak boarding house
    public function BoardingHouses()
    {
        return $this->hasMany(BoardingHouse::class);
    }
}
