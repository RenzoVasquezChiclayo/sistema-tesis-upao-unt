<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;
    public $table = 'users';

    protected $fillable = [
        'name',
        //'email',
        'password',
        'rol'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rol(){
        return $this->belongsToMany(Rol::class);
    }




}
