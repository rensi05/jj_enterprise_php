<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ItemCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'item_category'; 
    
    protected $fillable = [
        'item_id',
        'category_1',
        'category_2',
        'category_3',
    ];
}
