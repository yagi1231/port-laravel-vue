<?php

declare(strict_types=1);

namespace App\Servises;

use App\Models\Item;
use App\Repository\Item\ItemParams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ItemService
{
    /**
     * 商品の販売中のもの全てを取得する
     */
    public function fetchAllItems(): Collection;

    /**
     * 商品情報を10件ずつ表示する
     */
    public function fetchPaginateItems(): LengthAwarePaginator;

    /**
     * 商品情報を登録する
     * @param ItemParams $param 商品の登録情報
     */
    public function storeItem(ItemParams $param): void;

    /**
     * 商品情報を更新する
     *　@param ItemParams $param 商品の更新情報
     *　@param Item $item 更新する商品情報
     */
    public function updateItem(ItemParams $param, Item $item): void;

        /**
     * 商品情報を削除する
     *　@param Item $item 削除する商品情報
     */
    public function deleteItem(Item $item): void;
}
