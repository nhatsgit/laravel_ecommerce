<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property bool $da_an
 * @property string|null $description
 * @property string|null $img_url
 * @property string $name
 * @property int $phan_tram_giam
 * @property int $price
 * @property int $so_luong_con
 * @property string|null $thong_so
 * @property int|null $brand_id
 * @property int|null $category_id
 * 
 * @property Brand|null $brand
 * @property Category|null $category
 * @property Collection|OrderDetail[] $order_details
 * @property Collection|ProductImage[] $product_images
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';
	public $timestamps = false;

	protected $casts = [
		'da_an' => 'bool',
		'phan_tram_giam' => 'int',
		'price' => 'int',
		'so_luong_con' => 'int',
		'brand_id' => 'int',
		'category_id' => 'int'
	];

	protected $fillable = [
		'da_an',
		'description',
		'img_url',
		'name',
		'phan_tram_giam',
		'price',
		'so_luong_con',
		'thong_so',
		'brand_id',
		'category_id'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}

	public function product_images()
	{
		return $this->hasMany(ProductImage::class);
	}
}
