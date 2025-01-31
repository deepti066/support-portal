<?php

namespace App;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    // use SoftDeletes;

    public $table = 'inventory_stocks';

    protected $dates = [
        'create_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'invoice_no',
        'inventory_id',
        'stock_type',
        'stock_quantity',
        'stock_date',
        'used_in',
        'used_by',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
        
    }

    
}
