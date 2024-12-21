<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable =[
        'serial_no',
        'product_name',
        'invoice_no',
        'invoice_date',
        'make',
        'model',
    ];

    
}
