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
        'name','head_image','nickname','mobile','openid','unionid','job','last_login','last_ip','show_time','key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function seelogs(){
        return $this->hasMany('App\Models\UserSeeLogs','user_id','id');
    }

    //套餐
    public function packages(){
        return $this->hasMany('App\Models\UserPackages','user_id','id');
    }

}
