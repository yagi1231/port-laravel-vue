<?php

namespace App\Repository\Customer;

use Illuminate\Support\Facades\Auth;

class CustomerParams
{
    private string $name;
    private string $kana;
    private int $postcode;
    private string $address;
    private string $tel;
    private ?string $remarks;

    public function __construct(
        string $name,
        string $kana,
        int $postcode,
        string $address,
        string $tel,
        ?string $remarks = null,
    ) {
        $this->name = $name;
        $this->kana = $kana;
        $this->postcode = $postcode;
        $this->address = $address;
        $this->tel = $tel;
        $this->remarks = $remarks;
    }

    public function toArray()
    {
        return [
            'name' =>  $this->name,
            'kana' =>  $this->kana,
            'postcode' =>  $this->postcode,
            'address' =>  $this->address,
            'tel' =>  $this->tel,
            'remarks' =>  $this->remarks,
            'user_id' => Auth::user()->id,
        ];
    }
}
