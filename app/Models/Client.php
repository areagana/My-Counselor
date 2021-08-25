<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','gender','age','parent_info','contact','email','parent_contact','address','class','profile_image_url'
    ];

    //relationships
    public function background()
    {
        return $this->hasOne(Background::class);
    }

    // has many issues
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    // has many  records
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    // belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // has many schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
