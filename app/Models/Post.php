<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table ='post'; // Specify the table name
    protected $fillable = [
        'id',  
        'title',
        'thumbnail',
        'color',
        'slug',
        'category_id',
        'content',
        'tags',
        'published',
        'timestamps',
    ];
    protected $casts = [
        'tags' => 'array',
        'published' => 'boolean',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}