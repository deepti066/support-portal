<?php

namespace App\Http\Requests;

use Stock;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('stock_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
