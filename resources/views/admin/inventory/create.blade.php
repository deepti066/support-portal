@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.inventory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.inventory.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="serial_no">{{ trans('cruds.inventory.fields.serial_no') }}</label>
                <input class="form-control {{ $errors->has('serial_no') ? 'is-invalid' : '' }}" type="int" name="serial_no" id="serial_no" value="{{ old('serial_no', '') }}">
                @if($errors->has('serial_no'))
                    <span class="text-danger">{{ $errors->first('serial_no') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="product_name">{{ trans('cruds.inventory.fields.product_name') }}</label>
                <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" type="text" name="product_name" id="product_name" value="{{ old('product_name', '') }}">
                @if($errors->has('product_name'))
                    <span class="text-danger">{{ $errors->first('product_name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="invoice_no">{{ trans('cruds.inventory.fields.invoice_no') }}</label>
                <input class="form-control {{ $errors->has('invoice_no') ? 'is-invalid' : '' }}" type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no', '') }}">
                @if($errors->has('invoice_no'))
                    <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="invoice_date">{{ trans('cruds.inventory.fields.invoice_date') }}</label>
                <input class="form-control {{ $errors->has('invoice_date') ? 'is-invalid' : '' }}" type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', '') }}">
                @if($errors->has('invoice_date'))
                    <span class="text-danger">{{ $errors->first('invoice_date') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="make">{{ trans('cruds.inventory.fields.make') }}</label>
                <input class="form-control {{ $errors->has('make') ? 'is-invalid' : '' }}" type="text" name="make" id="make" value="{{ old('make', '') }}">
                @if($errors->has('make'))
                    <span class="text-danger">{{ $errors->first('make') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="model">{{ trans('cruds.inventory.fields.model') }}</label>
                <input class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" type="text" name="model" id="model" value="{{ old('model', '') }}">
                @if($errors->has('model'))
                    <span class="text-danger">{{ $errors->first('model') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="asset_description">{{ trans('cruds.inventory.fields.asset_description') }}</label>
                <input class="form-control {{ $errors->has('asset_description') ? 'is-invalid' : '' }}" type="text" name="asset_description" id="asset_description" value="{{ old('asset_description', '') }}">
                @if($errors->has('asset_description'))
                    <span class="text-danger">{{ $errors->first('asset_description') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="stock_in_quantity">{{ trans('cruds.inventory.fields.stock_in_quantity') }}</label>
                <input class="form-control {{ $errors->has('stock_in_quantity') ? 'is-invalid' : '' }}" type="text" name="stock_in_quantity" id="stock_in_quantity" value="{{ old('stock_in_quantity', '') }}">
                @if($errors->has('stock_in_quantity'))
                    <span class="text-danger">{{ $errors->first('stock_in_quantity') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="stock_in_date">{{ trans('cruds.inventory.fields.stock_in_date') }}</label>
                <input class="form-control {{ $errors->has('stock_in_date') ? 'is-invalid' : '' }}" type="date" name="stock_in_date" id="stock_in_date" value="{{ old('stock_in_date', '') }}">
                @if($errors->has('stock_in_date'))
                    <span class="text-danger">{{ $errors->first('stock_in_date') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="model">{{ trans('cruds.inventory.fields.stock_out_quantity') }}</label>
                <input class="form-control {{ $errors->has('stock_out_quantity') ? 'is-invalid' : '' }}" type="text" name="stock_out_quantity" id="stock_out_quantity" value="{{ old('stock_out_quantity', '') }}">
                @if($errors->has('stock_out_quantity'))
                    <span class="text-danger">{{ $errors->first('stock_out_quantity') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="stock_out_date">{{ trans('cruds.inventory.fields.stock_out_date') }}</label>
                <input class="form-control {{ $errors->has('stock_out_quantity') ? 'is-invalid' : '' }}" type="date" name="stock_out_date" id="stock_out_date" value="{{ old('stock_out_date', '') }}">
                @if($errors->has('stock_out_date'))
                    <span class="text-danger">{{ $errors->first('stock_out_date') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="balance_quantity">{{ trans('cruds.inventory.fields.balance_quantity') }}</label>
                <input class="form-control {{ $errors->has('balance_quantity') ? 'is-invalid' : '' }}" type="text" name="balance_quantity" id="balance_quantity" value="{{ old('balance_quantity', '') }}">
                @if($errors->has('balance_quantity'))
                    <span class="text-danger">{{ $errors->first('balance_quantity') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="used_in">{{ trans('cruds.inventory.fields.used_in') }}</label>
                <input class="form-control {{ $errors->has('used_in') ? 'is-invalid' : '' }}" type="text" name="used_in" id="used_in" value="{{ old('used_in', '') }}">
                @if($errors->has('used_in'))
                    <span class="text-danger">{{ $errors->first('used_in') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="used_by">{{ trans('cruds.inventory.fields.used_by') }}</label>
                <input class="form-control {{ $errors->has('used_by') ? 'is-invalid' : '' }}" type="text" name="used_by" id="used_by" value="{{ old('used_by', '') }}">
                @if($errors->has('used_by'))
                    <span class="text-danger">{{ $errors->first('used_by') }}</span>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
