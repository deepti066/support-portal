<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
    public function toArray($reques)
    {
        return parent::toArray($request);
    }
}