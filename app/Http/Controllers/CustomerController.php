<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdatecustomerRequest;
use App\Models\Customer;
use App\Servises\CustomerService;
use App\Servises\PurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    private CustomerService $customerService;
    private  PurchaseService $purchaseService;

    public function __construct(
        CustomerService $customerService,
        PurchaseService $purchaseService,
    ) {
        $this->customerService = $customerService;
        $this->purchaseService = $purchaseService;;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        $customers = $this->customerService->fetchAllCustomer($request);

        return Inertia::render('Customer/Index', [
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecustomerRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $customer = DB::transaction(function () use ($request) {
            return $this->customerService->storeCustomer($request->getCustomerParams());
        });

        return to_route('customers.show', ['customer' => $customer->id])->with([
            'message' => $request->name . "様を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(customer $customer): Response
    {
        $lastOrderDay = $this->purchaseService->getLastOrderDay($customer->id);
        $orderCount =  $this->purchaseService->getOrderCount($customer->id);

        return Inertia::render('Customer/Show', [
            'customer' => $customer,
            'staff' =>  $customer->user,
            'lastOrderDay' => $lastOrderDay,
            'orderCount' =>  $orderCount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer): Response
    {
        return Inertia::render('Customer/Edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecustomerRequest  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatecustomerRequest $request, customer $customer): RedirectResponse
    {
        DB::transaction(function () use ($request, $customer) {
            $this->customerService->updateCustomer($request->getCustomerParams(), $customer);
        });

        return to_route('customers.show', ['customer' => $customer->id])->with([
            'message' => $request->name . "様を更新しました",
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(customer $customer): RedirectResponse
    {
        $this->customerService->deleteCustomer($customer);

        return to_route('customers.index')->with([
            'message' => $customer->kana . "様を削除しました",
            'status' => 'danger'
        ]);
    }
}
