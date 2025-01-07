<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyModelRequest;
use App\Http\Requests\StoreModelRequest;
use App\Http\Requests\UpdateModelRequest;
use App\Models;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModelController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('model_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $models = Models::all();

        return view('admin.model.index', compact('models'));
    }

    public function create()
    {
        abort_if(Gate::denies('model_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.model.create');
    }

    public function store(StoreModelRequest $request)
    {
        $model = Models::create($request->all()); 
        
        return redirect()->route('admin.model.index');
    }

    public function edit(Models $model)
    {
        abort_if(Gate::denies('model_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.model.edit', compact('model'));
    }

    public function update(UpdateModelRequest $request, Models $model)
    {
        $model->update($request->all());

        return redirect()->route('admin.model.index');
    }

    public function show(Models $model)
    {
        abort_if(Gate::denies('model_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.model.show', compact('model'));
    }

    public function destroy(Models $model)
    {
        abort_if(Gate::denies('model_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model->delete();

        return back();
    }

    public function massDestroy(MassDestroyModelRequest $request)
    {
        Models::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
