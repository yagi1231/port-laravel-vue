<?php

namespace App\Http\Requests\Item;

use App\Repository\Item\ItemParams;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItemRequest extends FormRequest
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
            'price' => ['required', 'numeric', ],
            'allergy' => ['max:255'],
            'introduction' => ['max:255'],
            'status' => [Rule::in(['販売中', '販売停止'])]
        ];
    }

    public function getItemParams(): ItemParams
    {
        return new ItemParams(
            $this->input('name'),
            $this->input('price'),
            $this->input('status'),
            $this->input('allergy'),
            $this->input('introduction'),
        );
    }
}
