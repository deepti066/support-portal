<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMappedInventory extends Model
{
    use HasFactory;
    public $table = 'ticket_mapped_inventories';
    protected $fillable = ['ticket_id', 'inventory_id', 'status'];
}
