<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductImage
 * 
 * @property int $id
 * @property string|null $img_url
 * @property int|null $product_id
 * 
 * @property Product|null $product
 *
 * @package App\Models
 */
class ProductImage extends Model
{
	protected $table = 'product_image';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int'
	];

	protected $fillable = [
		'img_url',
		'product_id'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
