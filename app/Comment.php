<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
    protected $table = 'comments';

    protected $primarykey = 'id';

    protected $fillable = [
      'user_id',
      'post_id',
      'content',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
