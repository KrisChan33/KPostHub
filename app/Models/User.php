<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Notifications\Collection;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements FilamentUser, HasTenants
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
        'role_id',
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
    public function getTenants(Panel $panel): Collection
    {
        return $this->team;
    }
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams->contains($tenant);
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function canAccessPanel($panel): bool
    {
        // Replace this with your actual implementation
        return true;
    }
}
