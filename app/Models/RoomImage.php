<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'image',
    ];

    // 1 gambar hanya dimiliki 1 kamar kos
    public function Room()
    {
        return $this->belongsTo(Room::class);
    }
}
