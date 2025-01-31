<?php

use App\Stock;

if (!function_exists('calculateStock')) {
    function calculateStock($inventory_id)
    {
        $stockIn = \App\Stock::where(['inventory_id' => $inventory_id, 'stock_type' => 1])->sum('stock_quantity');
        $stockOut = \App\Stock::where(['inventory_id' => $inventory_id, 'stock_type' => 2])->sum('stock_quantity');
        return $stockIn - $stockOut;
    }
}

if (!function_exists('stock_in')) {
    function stock_in($inventory_id)
    {
        $stockIn = \App\Stock::where(['inventory_id' => $inventory_id, 'stock_type' => 1])->sum('stock_quantity');
      
        return $stockIn ;
    }
}

if (!function_exists('stock_out')) {
    function stock_out($inventory_id)
    {
        $stockOut = \App\Stock::where(['inventory_id' => $inventory_id, 'stock_type' => 2])->sum('stock_quantity');
        return $stockOut ;
    }
}
