<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // Spécifier le nom de la table si vous la renommez
    protected $table = 'job_offers';

    protected $fillable = [
        'user_id',
        'title',
        'company',
        'location',
        'description',
        'type',
        'salary_range',
        'experience_level',
        'skills_required',
        'application_url',
        'deadline',
        'is_active',
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
