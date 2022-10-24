<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Models\Item;
use App\Servises\ItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    private ItemService $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $items = $this->itemService->fetchPaginateItems($request);
        $status = Item::ITEM_STATUS_ALL;

        return Inertia::render('Item/Index', [
            'items' =>  $items,
            'status' =>  $status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        $status = Item::ITEM_STATUS_ALL;
        return Inertia::render('Item/Create', [
            'state' =>  $status
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        $this->itemService->storeItem($request->getItemParams());

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
    public function show(Item $item): Response
    {
        return Inertia::render('Item/Show', [
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
    public function edit(Item $item): Response
    {
        $status = Item::ITEM_STATUS_ALL;

        return Inertia::render('Item/Edit', [
            'item' => $item,
            'state' =>  $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {

        $this->itemService->updateItem($request->getItemParams(), $item);

        return to_route('items.index')->with([
            'message' => "商品を登録しました",
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Item $item): RedirectResponse
    {
        $this->itemService->deleteItem($item);

        return to_route('items.index')->with([
            'message' => "商品を削除しました",
            'status' => 'danger'
        ]);
    }
}
