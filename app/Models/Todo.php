<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
     protected $fillable = ['title', 'status', 'user_id'];

    const STATUSES = ['pending', 'in_progress', 'completed'];

    public function user(){
    return $this->belongsTo(User::class);
}
}

