<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable =[
        'category_id','client_id','document_url','document_title','user_id'
    ];
    
    // relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // clients
    public function clients()
    {
        return $this->belongsTo(Client::class);
    }

    // users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
