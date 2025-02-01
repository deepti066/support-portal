@extends('layouts.admin')
@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (Popper included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.inventory.title_singular') }}
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
                    <th>{{ trans('cruds.inventory.fields.id') }}</th>
                    <td>{{ $inventory->id }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.inv_id')}}</th>
                    <td>{{ $inventory->inv_id }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.serial_no') }}</th>
                    <td>{{ $inventory->serial_no }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.product_name') }}</th>
                    <td>{{ $inventory->product_name }}</td>
                </tr>
                {{-- <tr>
                    <th>{{ trans('cruds.inventory.fields.invoice_no') }}</th>
                    <td>{{ $inventory->invoice_no }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.invoice_date') }}</th>
                    <td>{{ $inventory->invoice_date }}</td>
                </tr> --}}
                <tr>
                    <th>{{ trans('cruds.inventory.fields.make') }}</th>
                    <td>{{ $inventory->make }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.model') }}</th>
                    <td>{{ $inventory->model }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.asset_description') }}</th>
                    <td>{{ $inventory->asset_description }}</td>
                </tr>
                {{-- <tr>
                    <th>{{ trans('cruds.inventory.fields.stock_in_quantity') }}</th>
                    <td>{{ $inventory->stock_in_quantity }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.stock_in_date') }}</th>
                    <td>{{ $inventory->stock_in_date }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.stock_out_quantity') }}</th>
                    <td>{{ $inventory->stock_out_quantity }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.balance_quantity') }}</th>
                    <td>{{ $inventory->balance_quantity }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.used_in') }}</th>
                    <td>{{ $inventory->used_in }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.inventory.fields.used_by') }}</th>
                    <td>{{ $inventory->used_by }}</td>
                </tr> --}}
            </tbody>
        </table>
        <a class="btn btn-primary" href="{{ route('admin.inventory.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stockModal">
            {{ trans('global.stock_details') }}
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stockModalOut">
            {{ trans('global.stock_out') }}
        </button>
        <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stockModalLabel">Add Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Stock In Form -->
                        <form method="POST" action="{{ route('admin.stock.stockIn') }}">
                            @csrf

                            <input type="hidden" name="inventory_id" value="{{ $inventory->id }}" />
                            <input type="hidden" name="stock_type" value="1" />
                            <div class="mb-3">
                                <label class="form-label">Invoice Number</label>
                                <input type="text" name="invoice_no" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Invoice Date</label>
                                <input type="date" name="invoice_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="stock_quantity" class="form-control" required>
                            </div><div class="mb-3">
                                <label class="form-label">Stock Date</label>
                                <input type="date" name="stock_date" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

            <!-- Stock Out Form-->
            <div class="modal fade" id="stockModalOut" tabindex="-1" aria-labelledby="stockModalLabelOut" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="stockModalLabelOut">Add Stock</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Stock Form -->
                            <form method="POST" action="{{ route('admin.stock.stockOut') }}">
                                @csrf
    
                                <input type="hidden" name="inventory_id" value="{{ $inventory->id }}" />
                                <input type="hidden" name="stock_type" value="2" />
                                <div class="mb-3">
                                    <label class="form-label">Invoice Number</label>
                                    <input type="text" name="invoice_no" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="stock_quantity" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stock Date</label>
                                    <input type="date" name="stock_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Used In</label>
                                    <input type="text" name="used_in" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Used By</label>
                                    <input type="text" name="used_by" class="form-control" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    

    <nav class="mb-3">
        <div class="nav nav-tabs">

        </div>
    </nav>

    </div>


</div>
@endsection
