@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.stock.title_singular') }}
    </div>

    <div class="card-body">
        @if (@session('model'))
            <div class="alert alert-success" role="alert">
                {{session('model')}}
            </div>
         @endsession)
            
        @endif
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>{{ trans('cruds.stock.fields.id') }}</th>
                    <td>{{ $stock->id }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.serial_no') }}</th>
                    <td>{{ $stock->inventory->serial_no }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.product_name') }}</th>
                    <td>{{ $stock->inventory->product_name }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.invoice_no') }}</th>
                    <td>{{ $stock->invoice_no }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.invoice_date') }}</th>
                    <td>{{ $stock->inventory->invoice_date }}</td>
                </tr>
                {{-- <tr>
                    <th>{{ trans('cruds.stock.fields.make') }}</th>
                    <td>{{ $inventory->make }}</td>
                </tr> --}}
                <tr>
                    <th>{{ trans('cruds.stock.fields.model') }}</th>
                    <td>{{ $stock->inventory->models->name }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.asset_description') }}</th>
                    <td>{{ $stock->inventory->asset_description }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.stock_out_quantity') }}</th>
                    <td>{{ $stock->stock_quantity }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.balance_quantity') }}</th>
                    <td>{{ $stock->stock_type }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.used_in') }}</th>
                    <td>{{ $stock->used_in }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.stock.fields.used_by') }}</th>
                    <td>{{ $stock->used_by }}</td>
                </tr>
            </tbody>
        </table>
        <a class="btn btn-primary" href="{{ route('admin.stock.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
        {{-- <a class="btn btn-primary" href="{{ route('admin.stock.index') }}">
            {{ trans('global.stock_details') }}
        </a> --}}
    </div>

    <nav class="mb-3">
        <div class="nav nav-tabs">

        </div>
    </nav>

    </div>


</div>
@endsection
