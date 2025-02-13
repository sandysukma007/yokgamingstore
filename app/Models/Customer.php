<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'customer'; // Nama tabel di database
    protected $primaryKey = 'user_id'; // Primary key tabel

    protected $fillable = [
        'username',
        'email',
        'password',
        'verification_code',
        'is_verified'
    ];
    

    protected $hidden = [
        'password', 'verification_code'
    ];
}
