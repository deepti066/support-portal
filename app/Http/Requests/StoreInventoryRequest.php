<?php

namespace App\Http\Requests;

use App\Inventory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreInventoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('inventory_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'serial_no' => 'required|integer',
            'product_name' => 'required|string|max:255',
            'invoice_no' => 'required|max:255',
            'make' => 'required',
            'model' => 'nullable|string|max:255',
        ];
    }
}
