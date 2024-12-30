<?php
namespace App\Http\Controllers\Admin;

use App\Inventory; 
use App\Brand;
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
            $query = Inventory::select("*");
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
    
            $table->editColumn('invoice_date', function ($row) {
                return $row->invoice_date ? $row->invoice_date : "";
            });
    
            $table->addColumn('view_link', function ($row) {
                return route('admin.inventory.show', $row->id);
            });

            $table->rawColumns(['actions','placeholder','model']);

            return $table->make(true);
        }

        $inventories = Inventory::all();
    return view('admin.inventory.index', compact('inventories'));
    }
    
    public function create()
    {
        $brands = Brand::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.inventory.create', compact('brands'));
    }
    
    public function store(StoreInventoryRequest $request)
    {
        // Generate a unique ID for the 'inventories' table, length 6, with a prefix based on the current year
        $id = IdGenerator::generate(['table' => 'inventories', 'length' => 6, 'prefix' => date('y')]);
    
        // Create a new Inventory object and populate it
        $inventory = new Inventory();
        $inventory->id = $id;
        $inventory->product_name = $request->get('product_name'); // Set other fields as necessary
        $inventory->serial_no = $request->get('serial_no');
        $inventory->invoice_no = $request->get('invoice_no');
        $inventory->brand_id = $request->get('brand_id'); // Assuming this field is being passed
        $inventory->model = $request->get('model');
        $inventory->invoice_date = $request->get('invoice_date');
    
        // Save the inventory item
        $inventory->save();
    
        return redirect()->route('admin.inventory.index');
    }
    

    // public function store(Request $request){

       
    // }

    public function show(Inventory $inventory)
    {
        abort_if(Gate::denies('inventory_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.inventory.show', compact('inventory'));
    }
    
    
    public function edit(Inventory $inventory)
    {
        abort_if(Gate::denies('inventory_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.inventory.edit', compact('inventory'));
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
