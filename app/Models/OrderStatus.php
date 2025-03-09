<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderStatus
 * 
 * @property int $id
 * @property string $ten_trang_thai
 * 
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class OrderStatus extends Model
{
	protected $table = 'order_statuses';
	public $timestamps = false;

	protected $fillable = [
		'ten_trang_thai'
	];

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
