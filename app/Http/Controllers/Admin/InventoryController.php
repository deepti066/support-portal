<?php
namespace App\Http\Controllers\Admin;

use App\Inventory; 
use App\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class InventoryController extends Controller
{
    public function index()
    {
        return view('admin.inventory.index');
    }
    
    public function create()
    {
        $brands = Brand::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.inventory.create', compact('brands'));
    }
    
    public function store(StoreInventoryRequest $request)
    {
        $inventory = Inventory::create($request->all());

        return redirect()->route('admin.inventory.index');
    }
    
    //     // Store the data in the database
    //     Inventory::create($validated);
    
    //     // Redirect or return a response
    //     return redirect()->route('inventory.index')->with('success', 'Inventory item created successfully!');
    // }
    
    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }
    
    public function update(Request $request, Inventory $inventory)
    {
        $inventory->update($request->all());
        return redirect()->route('inventory.index')->with('success', 'Item updated successfully!');
    }
    
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully!');
    }

    public function massDestroy(Request $request)
    {
        Inventory::whereIn('id', $request->ids)->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    // Method to handle DataTables AJAX request
    public function getInventoryData(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'serial_no',
            2 => 'product_name',
            3 => 'invoice_no',
            4 => 'make',
            5 => 'model',
        ];

        // Retrieve the data for the DataTable with pagination, searching, and sorting.
        $query = Inventory::query();
        

        // Search filter (if any search value is present in the request)
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'LIKE', "%{$search}%")
                  ->orwhere('serial_no', 'LIKE', "%{$search}%")
                  ->orWhere('invoice_no', 'LIKE', "%{$search}%")
                  ->orWhere('make', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }

        // Sorting (DataTables request for ordering)
        $orderColumn = $columns[$request->order[0]['column']];
        $orderDirection = $request->order[0]['dir'];
        $query->orderBy($orderColumn, $orderDirection);

        // Pagination (DataTables request for page size)
        $length = $request->length;
        $start = $request->start;
        $data = $query->offset($start)->limit($length)->get();

        // Count total records for pagination
        $totalRecords = Inventory::count();
        // dd($data);
        // Return the data as JSON
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $query->count(),
            'data' => $data,
        ]);
    }
}
