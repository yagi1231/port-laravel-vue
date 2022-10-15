<?php

declare(strict_types=1);

namespace App\Servises;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface PurchaseService
{
    /**
     * 購入履歴の全てを返す
     * @param Request $query 検索に使うクエリ
     */
    public function fetchPaginatePurchase(Request $query): LengthAwarePaginator;

    /**
     * 購買履歴の詳細情報を取得する
     * @param int $purchase_id 詳細情報id
     */
    public function findPurchase(int $purchase_id);

    /**
     * 注文内容を取得する
     * @param int $purchase_id 詳細id
     */
    public function getPurchaseItem(int $purchase_id);

    /**
     * 顧客が最後に注文した最後の日付を取得する
     * @param int $purchase_id 顧客情報id
     */
    public function getLastOrderDay(int $purchase_id);

    /**
     * 顧客が予約した回数を取得する
     * @param int $purchase_id 顧客情報id
     */
    public function getOrderCount(int $purchase_id);
}
