<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Voucher
 * 
 * @property int $id
 * @property int $don_toi_thieu
 * @property int $giam_toi_da
 * @property string $ma_giam_gia
 * @property Carbon|null $ngay_bat_dau
 * @property Carbon|null $ngay_het_han
 * @property int $phan_tram_giam
 * @property int $so_luong_con
 * 
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Voucher extends Model
{
	protected $table = 'vouchers';
	public $timestamps = false;

	protected $casts = [
		'don_toi_thieu' => 'int',
		'giam_toi_da' => 'int',
		'ngay_bat_dau' => 'datetime',
		'ngay_het_han' => 'datetime',
		'phan_tram_giam' => 'int',
		'so_luong_con' => 'int'
	];

	protected $fillable = [
		'don_toi_thieu',
		'giam_toi_da',
		'ma_giam_gia',
		'ngay_bat_dau',
		'ngay_het_han',
		'phan_tram_giam',
		'so_luong_con'
	];

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
