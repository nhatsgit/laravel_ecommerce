<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MyRole
 * 
 * @property int $id
 * @property string|null $description
 * @property string $name
 * 
 * @property Collection|MyUserRole[] $my_user_roles
 *
 * @package App\Models
 */
class MyRole extends Model
{
	protected $table = 'my_role';
	public $timestamps = false;

	protected $fillable = [
		'description',
		'name'
	];

	public function my_user_roles()
	{
		return $this->hasMany(MyUserRole::class, 'role_id');
	}
}
