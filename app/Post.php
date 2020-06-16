<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Like;
use App\Comment;

class Post extends Model
{
    protected $table = 'posts';

    protected $primarykey = 'id';

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function like(){
        return $this->hasMany(Like::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
