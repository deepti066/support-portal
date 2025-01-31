@extends('layouts.admin')
@section('content')
@can('stock_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.stock.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.stock.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.stock.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Stock">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>
                        {{ trans('cruds.stock.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.serial_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.product_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.invoice_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.invoice_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.model') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.asset_description') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.stock_out_quantity') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.stock_out_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.balance_quantity') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.used_in') }}
                    </th>
                    <th>
                        {{ trans('cruds.stock.fields.used_by') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr data-entry-id="{{ $stock->id }}">
                        <td></td>
                        <td>{{ $stock->id ?? '' }}</td>
                        <td>{{ $stock->product_name ?? '' }}</td>
                        <td style="background-color:{{ $stock->color ?? '#FFFFFF' }}"></td>
                        <td>
                            @can('stock_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.stock.show', $stock->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan
            
                            @can('stock_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.stock.edit', $stock->id) }}">
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
        @can('stock_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.stock.massDestroy') }}",
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
                url: "{{ route('admin.stock.index') }}",
                data: {
                    'model': searchParams.get('model'),
                }
            },
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                { data: 'id', name: 'id' },
                { data: 'serial_no', name: 'serial_no' },
                { data: 'product_name', name: 'product_name' },
                { data: 'invoice_no', name: 'invoice_no' },
                { data: 'invoice_date', name: 'invoice_date' },
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

        $(".datatable-Stock").one("preInit.dt", function () {
            $(".dataTables_filter").after(filters);
        });

        $('.datatable-Stock').DataTable(dtOverrideGlobals);

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
 