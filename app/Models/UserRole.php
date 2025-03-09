<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 * 
 * @property int $user_id
 * @property int $role_id
 * 
 * @property MyUser $my_user
 * @property Role $role
 *
 * @package App\Models
 */
class UserRole extends Model
{
	protected $table = 'user_role';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'role_id' => 'int'
	];

	public function my_user()
	{
		return $this->belongsTo(MyUser::class, 'user_id');
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
