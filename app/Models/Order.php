<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $id
 * @property string|null $address
 * @property string|null $customer_name
 * @property string|null $email
 * @property string|null $note
 * @property Carbon|null $order_date
 * @property string|null $payment
 * @property string|null $phone_number
 * @property int $total_price
 * @property int|null $order_status_id
 * @property int|null $user_id
 * @property int|null $voucher_id
 * 
 * @property OrderStatus|null $order_status
 * @property Voucher|null $voucher
 * @property MyUser|null $my_user
 * @property Collection|OrderDetail[] $order_details
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';
	public $timestamps = false;

	protected $casts = [
		'order_date' => 'datetime',
		'total_price' => 'int',
		'order_status_id' => 'int',
		'user_id' => 'int',
		'voucher_id' => 'int'
	];

	protected $fillable = [
		'address',
		'customer_name',
		'email',
		'note',
		'order_date',
		'payment',
		'phone_number',
		'total_price',
		'order_status_id',
		'user_id',
		'voucher_id'
	];

	public function order_status()
	{
		return $this->belongsTo(OrderStatus::class);
	}

	public function voucher()
	{
		return $this->belongsTo(Voucher::class);
	}

	public function my_user()
	{
		return $this->belongsTo(MyUser::class, 'user_id');
	}

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}
}
