<?php

namespace App\Repository\Reservation;

use Illuminate\Support\Facades\Auth;

class ReservationParams
{
    private string $name;
    private int $customer_id;
    private string $kana;
    private string $address;
    private string $tel;
    private string $remarks;
    private int $postcode;
    private int $sumprice;
    private string $day_time;
    private string $delivery_time;
    private array $item;
    private string $status;
    private ?string $delivery_name;

   public function __construct(
        string $name,
        int $customer_id,
        string $kana,
        string $address,
        string $tel,
        string $remarks,
        int $postcode,
        int $sumprice,
        string $day_time,
        string $delivery_time,
        array $item,
        string $status,
        ?string $delivery_name = null
   )
   {
        $this->name = $name;
        $this->customer_id = $customer_id;
        $this->kana = $kana;
        $this->address = $address;
        $this->tel = $tel;
        $this->remarks = $remarks;
        $this->postcode = $postcode;
        $this->sumprice = $sumprice;
        $this->day_time = $day_time;
        $this->delivery_time = $delivery_time;
        $this->item = $item;
        $this->status = $status;
        $this->delivery_name = $delivery_name;
   }

    public function toArray() 
    {
        return [
            'name' =>  $this->name,
            'customer_id' => $this->customer_id,
            'kana' =>  $this->kana,
            'address' =>  $this->address,
            'tel' =>  $this->tel,
            'remarks' =>  $this->remarks,
            'postcode' =>  $this->postcode,
            'sumprice' =>  $this->sumprice,
            'time' =>  $this->day_time ,
            'datetime' => $this->delivery_time,
            'item' => $this->item,
            'user_id' => Auth::user()->id,
            'delivery' => $this->delivery_name,
            'status' => $this->status 
        ];
    }

}
