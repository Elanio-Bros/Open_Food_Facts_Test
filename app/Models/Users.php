<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $collection = 'users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        "user",
        "email",
        "type",
        
        // hidden
        "password"
    ];

    /**
     * The attributes that are hiden.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password"];
}
