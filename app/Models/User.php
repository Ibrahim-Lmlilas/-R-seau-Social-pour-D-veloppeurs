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

    public function hasSentConnectionRequestTo(User $user)
    {
        return $this->connections()
            ->where('connected_user_id', $user->id)
            ->where('status', 'pending')
            ->exists();
    }

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
        return $this->hasMany(Connection::class, 'user_id');
    }

    public function receivedConnections()
    {
        return $this->hasMany(Connection::class, 'connected_user_id');
    }

    public function pendingConnections()
    {
        return $this->hasMany(Connection::class, 'connected_user_id')
                    ->where('status', 'pending');
    }

    public function acceptedConnections()
    {
        return $this->hasMany(Connection::class)
                    ->where('status', 'accepted');
    }

    public function getConnectionCount()
    {
        return $this->acceptedConnections()->count();
    }

    public function isConnectedWith(User $user)
    {
        return Connection::where('status', Connection::STATUS_ACCEPTED)
            ->where(function($query) use ($user) {
                $query->where(function($q) use ($user) {
                    $q->where('user_id', $this->id)
                      ->where('connected_user_id', $user->id);
                })->orWhere(function($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->where('connected_user_id', $this->id);
                });
            })->exists();
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

    public function getConnectionsCountAttribute()
    {
        return $this->connections()
            ->where('status', 'accepted')
            ->count();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isConnectedOrPendingWith(User $user)
    {
        return Connection::where(function($query) use ($user) {
            $query->where(function($q) use ($user) {
                $q->where('user_id', $this->id)
                  ->where('connected_user_id', $user->id);
            })->orWhere(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('connected_user_id', $this->id);
            });
        })->whereIn('status', [Connection::STATUS_PENDING, Connection::STATUS_ACCEPTED])
          ->exists();
    }

    public function getConnectionsAttribute()
    {
        return Connection::where(function($query) {
            $query->where('user_id', $this->id)
                  ->orWhere('connected_user_id', $this->id);
        })->where('status', Connection::STATUS_ACCEPTED)
          ->count();
    }
}
