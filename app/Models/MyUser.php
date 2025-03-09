<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MyUser
 * 
 * @property int $id
 * @property string $address
 * @property string $email
 * @property string $full_name
 * @property string $password
 * @property string|null $phone
 * @property string|null $provider
 * @property string $username
 * 
 * @property Collection|MyUserRole[] $my_user_roles
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class MyUser extends Model
{
	protected $table = 'my_user';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'address',
		'email',
		'full_name',
		'password',
		'phone',
		'provider',
		'username'
	];

	public function my_user_roles()
	{
		return $this->hasMany(MyUserRole::class, 'user_id');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'user_id');
	}
}
