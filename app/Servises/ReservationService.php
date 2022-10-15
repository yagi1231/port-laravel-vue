<?php
declare(strict_types=1);

namespace App\Servises;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Reservation;
use App\Repository\Reservation\ReservationParams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ReservationService
{
     /**
     * 予約状況の情報を取得し、10件ずつ表示する
     * @param Request $query 検索情報
     */
    public function featchAllReservation(Request $query): LengthAwarePaginator;

    /**
     * 予約情報を登録する
     * @param ReservationParams $params 登録情報
     * @param Array $items 注文内容
     */
    public function storeReservation(ReservationParams $params, Array $items): void;

    /**
     * 予約情報の詳細を取得する
     * @param int $reservation_id　予約id
     */
    public function findReservation(int $reservation_id): Reservation;

    /**
     * 予約情報に紐づく商品数量を取得する
     * @param array $reservation_item 予約に紐づく商品情報
     * @param array $allItems　全ての商品情報
     */
    public function fetchItemQuantity(collection $reservation_item, collection $allItems): Array;

    /**
     * 予約情報を更新する
     * @param array $reservation_item 予約に紐づく商品情報
     * @param array $allItems　全ての商品情報
     */
    public function updateReservation(ReservationParams $params, Array $itemQuantity, Reservation $reservation): void;

    /**
     * 予約情報を削除する(ソフトデリート)
     * @params Reservation $reservation 削除する予約情報
     */
    public function deleteReservation(Reservation $reservation): void; 

    /**
     * 予約情報の選択時間の取得
     */
    public function getSelectOptionTime(): Array;

    /**
     * 予約状態を表すステータスの取得
     */
    public function getSelectOptionStatus(): Array;
}
