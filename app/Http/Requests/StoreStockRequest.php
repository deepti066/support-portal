<?php

namespace App\Http\Requests;

use App\Stock;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('stock_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            
        ];
    }
}
