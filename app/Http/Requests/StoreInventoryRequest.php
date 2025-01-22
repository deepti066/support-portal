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
            // 'inv_id'               =>'req'  
            'serial_no'            => 'required|unique:inventories,serial_no',
            'product_name'         => 'required|string|max:255',
            'invoice_no'           => 'required|max:255',
            'invoice_date'         => 'nullable|date',
            'make'                 => 'required',
            'model'                => 'nullable|string|max:255',
            'asset_description'    => 'nullable|string|max:500',
            'stock_in_quantity'    => 'nullable|integer|min:0',
            'stock_in_date'        => 'nullable|date',
            'stock_out_quantity'   => 'nullable|integer|min:0',
            'stock_out_date'       => 'nullable|date',
            'balance_quantity'     => 'nullable|integer|min:0',
            'used_in'              => 'nullable|string|max:255',
            'used_by'              => 'nullable|string|max:255',
        ];
    }
}
