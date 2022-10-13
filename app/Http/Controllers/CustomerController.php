<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdatecustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $customers = Customer::query()
       ->where(function($q) use ($request) {
           if(($request['ninputingName'] || $request['inputingTel'] || $request['inputingAddress'])) {
            $q->where('tel', $request['inputingTel'])
            ->orwhere('name', $request['inputingName'])
            ->orwhere('address',  $request['inputingAddress']);
           }
       })->paginate(10);

       return Inertia::render('Customer/Index', [
        'customers' => $customers,
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    { 
        Customer::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'tel' => $request->tel,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'remarks' => $request->remarks,
            'user_id' => Auth::user()->id
        ]);
        
        return to_route('customers.index')->with([
            'message' => $request->name."様を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(customer $customer)
    {
        return Inertia::render('Customer/Show', [
            'customer' => $customer,
            'staff' =>  $customer->user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer)
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecustomerRequest $request, customer $customer)
    {
        $customer->update([
            'name' => $request->name,
            'kana' => $request->kana,
            'tel' => $request->tel,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'remarks' => $request->remarks,
            'user_id' => Auth::user()->id
        ]);

        return to_route('customers.index')->with([
            'message' => $request->name."様を更新しました",
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customer $customer)
    {
        $customer->delete();

        return to_route('customers.index')->with([
            'message' => $customer->kana."様を削除しました",
            'status' => 'danger'
        ]);
    }
}
