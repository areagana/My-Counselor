<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueTopic extends Model
{
    use HasFactory;

    protected $fillable =[
        'title','details'
    ];

    // link to issue class
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    // check topic records
    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
