<?php

namespace App\Repository\Item;

use App\Models\Item;
use App\Servises\ItemService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemRepository implements ItemService
{
    public function fetchAllItems(): Collection
    {
        return Item::where('status', '販売中')->get();
    }  

    public function fetchPaginateItems(): LengthAwarePaginator
    {
        return Item::paginate(10);
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
