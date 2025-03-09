<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements AuthenticatableContract
{
	use Notifiable;

	protected $fillable = [
		'name',
		'email',
		'password',
		'role',
	];
	public function orders()
	{
		return $this->hasMany(Order::class, 'user_id');
	}
}
