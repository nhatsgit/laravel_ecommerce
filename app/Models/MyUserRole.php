<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MyUserRole
 * 
 * @property int $user_id
 * @property int $role_id
 * 
 * @property MyUser $my_user
 * @property MyRole $my_role
 *
 * @package App\Models
 */
class MyUserRole extends Model
{
	protected $table = 'my_user_role';
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

	public function my_role()
	{
		return $this->belongsTo(MyRole::class, 'role_id');
	}
}
