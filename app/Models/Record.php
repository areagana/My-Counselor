<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    // relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    //user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //issues
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}
