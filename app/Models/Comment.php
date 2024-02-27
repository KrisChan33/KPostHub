<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $table = 'comments'; // Specify the table name
    protected $fillable = [
        'id',
        'user_id',
        'content',
        'comment',
        'commentable_id',
        'commentable_type',
    ];
    use HasFactory;

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function commentable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}