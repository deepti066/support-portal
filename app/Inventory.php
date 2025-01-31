<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;


class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $keyType = 'string';
    public $incrementing = false;
    protected $with = ['models'];

    protected $fillable =[
        'id',
        'inv_id',
        'serial_no',
        'product_name',
        'invoice_no',
        'invoice_date',
        'make',
        'model',
        'asset_description',
        'stock_in_quantity',
        'stock_in_date',
        'stock_out_quantity',
        'stock_out_date',
        'balance_quantity',
        'used_in',
        'used_by',
    ];

    public static function booted()
    {
        static::creating(function ($inventory) {
            $inventory->inv_id = self::generateUniqueId();
        });
    }

    public static function generateUniqueId()
    {
        $prefix = "INV";
        $randomString = Str::random(2);

        return "{$prefix}-{$randomString}";
    }
    public function models()
    {
        return $this->hasOne(Models::class, 'id', 'model');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'inventory_id', 'id');
    }


    public function stock_in()
{
    return $this->hasMany(Stock::class, 'inventory_id', 'id')->where('stock_type', 1);
}

public function stock_out()
{
    return $this->hasMany(Stock::class, 'inventory_id', 'id')->where('stock_type', 2);
}

// Method to get total stock in
public function totalStockIn()
{
    return $this->stock_in()->sum('stock_quantity');
}

// Method to get total stock out
public function totalStockOut()
{
    return $this->stock_out()->sum('stock_quantity');
}

// Method to get available stock
public function availableStock()
{
    return $this->totalStockIn() - $this->totalStockOut();
}
}

