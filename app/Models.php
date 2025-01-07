<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Models extends Model
{
    use SoftDeletes;

    public $table = 'models';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'color',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'model_id', 'id');
    }
}
