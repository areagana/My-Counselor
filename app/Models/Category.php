<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // relationships
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    //documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // schedules
    public function schedules()
    {
        return $this->hasManyThrough(Schedule::class,Client::class);
    }

    //user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * category has issues
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
