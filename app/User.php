<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_unique'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUserUnique(){

        return uniqid(rand(10000000,99999999)) . rand(10000,99999);
    }

    public static function checkSocialUser($email, $id){
        
        return User::where('email','=',$email)->orWhere('social_auth_id' , '=' , $id)->count();
    }

    public static function checkUserUnique($user_unique) {

        return User::where('user_unique' , '=' , $user_unique)->count();
    }
}
