<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardingHouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'city_id',
        'category_id',
        'price',
        'description',
        'address',
    ];

    public function City()
    {
        return $this->belongsTo(City::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    // karena 1 kos memiliki banyak kamar kos
    public function Rooms()
    {
        return $this->hasMany(Room::class);
    }

    // karena 1 kos memiliki banyak testimonial
    public function Testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    // karena 1 kos memiliki banyak booking (transaksi)
    public function Transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
