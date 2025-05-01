<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use DB;

class DashboardConroller extends Controller
{
    public $data = [];
    
    public function index(Request $request) {
                
        return view('user.dashboard.dashboard', $this->data);
    }
    
    public function getFirstItem(Request $request, $item_name) {
        $columns = [
            'o.category_1',
            'o.category_2',
            DB::raw("SUM(CASE WHEN o.status = 'pending' THEN o.quantity ELSE 0 END) as pending_order"),
            DB::raw("SUM(CASE WHEN o.status = 'completed' THEN o.quantity ELSE 0 END) as completed_order"),
            DB::raw("SUM(o.quantity) as total_order")
        ];

        $getfiled = [
            'o.category_1',
            'o.category_2',
            DB::raw("SUM(CASE WHEN o.status = 'pending' THEN o.quantity ELSE 0 END) as pending_order"),
            DB::raw("SUM(CASE WHEN o.status = 'completed' THEN o.quantity ELSE 0 END) as completed_order"),
            DB::raw("SUM(o.quantity) as total_order")
        ];

        $condition = [];
        $join_str = [[
            'join_type' => 'inner',
            'table' => 'orders as o',
            'join_table_id' => 'o.item_id',
            'from_table_id' => 'i.id'
        ]];

        $request['item_name'] = urldecode($item_name);
        echo Item::FirstItemModel('items as i', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }
    
    public function getOtherItem(Request $request) {
        $columns = [
            'i.item_name',
            'o.category_1',
            'o.category_2',
            DB::raw("SUM(CASE WHEN o.status = 'pending' THEN o.quantity ELSE 0 END) as pending_order"),
            DB::raw("SUM(CASE WHEN o.status = 'completed' THEN o.quantity ELSE 0 END) as completed_order"),
            DB::raw("SUM(o.quantity) as total_order")
        ];

        $getfiled = [
            'i.item_name',
            'o.category_1',
            'o.category_2',
            DB::raw("SUM(CASE WHEN o.status = 'pending' THEN o.quantity ELSE 0 END) as pending_order"),
            DB::raw("SUM(CASE WHEN o.status = 'completed' THEN o.quantity ELSE 0 END) as completed_order"),
            DB::raw("SUM(o.quantity) as total_order")
        ];

        $condition = [];
        $join_str = [[
            'join_type' => 'inner',
            'table' => 'orders as o',
            'join_table_id' => 'o.item_id',
            'from_table_id' => 'i.id'
        ]];

        echo Item::OtherItemModel('items as i', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

}
