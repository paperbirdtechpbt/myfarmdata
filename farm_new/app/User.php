<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'family_name', 'collect_activity_id', 'external_id', 'is_active', 'community_group_id', 'communitygroup', 'language', 'timezone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    
    public function collectactivities()
    {
        return $this->belongsToMany('App\CollectActivity');
    }
    
    public function communitygrp()
    {
        return $this->belongsToMany('App\CommunityGroup');
    }
}
