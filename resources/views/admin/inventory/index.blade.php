@extends('layouts.admin')

@section('content')
@can('inventory_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.inventory.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.inventory.title_singular') }}
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
                    <th>{{ trans('cruds.inventory.fields.id') }}</th>
                    <th>{{ trans('cruds.inventory.fields.serial_no') }}</th>
                    <th>{{ trans('cruds.inventory.fields.product_name') }}</th>
                    <th>{{ trans('cruds.inventory.fields.invoice_no') }}</th>
                    <th>{{ trans('cruds.inventory.fields.make') }}</th>
                    <th>{{ trans('cruds.inventory.fields.model') }}</th>
                    <th>{{ trans('global.actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = []
        @can('inventory_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
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
                        data: { ids: ids, _method: 'DELETE' }
                    })
                    .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        // let searchParams = new URLSearchParams(window.location.search)
        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: {
      url: "{{ route('admin.inventory.index') }}",
    //   data: {
    //     'status': searchParams.get('status'),
    //     'priority': searchParams.get('priority'),
    //     'category': searchParams.get('category')
    //   }
    },
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{
    data: 'title',
    name: 'title', 
    render: function ( data, type, row) {
        return '<a href="'+row.view_link+'">'+data+' ('+row.comments_count+')</a>';
    }
},
{ 
  data: 'status_name', 
  name: 'status.name', 
  render: function ( data, type, row) {
      return '<span style="color:'+row.status_color+'">'+data+'</span>';
  }
},
{ 
  data: 'priority_name', 
  name: 'priority.name', 
  render: function ( data, type, row) {
      return '<span style="color:'+row.priority_color+'">'+data+'</span>';
  }
},
{ 
  data: 'category_name', 
  name: 'category.name', 
  render: function ( data, type, row) {
      return '<span style="color:'+row.category_color+'">'+data+'</span>';
  } 
},
{ data: 'id', name: 'id' },
{ data: 'serial_no', name: 'serial_no' },
{ data: 'product_name', name: 'product_name' },
{ data: 'invoice_no', name: 'invoice_no' },
{ data: 'invoice_date', name: 'invoice_date' },
{ data: 'make', name: 'make' },
{ data: 'model', name: 'model' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
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