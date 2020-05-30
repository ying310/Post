<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
}
