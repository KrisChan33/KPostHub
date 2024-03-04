<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable 
// class User extends Authenticatable implements FilamentUser
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MEMBER = 'member';
    const ROLE_USER = 'user';

    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // public function canAccessPanel(Panel $panel): bool
    // {
    // return  $this->role=='admin';
    // }
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function posts()
    {
        return $this->belongstomany(Post::class, 'post_user', 'user_id', 'post_id')->withPivot(['order'])->withTimestamps();
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function admin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function member()
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function user()
    {
        return $this->role === self::ROLE_USER;
    }
}