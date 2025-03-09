<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $table = 'brands';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
