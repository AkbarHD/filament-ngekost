<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cities';

    protected $fillable = [
        'image',
        'name',
        'slug',
    ];

    // karena 1 kota memiliki banyak boarding house
    public function BoardingHouses()
    {
        return $this->hasMany(BoardingHouse::class);
    }
}
