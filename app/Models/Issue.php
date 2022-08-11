<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    //relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    //categories
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    //records
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    //user 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // topics 
    public function topics()
    {
        return $this->hasMany(IssueTopic::class);
    }
}
