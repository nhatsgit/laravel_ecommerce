<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string|null $description
 * @property string $name
 * 
 * @property Collection|UserRole[] $user_roles
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'role';
	public $timestamps = false;

	protected $fillable = [
		'description',
		'name'
	];

	public function user_roles()
	{
		return $this->hasMany(UserRole::class);
	}
}
