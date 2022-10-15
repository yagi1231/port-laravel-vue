<?php

declare(strict_types=1);

namespace App\Servises;

use App\Models\Customer;
use App\Repository\Customer\CustomerParams;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerService
{
    /**
     * 予約状況の情報を取得し、10件ずつ表示する
     * @param Request $query 検索情報
     */
    public function fetchAllCustomer(Request $query): LengthAwarePaginator;

    /**
     * 顧客情報を登録する
     * @param customerParams $params 顧客登録情報
     */
    public function storeCustomer(CustomerParams $params): void;
    
        /**
     * 予約情報を更新する
     * @param CustomerParams $params 更新情報
     * @param Customer $reservation 更新する情報
     */
    public function updateCustomer(CustomerParams $params, Customer $customer): void;

          /**
     * 予約情報を削除する(ソフトデリート)
     * @param Reservation $reservation 削除する顧客情報
     */
    public function deleteCustomer(Customer $customer): void;
}
