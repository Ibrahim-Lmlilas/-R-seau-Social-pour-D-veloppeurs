<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'content',
        'line',
        'code',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
