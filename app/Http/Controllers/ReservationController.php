<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservations = Reservation::query()
            ->where(function ($q) use ($request) {
                if ($request['freeWord']) {
                    $q->where('name', $request['freeWord'])
                        ->orwhere('address', $request['freeWord']);
                }
            })->where(function ($q) use ($request) {
                if ($request['dateTime']) {
                    $q->where('time', $request['dateTime']);
                }
            })
            ->where(function ($q) use ($request) {
                if ($request['deliveryTime']) {
                    $q->where('datetime', $request['deliveryTime']);
                }
            })->paginate(10);


        return Inertia::render('Reservation/Index', [
            'reservations' => $reservations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $item = Item::query()->where('status', '販売中')->get();

        // dd($request);
        return Inertia::render('Reservation/Create')->with([
            'reservation' => $request,
            'item' => $item
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReservationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservationRequest $request)
    {
        $reservation = Reservation::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'customer_id' => $request->customer_id,
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'tel' => $request->tel,
            'order' => $request->order,
            'sumprice' => $request->sumprice,
            'datetime' => $request->delivery_time,
            'time' => $request->day_time,
            'remarks' => $request->remarks,
        ]);

        foreach ($request->items as $item) {
            $reservation->items()->attach($reservation->id, [
                'item_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }

        return to_route('reservations.index')->with([
            'message' => $request->name . "様を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $purchase = Purchase::where('id', $reservation->id)->paginate(50);

        return Inertia::render('Reservation/Show', [
            'reservation' => $reservation,
            'createStaffName' =>  $reservation->user,
            'updateStaffName' =>  $reservation->user,
            'purchase' => $purchase
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $reservation = Reservation::find($reservation->id);

        $allItems = Item::query()->where('status', '販売中')->get();
        $items = [];

        foreach ($allItems as $allItems) {
            $quantity = 0;
            foreach ($reservation->items as $item) {
                if ( $allItems->id === $item->id) {
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

        $staffName = User::select('name')->get();
        $purchase = Purchase::where('id', $reservation->id)->paginate(50);

        return Inertia::render('Reservation/Edit', [
            'reservation' => $reservation,
            'item' => $items,
            'staffName' =>  $staffName,
            'purchase' => $purchase
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReservationRequest  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->update([
            'name' => $request->name,
            'kana' => $request->kana,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'tel' => $request->tel,
            'order' => $request->order,
            'sumprice' => $request->sumprice,
            'delivery' => $request->delivery_name,
            'datetime' => $request->delivery_time,
            'time' => $request->day_time,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        $items = [];
        foreach ($request->items as $item) {
            $items = $items + [
                // item_id => [ 中間テーブルの列名 => 値 ]
                $item['id'] => ['quantity' => $item['quantity']]
            ];
        }
        $reservation->items()->sync($items);

        return to_route('reservations.index')->with([
            'message' => $request->name . "様を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return to_route('reservations.index')->with([
            'message' => $reservation->kana . '様を削除しました',
            'status' => 'danger'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aggregate(Request $request)
    {
        $aggregates = DB::table('reservations')
            ->selectRaw('SUM(sumprice) as sumTptal')
            ->selectRaw('AVG(sumprice) as avgTotal')
            ->selectRaw('DATE_FORMAT(time, "%Y%m%d") as time')
            ->selectRaw('COUNT(sumprice) as totalCount')
            ->groupBy('time')
            ->where(function ($q) use ($request) {
                if ($request->begin  && $request->end) {
                    $q->whereBetween('time', [$request->begin, $request->end]);
                }
            })
            ->when(empty($request->category), function ($q) {
                $q->orderBy('time', 'desc');
            })
            ->when(!empty($request->category) && !empty($request->order === '昇順'), function ($q) use ($request) {
                switch ($request->category) {
                    case '日付':
                        $q->orderBy('time', 'asc');
                        break;
                    case '合計':
                        $q->orderBy('sumTptal', 'asc');
                        break;
                    case '平均':
                        $q->orderBy('avgTotal', 'asc');
                        break;
                    case '件数':
                        $q->orderBy('totalCount', 'asc');
                        break;
                }
            })
            ->when(!empty($request->category) && !empty($request->order === '降順'), function ($q) use ($request) {
                switch ($request->category) {
                    case '日付':
                        $q->orderBy('time', 'desc');
                        break;
                    case '合計':
                        $q->orderBy('sumTptal', 'desc');
                        break;
                    case '平均':
                        $q->orderBy('avgTotal', 'desc');
                        break;
                    case '件数':
                        $q->orderBy('totalCount', 'desc');
                        break;
                }
            })
            ->paginate(5);

        return Inertia::render('Reservation/Aggregate', [
            'aggregates' => $aggregates
        ]);
    }
}
