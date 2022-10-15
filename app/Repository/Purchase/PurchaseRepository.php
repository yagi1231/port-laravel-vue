<?php

namespace App\Repository\Purchase;

use App\Models\Purchase;
use App\Servises\PurchaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseRepository implements PurchaseService
{
    public function fetchPaginatePurchase(Request $query): LengthAwarePaginator
    {
        $purchases = Purchase::groupBy('id')
            ->selectRaw('id, sum(subtotal) as total, reservation_name, status, time')
            ->where(function ($q) use ($query) {
                if (($query['dateTime'] || $query['name'])) {
                    $q->where('time', $query['dateTime'])
                        ->orwhere('reservation_name', $query['name']);
                }
            })
            ->paginate(50);

        return $purchases;
    }

    public function findPurchase(int $purchase_id)
    {
        return Purchase::groupBy('id')
            ->where('id', $purchase_id)
            ->selectRaw('id, sum(subtotal) as total, reservation_name, time, status, deleted_at')
            ->first();
    }

    public function getPurchaseItem(int $purchase_id)
    {
        return Purchase::where('id', $purchase_id)->get();
    }

    public function getLastOrderDay(int $purchase_id)
    {
        return Purchase::where('customer_id', $purchase_id)
            ->where('time', '<', Carbon::now())
            ->select('time')->groupBy('id')
            ->first();
    }

    public function getOrderCount(int $purchase_id)
    {
        return  Purchase::where('customer_id', $purchase_id)
            ->groupBy('id')
            ->select('time')
            ->get()
            ->count();
    }
}
