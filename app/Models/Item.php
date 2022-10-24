<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'status',
        'allergy',
        'introduction',
        'user_id'
    ];

    /**
     * 商品ステータス
     */
    public const ITEM_STATUS_A = '販売停止';
    public const ITEM_STATUS_B = '販売中';

    public const ITEM_STATUS_ALL = [
        self::ITEM_STATUS_A,
        self::ITEM_STATUS_B,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class)->withPivot('quantity');
    }
}
