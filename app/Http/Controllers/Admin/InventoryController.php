<?php
namespace App\Http\Controllers\Admin;

use App\Inventory; 
use App\Brand;
use App\Models;
use Gate;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class InventoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Inventory::with('models')->select("*");

            if ($request->has('model_id') && $request->model_id != '') {
                $query->where('model', $request->model_id);
            
            }


            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'inventory_show';
                $editGate      = 'inventory_edit';
                $deleteGate    = 'inventory_delete';
                $crudRoutePart = 'inventory';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('inv_id', function ($row) {
                return $row->inv_id ? $row->inv_id : "";
            });
            $table->editColumn('product_name', function ($row) {
                return $row->product_name ? $row->product_name : "";
            });
          
            $table->editColumn('serial_no', function ($row) {
                return $row->serial_no ? $row->serial_no : "";
            });
    
            $table->editColumn('invoice_no', function ($row) {
                return $row->invoice_no ? $row->invoice_no : "";
            });
    
            $table->editColumn('make', function ($row) {
                return $row->make ? $row->make : "";
            });

            $table->editColumn('model', function ($row) {
                
                return $row->models ? $row->models->name : "";
            });
    
            $table->editColumn('invoice_date', function ($row) {
                return $row->invoice_date ? $row->invoice_date : "";
            });

            $table->editColumn('asset_description', function ($row) {
                return $row->asset_description ? $row->asset_description : "";
            });

            $table->editColumn('stock_in_quantity', function ($row) {
                return $row->stock_in_quantity ? $row->stock_in_quantity : "";
            });

            $table->editColumn('stock_in_date', function ($row) {
                return $row->stock_in_date ? $row->stock_in_date : "";
            });

            $table->editColumn('stock_out_quantity', function ($row) {
                return $row->stock_out_quantity ? $row->stock_out_quantity : "";
            });

            $table->editColumn('stock_out_date', function ($row) {
                return $row->stock_out_date ? $row->stock_out_date : "";
            });

            $table->editColumn('balance_quantity', function ($row) {
                return $row->balance_quantity ? $row->balance_quantity : "";
            });

            $table->editColumn('used_in', function ($row) {
                return $row->used_in ? $row->used_in : "";
            });

            $table->editColumn('used_by', function ($row) {
                return $row->used_by ? $row->used_by : "";
            });
    
            $table->addColumn('view_link', function ($row) {
                return route('admin.inventory.show', $row->id);
            });

            $table->rawColumns(['actions','placeholder','model']);

            return $table->make(true);
        }
        $models = Models::all();
        $inventories = Inventory::all();
    return view('admin.inventory.index', compact('inventories', 'models'));
    }
    
    public function create()
    {
        $models = Models::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        

        $brands = Brand::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        return view('admin.inventory.create', compact('brands', 'models'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'serial_no'            => 'nullable|string|max:255|unique:inventories,serial_no',
        'product_name'         => 'required|string|max:255',
        'invoice_no'           => 'nullable|string|max:255',
        'invoice_date'         => 'nullable|date',
        'make'                 => 'nullable|string|max:255',
        'model'                => 'nullable|string|max:255',
        'asset_description'    => 'nullable|string|max:500',
        'stock_in_quantity'    => 'nullable|integer|min:0',
        'stock_in_date'        => 'nullable|date',
        'stock_out_quantity'   => 'nullable|integer|min:0',
        'stock_out_date'       => 'nullable|date',
        'balance_quantity'     => 'nullable|integer|min:0',
        'used_in'              => 'nullable|string|max:255',
        'used_by'              => 'nullable|string|max:255',
    ]);
   
    Inventory::create($validated);
    return redirect()->route('admin.inventory.index');
}


    public function show(Request $request, Inventory $inventory)
    {
        abort_if(Gate::denies('inventory_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // $inventory->load('model');

        return view('admin.inventory.show', compact('inventory'));
    }
    
    
    public function edit(Inventory $inventory)
    {
        abort_if(Gate::denies('inventory_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
       $models = Models::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        return view('admin.inventory.edit', compact('inventory', 'models'));
    }

    
    public function update(Request $request, Inventory $inventory)
    {
        $inventory->update($request->all());
        
        return redirect()->route('admin.inventory.index')->with('success', 'Item updated successfully!');
    }
    
    public function destroy(Inventory $inventory)
    {
        abort_if(Gate::denies('inventory_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inventory->delete();

        return back();
    }
    public function massDestroy(Request $request)
    {
        Inventory::whereIn('id', $request->ids)->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }  
}
