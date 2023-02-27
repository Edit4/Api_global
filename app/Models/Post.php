<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    protected $table = 'posts';
    protected $fillable = ['title','content',
        'Users_id','img','is_published'];
    public function users() {

        return $this->hasOne(User::class,'id','Users_id');
    }
}
