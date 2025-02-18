<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replie extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'comment_id',
        'user_id'
    ];


    /**
    * one to many with user , post
    */

    public function comment()
    {
        return $this->belongsTo(Comment::class,'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
