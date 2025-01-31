<?php

namespace App\Http\Requests;

use App\Stock;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyStockRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('stock_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'ids'   => 'required|array',
            'ids.*'  => 'exists:stock,id',
        ];
    }
}
