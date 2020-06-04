<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Follow extends Model
{
    protected $table = 'follows';

    protected $fillable = [
      'user_id',
      'following_user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
