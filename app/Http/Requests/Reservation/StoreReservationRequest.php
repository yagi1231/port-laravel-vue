<?php

namespace App\Http\Requests\Reservation;

use App\Models\Reservation;
use App\Repository\Reservation\ReservationParams;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:20'],
            'customer_id' => ['required', 'exists:customers,id'],
            'user_id' => ['required|exists:users,id|unique:reservations,user_id'],
            'postcode' => ['required', 'regex:/^[0-9]{3}-?[0-9]{4}$/'],
            'address' => ['required', 'max:255'],
            'sumprice' => ['required', 'numeric'],
            'tel' => ['required', 'numeric', 'digits_between:8,11'],
            'remrks' => ['max:255'],
            'status' => [Rule::in(['準備中', '配達中', '再配達', '遅延'])],
            'delivery_time' => [Rule::in(Reservation::TIME_ALL)],
            'day_time' => ['date', 'regex:/^202[0-9]{1}-[0-9]{2}-[0-9]{2}$/'],
            'items' => ['required'],
            'after_address' => ['required', 'max:255']
        ];
    }

    public function getReservationParams(): ReservationParams
    {
        return new ReservationParams(
            $this->input('name'),
            $this->input('customer_id'),
            $this->input('kana'),
            $this->input('address'),
            $this->input('tel'),
            $this->input('remarks'),
            $this->input('postcode'),
            $this->input('sumprice'),
            $this->input('day_time'),
            $this->input('delivery_time'),
            $this->input('after_address'),
            (array)$this->input('item'),
            $this->input('status'),
        );
    }
}
