<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Like extends Model
{
    protected $table = "likes";

    protected $primarykey = "id";

    protected $fillable = [
        'user_id',
        'post_id',
        'type',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
