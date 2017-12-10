<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements Transformable,JWTSubject
{
    use TransformableTrait;

    protected $fillable = [
		'id',
		'name',
		'name_kana',
		'email',
		'password',
		'remember_token',
		'created_at',
		'updated_at'
	];
    protected $hidden = [
    	'password',
		'remember_token',
		'created_at',
		'updated_at'
	];
    
    protected $table = 'users';
    
    protected $primaryKey = 'id';

    public function getJWTIdentifier()
	{
		return $this->getKey();
	}
	
	public function getJWTCustomClaims()
	{
		return [];
	}
}
