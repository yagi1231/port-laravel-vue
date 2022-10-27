<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelHistoryTrait;

class Reservation extends Model
{
    use HasFactory, SoftDeletes, ModelHistoryTrait;

    protected $fillable = [
        'name',
        'kana',
        'address',
        'postcode',
        'tel',
        'user_id',
        'customer_id',
        'order',
        'sumprice',
        'delivery',
        'datetime',
        'time',
        'status',
        'remarks',
        'after_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    public static function boot() 
    {
        parent::boot();

        self::saveModelHistory();
    }

    public const TIME_OPTION_A = '11:00-11:30';
    public const TIME_OPTION_B = '11:30';
    public const TIME_OPTION_C = '11:30-12:00';
    public const TIME_OPTION_D = '12:00';
    public const TIME_OPTION_E = '12:00-12:30';
    public const TIME_OPTION_F = '12:30';
    public const TIME_OPTION_G = '12:30-13:00';
    public const TIME_OPTION_H = '13:00';
    public const TIME_OPTION_I = '13:00-13:30';
    public const TIME_OPTION_J = '13:30';
    public const TIME_OPTION_K = '13:30-14:00';
    public const TIME_OPTION_L = '14:00';
    public const TIME_OPTION_M = '14:00-14:30';
    public const TIME_OPTION_N = '14:30';
    public const TIME_OPTION_O = '14:30-15:00';
    public const TIME_OPTION_P = '15:00';
    public const TIME_OPTION_Q = '15:00-15:30';
    public const TIME_OPTION_R = '15:30';
    public const TIME_OPTION_S = '15:30-16:00';
    public const TIME_OPTION_T = '16:00';
    public const TIME_OPTION_U = '16:00-16:30';
    public const TIME_OPTION_V = '16:30';
    public const TIME_OPTION_W = '16:30-17:00';
    public const TIME_OPTION_X = '17:00';
    public const TIME_OPTION_Y = '17:00-17:30';
    public const TIME_OPTION_Z = '17:30';
    public const TIME_OPTION_A2 = '17:30-18:00';
    public const TIME_OPTION_B2 = '18:00';
    public const TIME_OPTION_C2 = '18:00-18:30';
    public const TIME_OPTION_D2 = '18:30';
    public const TIME_OPTION_E2 = '18:30-19:00';
    public const TIME_OPTION_F2 = '19:00';
    public const TIME_OPTION_G2 = '19:00-19:30';
    public const TIME_OPTION_H2 = '19:30';
    public const TIME_OPTION_I2 = '19:30-20:00';
    public const TIME_OPTION_J2 = '20:00';
    public const TIME_OPTION_K2 = '20:00-20:30';
    public const TIME_OPTION_L2 = '20:30';
    public const TIME_OPTION_M2 = '20:30-21:00';
    public const TIME_OPTION_N2 = '21:00';

    public const TIME_ALL = [
        self::TIME_OPTION_A,
        self::TIME_OPTION_B,
        self::TIME_OPTION_C,
        self::TIME_OPTION_D,
        self::TIME_OPTION_E,
        self::TIME_OPTION_F,
        self::TIME_OPTION_G,
        self::TIME_OPTION_H,
        self::TIME_OPTION_I,
        self::TIME_OPTION_J,
        self::TIME_OPTION_K,
        self::TIME_OPTION_L,
        self::TIME_OPTION_M,
        self::TIME_OPTION_N,
        self::TIME_OPTION_O,
        self::TIME_OPTION_P,
        self::TIME_OPTION_Q,
        self::TIME_OPTION_R,
        self::TIME_OPTION_S,
        self::TIME_OPTION_T,
        self::TIME_OPTION_U,
        self::TIME_OPTION_V,
        self::TIME_OPTION_W,
        self::TIME_OPTION_X,
        self::TIME_OPTION_Y,
        self::TIME_OPTION_Z,
        self::TIME_OPTION_A2,
        self::TIME_OPTION_B2,
        self::TIME_OPTION_C2,
        self::TIME_OPTION_D2,
        self::TIME_OPTION_E2,
        self::TIME_OPTION_F2,
        self::TIME_OPTION_G2,
        self::TIME_OPTION_H2,
        self::TIME_OPTION_I2,
        self::TIME_OPTION_J2,
        self::TIME_OPTION_K2,
        self::TIME_OPTION_L2,
        self::TIME_OPTION_M2,
        self::TIME_OPTION_N2,
    ];

    public const STATUS_TYPE_A = '準備中';
    public const STATUS_TYPE_B = '配達中';
    public const STATUS_TYPE_C = '配達済';
    public const STATUS_TYPE_D = '再配達';
    public const STATUS_TYPE_E = '遅延';

    public const STATUS_ALL = [
        self::STATUS_TYPE_A,
        self::STATUS_TYPE_B,
        self::STATUS_TYPE_C,
        self::STATUS_TYPE_D,
        self::STATUS_TYPE_E,
    ];
}
