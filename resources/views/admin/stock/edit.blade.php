@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.stock.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.stock.update", [$stock->id]) }}"  method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{-- <div class="form-group">
                <label for="inv_id">{{ trans('cruds.stock.fields.inv_id') }}</label>
                <input class="form-control {{ $errors->has('inv_id') ? 'is-invalid' : '' }}" type="text" name="inv_id" id="inv_id" value="{{ old('inv_id', '') }}">
                @if($errors->has('inv_id'))
                    <span class="text-danger">{{ $errors->first('inv_id') }}</span>
                @endif
            </div> --}}
            <div class="form-group">
                <label for="serial_no">{{ trans('cruds.stock.fields.serial_no') }}</label>
                <input class="form-control {{ $errors->has('serial_no') ? 'is-invalid' : '' }}" type="int" name="serial_no" id="serial_no" value="{{ old('serial_no', $stock->serial_no) }}">
                @if($errors->has('serial_no'))
                    <span class="text-danger">{{ $errors->first('serial_no') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="product_name">{{ trans('cruds.stock.fields.product_name') }}</label>
                <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" type="text" name="product_name" id="product_name" value="{{ old('product_name', $stock->product_name) }}">
                @if($errors->has('product_name'))
                    <span class="text-danger">{{ $errors->first('product_name') }}</span>
                @endif
            </div>
            
            <div class="form-group">
                <label for="invoice_no">{{ trans('cruds.stock.fields.invoice_no') }}</label>
                <input class="form-control {{ $errors->has('invoice_no') ? 'is-invalid' : '' }}" type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no', $stock->invoice_no) }}">
                @if($errors->has('invoice_no'))
                    <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="invoice_date">{{ trans('cruds.stock.fields.invoice_date') }}</label>
                <input class="form-control {{ $errors->has('invoice_date') ? 'is-invalid' : '' }}" type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', $stock->invoice_date) }}">
                @if($errors->has('invoice_date'))
                    <span class="text-danger">{{ $errors->first('invoice_date') }}</span>
                @endif
            </div>
            {{-- <div class="form-group">
                <label for="make">{{ trans('cruds.stock.fields.make') }}</label>
                <input class="form-control {{ $errors->has('make') ? 'is-invalid' : '' }}" type="text" name="make" id="make" value="{{ old('make', $inventory->make) }}">
                @if($errors->has('make'))
                    <span class="text-danger">{{ $errors->first('make') }}</span>
                @endif
            </div> --}}
            <div class="form-group {{ $errors->has('model_id') ? 'has-error' : '' }}">
                <label for="model">{{ trans('cruds.inventory.fields.model') }}*</label>
                <select name="model_id" id="model" class="form-control select2" required>
                    @foreach($models as $id => $model)
                        <option value="{{ $id }}" 
                        {{ (isset($inventory) && $inventory->model ? $inventory->id : old('model_id')) == $id ? 'selected' : '' }}>
                            {{ $model }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('model_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('model_id') }}
                    </em>
                @endif
            </div>                       
            <div class="form-group">
                <label for="asset_description">{{ trans('cruds.stock.fields.asset_description') }}</label>
                <input class="form-control {{ $errors->has('asset_description') ? 'is-invalid' : '' }}" type="text" name="asset_description" id="asset_description" value="{{ old('asset_description', $stock->asset_description) }}">
                @if($errors->has('asset_description'))
                    <span class="text-danger">{{ $errors->first('asset_description') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="model">{{ trans('cruds.stock.fields.stock_out_quantity') }}</label>
                <input class="form-control {{ $errors->has('stock_out_quantity') ? 'is-invalid' : '' }}" type="text" name="stock_out_quantity" id="stock_out_quantity" value="{{ old('stock_out_quantity', $stock->stock_out_quantity) }}">
                @if($errors->has('stock_out_quantity'))
                    <span class="text-danger">{{ $errors->first('stock_out_quantity') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="stock_out_date">{{ trans('cruds.stock.fields.stock_out_date') }}</label>
                <input class="form-control {{ $errors->has('stock_out_date') ? 'is-invalid' : '' }}" type="date" name="stock_out_date" id="stock_out_date" value="{{ old('stock_out_date', $stock->stock_out_date) }}">
                @if($errors->has('stock_out_date'))
                    <span class="text-danger">{{ $errors->first('stock_out_date') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="balance_quantity">{{ trans('cruds.stock.fields.balance_quantity') }}</label>
                <input class="form-control {{ $errors->has('balance_quantity') ? 'is-invalid' : '' }}" type="text" name="balance_quantity" id="balance_quantity" value="{{ old('balance_quantity', $stock->balance_quantity) }}">
                @if($errors->has('balance_quantity'))
                    <span class="text-danger">{{ $errors->first('balance_quantity') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="used_in">{{ trans('cruds.stock.fields.used_in') }}</label>
                <input class="form-control {{ $errors->has('used_by') ? 'is-invalid' : '' }}" type="text" name="used_in" id="used_in" value="{{ old('used_in', $stock->used_in) }}">
                @if($errors->has('used_in'))
                    <span class="text-danger">{{ $errors->first('used_in') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="used_by">{{ trans('cruds.stock.fields.used_by') }}</label>
                <input class="form-control {{ $errors->has('used_by') ? 'is-invalid' : '' }}" type="text" name="used_by" id="used_by" value="{{ old('used_by', $stock->used_by) }}">
                @if($errors->has('used_by'))
                    <span class="text-danger">{{ $errors->first('used_by') }}</span>
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.update') }}
                </button>
            </div>
            <p class="helper-block">
                {{ trans('cruds.role.fields.permissions_helper') }}
            </p>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
