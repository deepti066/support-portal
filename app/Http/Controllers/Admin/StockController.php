<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models;
use App\Inventory; 
use App\Brand;
use App\Stock;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
class StockController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Stock::with('inventory')->select("*");

            if ($request->has('model') && $request->model != '') {
                $query->whereHas('inventory', function ($q) use ($request) {
                    $q->where('model', $request->model);
                });
            }


            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'stock_show';
                $editGate      = 'stock_edit';
                $deleteGate    = 'stock_delete';
                $crudRoutePart = 'stock';

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
                return $row->inventory->product_name ? $row->inventory->product_name : "";
            });
          
            $table->editColumn('serial_no', function ($row) {
                return $row->inventory->serial_no ? $row->inventory->serial_no : "";
            });

            $table->editColumn('invoice_no', function ($row) {
                return $row->invoice_no ? $row->invoice_no : "";
            });

            $table->editColumn('invoice_date', function ($row) {
                return $row->inventory->invoice_date ? $row->inventory->invoice_date : "";
            });
            $table->editColumn('model', function ($row) {
                return $row->inventory->models ? $row->inventory->models->name : "";
            });
    
            $table->editColumn('asset_description', function ($row) {
                return $row->inventory->asset_description ? $row->inventory->asset_description : "";
            });

            $table->editColumn('stock_out_quantity', function ($row) {
                return $row->stock_quantity ? $row->stock_quantity : "";
            });

            $table->editColumn('stock_out_date', function ($row) {
                return $row->stock_date ? $row->stock_date : "";
            });

            $table->editColumn('balance_quantity', function ($row) {
                return $row->stock_type ? $row->stock_type==1?"In" : "out" :"";
            });

            $table->editColumn('used_in', function ($row) {
                return $row->used_in ? $row->used_in : "";
            });

            $table->editColumn('used_by', function ($row) {
                return $row->used_by ? $row->used_by : "";
            });
    
            $table->addColumn('view_link', function ($row) {
                return route('admin.stock.show', $row->id);
            });

            $table->rawColumns(['actions','placeholder','model']);

            return $table->make(true);
        }
        $models = Models::all();
        $stocks = stock::all();
    return view('admin.stock.index', compact('stocks', 'models'));
    }
    
    public function create()
    {
        $models = Models::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        

        $brands = Brand::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        return view('admin.stock.create', compact('brands', 'models'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'serial_no'            => 'nullable|string|max:255|unique:inventories,serial_no',
        'product_name'         => 'required|string|max:255',
        'invoice_no'           => 'nullable|string|max:255',
        'invoice_date'         => 'nullable|date',
        'model'                => 'nullable|string|max:255',
        'asset_description'    => 'nullable|string|max:500',
        'stock_out_quantity'   => 'nullable|integer|min:0',
        'stock_out_date'       => 'nullable|date',
        'balance_quantity'     => 'nullable|integer|min:0',
        'used_in'              => 'nullable|string|max:255',
        'used_by'              => 'nullable|string|max:255',
    ]);
   
    Stock::create($validated);
    return redirect()->route('admin.stock.index');
}

public function stockIn(Request $request)
{
    $validated = $request->validate([
        'inventory_id'         => 'nullable|integer',
        'stock_type'           => 'nullable|integer',
        'invoice_no'           => 'nullable|string|max:255',
        // 'invoice_date'         => 'nullable|string|max:255',
        'stock_quantity'       => 'nullable|integer|min:0',
        'stock_date'           => 'nullable|date',
    ]);
   
    Stock::create($validated);
    return redirect()->route('admin.stock.index');
}    

public function stockOut(Request $request)
{
    $validated = $request->validate([
        'inventory_id'         => 'nullable|integer',
        'stock_type'           => 'nullable|integer',
        'invoice_no'           => 'nullable|string|max:255',
        'stock_quantity'       => 'nullable|integer|min:0',
        'stock_date'           => 'nullable|date',
        'used_in'              => 'nullable|string|max:255',
        'used_by'              => 'nullable|string|max:255',
    ]);
    // $stockIn = stock::where(['inventory_id'=>$request->inventory_id,'stock_type'=>1])->sum('stock_quantity');
    // $stockOut = stock::where(['inventory_id'=>$request->inventory_id,'stock_type'=>2])->sum('stock_quantity');
    $availableStock = calculateStock($request->inventory_id);

    if ($availableStock < $request->stock_quantity) {
        return redirect()->back()->withErrors(['error' => 'Stock Out quantity exceeds available stock.']);
    }
    Stock::create($validated);
    return redirect()->back()->with(['success' => 'Stock Out quantity exceeds available stock.']);
    }


    public function show(Request $request, Stock $stock)
    {
        abort_if(Gate::denies('stock_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.stock.show', compact('stock'));
    }
    
    
    public function edit(Stock $stock)
    {
        abort_if(Gate::denies('stock_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
       $models = Models::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        return view('admin.stock.edit', compact('stock', 'models'));
    }

    
    public function update(Request $request, Stock $stock)
    {
        $stock->update($request->all());
        
        return redirect()->route('admin.stock.index')->with('success', 'Item updated successfully!');
    }
    
    public function destroy(Stock $stock)
    {
        abort_if(Gate::denies('stock_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stock->delete();

        return back();
    }
    public function massDestroy(Request $request)
    {
        Stock::whereIn('id', $request->ids)->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }  
}
