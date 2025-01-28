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

}

