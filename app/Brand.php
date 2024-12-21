<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use SoftDeletes;

    public $table = 'brands';

    protected $fillable =[
        'name',
        'updated_at',
        'deleted_at',
    ];
}
