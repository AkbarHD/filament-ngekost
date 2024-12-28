<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // room itu kamar kos"an
    use HasFactory;
    protected $fillable = [
        'boarding_house_id',
        'name',
        'room_type',
        'square_feet',
        'price_per_month',
        'is_available'
    ];

    public function BoardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    // karena 1 kamar kos memiliki banyak gambar utk di lihat macam macam
    public function Images()
    {
        return $this->hasMany(RoomImage::class);
    }

    // karena 1 kamar kos memiliki banyak booking (transaksi)
    public function Transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

