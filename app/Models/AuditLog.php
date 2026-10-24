<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;
     protected $fillable = ['user_id', 'ip_address', 'log_action'];

     public $timestamps = false;

     protected $casts = [
    'created_at' => 'datetime',
    ];
}
