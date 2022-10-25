<?php

namespace App\Repository\Reservation;

use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Reservation;
use App\Servises\ReservationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ReservationRepository implements ReservationService
{
    public function featchAllReservation(Request $query): LengthAwarePaginator
    {
        $reservations = Reservation::query()
            ->where(function ($q) use ($query) {
                if ($query['freeWord']) {
                    $q->where('name', 'LIKE', '%' . $query['freeWord'] . '%')
                        ->orwhere('address', "LIKE", $query['freeWord'].'%')
                         ->orwhere('after_address', "LIKE", '%'.$query['freeWord']);
                }
            })->where(function ($q) use ($query) {
                if ($query['dateTime']) {
                    $q->where('time', $query['dateTime']);
                }
            })
            ->where(function ($q) use ($query) {
                if ($query['deliveryTime']) {
                    $q->where('datetime', $query['deliveryTime']);
                }
            })->paginate(10);

        return $reservations;
    }

    public function findReservation(int $reservation_id): Reservation
    {
        return Reservation::find($reservation_id);
    }

    public function storeReservation(ReservationParams $params, Array $items): void
    {
        $reservation = Reservation::create($params->toArray());

        foreach ($items as $item) {
            $reservation->items()->attach($reservation->id, [
                'item_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }
    }

    public function updateReservation(ReservationParams $params, Array $itemQuantity, Reservation $reservation): void
    {
        $reservation->update($params->toArray());

        $items = [];
        foreach ($itemQuantity as $item) {
            $items = $items + [
                // item_id => [ 中間テーブルの列名 => 値 ]
                $item['id'] => ['quantity' => $item['quantity']]
            ];
        }
        $reservation->items()->sync($items);
    }

    public function deleteReservation(Reservation $reservation): void
    {
        $reservation->delete();
    }

    public function getSelectOptionTime(): Array
    {
        return Reservation::TIME_ALL;
    }

    public function getSelectOptionStatus(): Array
    {
        return Reservation::STATUS_ALL;
    }

    public function fetchItemQuantity(Collection $reservation_item, Collection $allItems): Array
    {
        $items = [];

        foreach ($allItems as $allItems) {
            $quantity = 0;
            foreach ($reservation_item as $item) {
                if ($allItems->id === $item->id) {
                    $quantity = $item->pivot->quantity;
                }
            }
            array_push($items, [
                'id' => $allItems->id,
                'name' => $allItems->name,
                'price' => $allItems->price,
                'quantity' => $quantity,
            ]);
        }

        return $items;
    }
}
