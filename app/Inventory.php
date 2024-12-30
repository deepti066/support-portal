<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = IdGenerator::generate(['table' => $model->table, 'length' => 6, 'prefix' =>'INV-']);
        });
    }

    
}

