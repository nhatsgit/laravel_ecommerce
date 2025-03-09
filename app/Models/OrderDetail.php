<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderDetail
 * 
 * @property int $id
 * @property int $quantity
 * @property int|null $order_id
 * @property int|null $product_id
 * 
 * @property Product|null $product
 * @property Order|null $order
 *
 * @package App\Models
 */
class OrderDetail extends Model
{
	protected $table = 'order_details';
	public $timestamps = false;

	protected $casts = [
		'quantity' => 'int',
		'order_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'quantity',
		'order_id',
		'product_id'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
