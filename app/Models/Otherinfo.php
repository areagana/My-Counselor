<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otherinfo extends Model
{
    use HasFactory;

    // link to the client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    //public function user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
