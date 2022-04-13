<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //user clients
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    // user schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    //user records
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    //user documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    //categories
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    //check issues
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
