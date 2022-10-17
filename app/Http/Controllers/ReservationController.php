<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Models\ModelHistory;
use App\Models\Reservation;
use App\Models\User;
use App\Servises\ItemService;
use App\Servises\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Servises\ReservationService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ReservationController extends Controller
{

    private ReservationService $reservationService;
    private ItemService $itemService;
    private User $user;
    private PurchaseService $purchaseService;
    private ModelHistory $modelHistory;

    public function __construct(
        ReservationService $reservationService,
        ItemService $itemService,
        User $user,
        PurchaseService $purchaseService,
        ModelHistory $modelHistory
    ) {
        $this->reservationService = $reservationService;
        $this->itemService = $itemService;
        $this->user = $user;
        $this->purchaseService = $purchaseService;
        $this->modelHistory = $modelHistory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        $reservations = $this->reservationService->featchAllReservation($request);
        $times = $this->reservationService->getSelectOptionTime();

        return Inertia::render('Reservation/Index', [
            'reservations' => $reservations,
            'times' =>  $times
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): Response
    {
        $allItems = $this->itemService->fetchAllItems();
        $times = $this->reservationService->getSelectOptionTime();

        return Inertia::render('Reservation/Create')->with([
            'reservation' => $request,
            'item' => $allItems,
            'times' =>  $times
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReservationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreReservationRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            return $this->reservationService->storeReservation($request->getReservationParams(), $request->items);
        });

        return to_route('reservations.index')->with([
            'message' => $request->name . "様を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation): Response
    {
        $purchase =  $this->purchaseService->getPurchaseItem($reservation->id);
        $createStaffName = $this->modelHistory->getCreateReservationStaffName($reservation->id);
        $updateStaffName = $this->modelHistory->getUpdateReservationStaffName($reservation->id);

        return Inertia::render('Reservation/Show', [
            'reservation' => $reservation,
            'createStaffName' =>  $createStaffName,
            'updateStaffName' =>  $updateStaffName,
            'purchase' => $purchase
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation): Response
    {
        $reservation = $this->reservationService->findReservation($reservation->id);
        $times = $this->reservationService->getSelectOptionTime();
        $allItems = $this->itemService->fetchAllItems();
        $items = $this->reservationService->fetchItemQuantity($reservation->items, $allItems);
        $staffName = $this->user->fetchStaffName();
        $status = $this->reservationService->getSelectOptionStatus();

        return Inertia::render('Reservation/Edit', [
            'reservation' => $reservation,
            'item' => $items,
            'staffName' => $staffName,
            'times' =>  $times,
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReservationRequest  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation): RedirectResponse
    {
        DB::transaction(function () use ($request, $reservation) {
            return $this->reservationService->updateReservation($request->getReservationParams(), $request->items, $reservation);
        });

        return to_route('reservations.index')->with([
            'message' => $request->name . "様を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        $this->reservationService->deleteReservation($reservation);

        return to_route('reservations.index')->with([
            'message' => $reservation->kana . '様を削除しました',
            'status' => 'danger'
        ]);
    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function aggregate(Request $request)
    // {
    //     $aggregates = DB::table('reservations')
    //         ->selectRaw('SUM(sumprice) as sumTptal')
    //         ->selectRaw('AVG(sumprice) as avgTotal')
    //         ->selectRaw('DATE_FORMAT(time, "%Y%m%d") as time')
    //         ->selectRaw('COUNT(sumprice) as totalCount')
    //         ->groupBy('time')
    //         ->where(function ($q) use ($request) {
    //             if ($request->begin  && $request->end) {
    //                 $q->whereBetween('time', [$request->begin, $request->end]);
    //             }
    //         })
    //         ->when(empty($request->category), function ($q) {
    //             $q->orderBy('time', 'desc');
    //         })
    //         ->when(!empty($request->category) && !empty($request->order === '昇順'), function ($q) use ($request) {
    //             switch ($request->category) {
    //                 case '日付':
    //                     $q->orderBy('time', 'asc');
    //                     break;
    //                 case '合計':
    //                     $q->orderBy('sumTptal', 'asc');
    //                     break;
    //                 case '平均':
    //                     $q->orderBy('avgTotal', 'asc');
    //                     break;
    //                 case '件数':
    //                     $q->orderBy('totalCount', 'asc');
    //                     break;
    //             }
    //         })
    //         ->when(!empty($request->category) && !empty($request->order === '降順'), function ($q) use ($request) {
    //             switch ($request->category) {
    //                 case '日付':
    //                     $q->orderBy('time', 'desc');
    //                     break;
    //                 case '合計':
    //                     $q->orderBy('sumTptal', 'desc');
    //                     break;
    //                 case '平均':
    //                     $q->orderBy('avgTotal', 'desc');
    //                     break;
    //                 case '件数':
    //                     $q->orderBy('totalCount', 'desc');
    //                     break;
    //             }
    //         })
    //         ->paginate(5);

    //     return Inertia::render('Reservation/Aggregate', [
    //         'aggregates' => $aggregates
    //     ]);
    // }
}
