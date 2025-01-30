@extends('layouts.admin')
@section('content')
@can('inventory_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.inventory.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.inventory.title_singular') }}
            </a>
            <a class="btn btn-success" href="{{ route('admin.statuses.create') }}">     
                {{ trans('global.add_stock_out') }} {{ trans('cruds.inventory.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.inventory.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Inventory">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>
                        {{ trans('cruds.inventory.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.inv_id')}}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.serial_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.product_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.invoice_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.invoice_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.make') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.model') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.asset_description') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.stock_out_quantity') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.stock_out_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.balance_quantity') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.used_in') }}
                    </th>
                    <th>
                        {{ trans('cruds.inventory.fields.used_by') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $inventory)
                    <tr data-entry-id="{{ $inventory->id }}">
                        <td></td>
                        <td>{{ $inventory->id ?? '' }}</td>
                        <td>{{ $inventory->product_name ?? '' }}</td>
                        <td style="background-color:{{ $inventory->color ?? '#FFFFFF' }}"></td>
                        <td>
                            @can('inventory_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.inventory.show', $inventory->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
            
                            @can('inventory_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.inventory.edit', $inventory->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
         </table>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        let filters = `
<form class="form-inline" id="filtersForm">
  <div class="form-group mx-sm-3 mb-2">
    <select class="form-control" name="model">
      <option value="">All models</option>
      @foreach($models as $model)
        <option value="{{ $model->id }}"{{ request('model') == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
      @endforeach
    </select>
  </div>
</form>`;
        
        $('.card-body').on('change', 'select', function() {
            $('#filtersForm').submit();
        });

        let dtButtons = []
        @can('inventory_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.inventory.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                    return entry.id
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }})
                        .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        let searchParams = new URLSearchParams(window.location.search)
        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: {
                url: "{{ route('admin.inventory.index') }}",
                data: {
                    'model': searchParams.get('model'),
                }
            },
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                { data: 'id', name: 'id' },
                { data: 'inv_id', name: 'inv_id'},
                { data: 'serial_no', name: 'serial_no' },
                { data: 'product_name', name: 'product_name' },
                { data: 'invoice_no', name: 'invoice_no' },
                { data: 'invoice_date', name: 'invoice_date' },
                { data: 'make', name: 'make' },
                { data: 'model', name: 'model' },
                { data: 'asset_description', name: 'asset_description' },
                { data: 'stock_out_quantity', name: 'stock_out_quantity' },
                { data: 'stock_out_date', name: 'stock_out_date' },
                { data: 'balance_quantity', name: 'balance_quantity' },
                { data: 'used_in', name: 'used_in' },
                { data: 'used_by', name: 'used_by' },
                { data: 'actions', name: '{{ trans('global.actions') }}' }
            ],
            order: [[ 4, 'ASC' ]],
            pageLength: 100,
        };

        $(".datatable-Inventory").one("preInit.dt", function () {
            $(".dataTables_filter").after(filters);
        });

        $('.datatable-Inventory').DataTable(dtOverrideGlobals);

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
 