<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name', 
        'slug',
        'timestamps'];

    public function post()
{
    return $this->hasMany(Post::class);
}
}