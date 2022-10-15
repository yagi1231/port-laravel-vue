<?php

namespace App\Repository\Item;

use Illuminate\Support\Facades\Auth;

class ItemParams
{
    private string $name;
    private int $price;
    private string $status;
    private string $allergy;
    private string $introduction;

    public function __construct(
        string $name,
        int $price,
        string $status,
        string $allergy,
        string $introduction,
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->status = $status;
        $this->allergy = $allergy;
        $this->introduction = $introduction;
    }

    public function toArray()
    {
        return [
            'name' =>  $this->name,
            'price' =>  $this->price,
            'allergy' =>  $this->allergy,
            'introduction' => $this->introduction,
            'status' => $this->status ,
            'user_id' => Auth::user()->id
        ];
    }
}
