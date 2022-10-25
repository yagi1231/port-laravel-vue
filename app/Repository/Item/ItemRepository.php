<?php

namespace App\Repository\Item;

use App\Models\Item;
use App\Servises\ItemService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemRepository implements ItemService
{
    public function fetchAllItems(): Collection
    {
        return Item::where('status', '販売中')->get();
    }  

    public function fetchPaginateItems(Request $query): LengthAwarePaginator
    {
        return Item::query()
        ->where(function($q) use ($query) {
            if($query['inputingName']) {
                $q->where('name', $query['inputingName']);
            }
            if($query['status']) {
                $q->where('status', $query['status']);
            }
        })
        ->paginate(10);
    }  

    public function storeItem(ItemParams $param): void
    {
        Item::create($param->toArray());
    }  

    public function updateItem(ItemParams $param, Item $item): void
    {
        $item->update($param->toArray());
    }  

    public function deleteItem(Item $item): void
    {
        $item->delete();
    }  
}
