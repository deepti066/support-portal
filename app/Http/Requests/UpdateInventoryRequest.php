<?php

namespace App\Http\Requests;

use App\Inventory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateInventoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('inventory_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'product_name'  => [
                'required',
            ],
            'invoice_no' => [
                'required',
            ],
            'make' => [
                'required',
            ],
            'model' => [
                'required',
            ],
        ];
    }
}