<?php

namespace App\Http\Requests;

use App\Http\Requests\Core\JsonRequest;
use Illuminate\Foundation\Http\FormRequest;

class SearchUsersRequest extends JsonRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'filters' => [
                'withDisabled' => false
            ],
            'order' => [
                'order_by' => $this->order['order_by'] ?? 'created',
                'sort_by' => $this->order['sort_by'] ?? 'desc'
            ],
            'paginate' => 10
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filters' => 'required|array',
            'filters.withDisabled' => 'required|boolean',
            'filters.roles' => 'sometimes|array',
            'filters.roles.*' => 'numeric',
            'filters.name' => 'sometimes|string|min:3',
            'order' => 'required|array',
            'order.sort_by' => 'sometimes|string',
            'paginate' => 'numeric'
        ];
    }
}