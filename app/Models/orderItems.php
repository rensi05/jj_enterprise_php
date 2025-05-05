<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class orderItems extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'order_items';
    
    protected $fillable = [
        'order_id',
        'item_id',
        'unit_id',
        'quantity',
        'category_1',
        'category_2',
        'category_3',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

}
