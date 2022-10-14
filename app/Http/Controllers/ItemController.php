<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(5);        
        return Inertia::render('Item/Index',[
            'items' =>  $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Item/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'allergy' => $request->allergy,
            'introduction' => $request->introduction,
            'user_id' => Auth::user()->id
        ]);

        return to_route('items.index')->with([
            'message' => "商品を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return Inertia::render('Item/Show',[
            'item' => $item,
            'staffName' => $item->user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return Inertia::render('Item/Edit',[
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $item->update([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'allergy' => $request->allergy,
            'introduction' => $request->introduction,
            'user_id' => Auth::user()->id
        ]);

        return to_route('items.index')->with([
            'message' => "商品を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return to_route('items.index')->with([
            'message' => "商品を削除しました",
            'status' => 'danger'
        ]);
    }
}
