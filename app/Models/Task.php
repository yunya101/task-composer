<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'deadline',
        'description', 'executor',
        'group_id',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'executor');
    }
}
