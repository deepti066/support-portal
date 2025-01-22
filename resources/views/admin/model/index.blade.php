@extends('layouts.admin')
@section('content')
@can('status_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.model.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.model.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.model.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Model">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.model.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.model.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.model.fields.color') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($models as $key => $model)
                        <tr data-entry-id="{{ $model->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $model->id ?? '' }}
                            </td>
                            <td>
                                {{ $model->name ?? '' }}
                            </td>
                            <td style="background-color:{{ $model->color ?? '#FFFFFF' }}"></td>
                            <td>
                                @can('model_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.model.show', $model->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('model_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.model.edit', $model->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('model_delete')
                                    <form action="{{ route('admin.model.destroy', $model->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


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
      @foreach($model as $models)
        <option value="{{ $model->id }}"{{ request('model') == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
      @endforeach
    </select>
  </div>
</form>`;
$('.card-body').on('change', 'select', function(){
    $('#filtersForm').submit();
})

  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('inventory_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.inventory.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Model:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection