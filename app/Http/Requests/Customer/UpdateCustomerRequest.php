<?php

namespace App\Http\Requests\Customer;

use App\Repository\Customer\CustomerParams;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'kana' => ['required', 'max:20'],
            'address' => ['required', 'max:255'],
            'affter_address' => ['required', 'max:255'],
            'postcode' => ['required', 'digits:7'],
            'tel' => ['required', 'numeric', 'digits_between:8,11'],
            'postcode' => ['required', 'regex:/^[0-9]{3}-?[0-9]{4}$/'],
            'remrks' => ['max:255'],
        ];
    }

    public function getCustomerParams(): CustomerParams
    {
        return new CustomerParams(
            $this->input('name'),
            $this->input('kana'),
            $this->input('postcode'),
            $this->input('address'),
            $this->input('affter_address'),
            $this->input('tel'),
            $this->input('remarks'),
        );
    }
}
