<?php

namespace App\Http\Controllers;

use App\Servises\PurchaseService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseController extends Controller
{
    private PurchaseService $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $purchases = $this->purchaseService->fetchPaginatePurchase($request);

        return Inertia::render('Purchase/Index', [
            'purchases' => $purchases
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): Response
    {
        $purchase = $this->purchaseService->getPurchaseItem($id);

        $totalPurchases = $this->purchaseService->findPurchase($id);

        return Inertia::render('Purchase/Show', [
            'totalPurchases' => $totalPurchases,
            'purchase' => $purchase
        ]);
    }
}
