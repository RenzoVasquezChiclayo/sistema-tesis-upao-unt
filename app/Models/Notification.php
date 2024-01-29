<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $table = 'notification';
    protected $primaryKey = 'cod';
    protected $fillable = ['user_id', 'user_from', 'type_from', 'message', 'topic', 'estado', 'read_at'];
}
