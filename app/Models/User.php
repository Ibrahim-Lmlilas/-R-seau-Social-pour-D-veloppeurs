<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'skills',
        'programming_languages',
        'projects',
        'certifications',
        'github_url',
        'image',
        'industry',
        'banner',
        'bio',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts()
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'skills' => 'string',
            'programming_languages' => 'string',
            'projects' => 'string',
            'certifications' => 'string',
            'github_url' => 'string',
            'image' => 'string',
            'industry' => 'string',
            'banner' => 'string',
            'bio' => 'string',
        ];
    }

    public function connections()
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'connection_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'accepted');
    }

    public function sentConnectionRequests()
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'connection_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'pending');
    }

    public function receivedConnectionRequests()
    {
        return $this->belongsToMany(User::class, 'connections', 'connection_id', 'user_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'pending');
    }
}
