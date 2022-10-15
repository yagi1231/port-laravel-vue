<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistory extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreateReservationStaffName($reservation_id)
    {
        $updateStaffId =  ModelHistory::where('model_id', $reservation_id)
            ->where('operation_type', 'created')
            ->select('user_id')
            ->get();

        return User::find($updateStaffId);
    }

    public function getUpdateReservationStaffName($reservation_id)
    {
        $updateStaffId =  ModelHistory::where('model_id', $reservation_id)
            ->where('operation_type', 'updated')
            ->select('user_id')
            ->get();

        return User::find($updateStaffId);
    }

    public function getDeleteReservationStaffName($reservation_id)
    {
        $deleteStaffId =  ModelHistory::where('model_id', $reservation_id)
            ->where('operation_type', 'deleted')
            ->select('user_id')
            ->get();

        return User::find($deleteStaffId);
    }
}
