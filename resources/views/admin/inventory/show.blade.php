@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.inventory.title_singular') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.id') }}</th>
                    <td>{{ $inventory->id }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.serial_no') }}</th>
                    <td>{{ $inventory->serial_no }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.product_name') }}</th>
                    <td>{{ $inventory->product_name }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.invoice_no') }}</th>
                    <td>{{ $inventory->invoice_no }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.invoice_date') }}</th>
                    <td>{{ $inventory->invoice_date }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.make') }}</th>
                    <td>{{ $inventory->make }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.model') }}</th>
                    <td>{{ $inventory->model }}</td>
                </tr>
            </tbody>
        </table>
        <a class="btn btn-primary" href="{{ route('admin.inventory.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>

    <nav class="mb-3">
        <div class="nav nav-tabs">

        </div>
    </nav>

    </div>


</div>
@endsection
