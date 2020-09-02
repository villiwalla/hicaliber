<?php

namespace App\Http\Requests\Api\House;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'nullable|string',
            'priceFrom' => 'nullable|integer',
            'priceTo'   => 'nullable|integer',
            'bedroom'   => 'nullable|integer',
            'bathroom'  => 'nullable|integer',
            'storey'    => 'nullable|integer',
            'garage'    => 'nullable|integer',
            'sort'      => 'nullable|string',
            'direction' => 'nullable|string',
        ];
    }
}
