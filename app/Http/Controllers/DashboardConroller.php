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
                
        $excludedItems = ['AIR BUBBLE ROLL 1 MTR', 'AIR BUBBLE ROLL 1.5 MTR', 'AIR BUBBLE ROLL 2 MTR', 'BOPP TAP', 'STRETCH FILM ROLL', 'EPE FOAM ROLL'];

        $this->data['otherItems'] = Item::whereNotIn('item_name', $excludedItems)
            ->pluck('item_name');
        return view('user.dashboard.dashboard', $this->data);
    }
    
    public function getFirstItem(Request $request, $item_name) {
        $columns = [
            'oi.category_1',
            'oi.category_2',
            'oi.category_3',
            DB::raw("SUM(CASE WHEN o.status = 'pending' THEN oi.quantity ELSE 0 END) as pending_order"),
            DB::raw("SUM(CASE WHEN o.status = 'completed' THEN oi.quantity ELSE 0 END) as completed_order"),
            DB::raw("SUM(oi.quantity) as total_order")
        ];

        $getfiled = [
            'oi.category_1',
            'oi.category_2',
            'oi.category_3',
            DB::raw("SUM(CASE WHEN o.status = 'pending' THEN oi.quantity ELSE 0 END) as pending_order"),
            DB::raw("SUM(CASE WHEN o.status = 'completed' THEN oi.quantity ELSE 0 END) as completed_order"),
            DB::raw("SUM(oi.quantity) as total_order")
        ];

        $condition = [];
        $join_str = [
            [
                'join_type' => 'inner',
                'table' => 'order_items as oi',
                'join_table_id' => 'oi.item_id',
                'from_table_id' => 'i.id'
            ],
            [
                'join_type' => 'inner',
                'table' => 'orders as o',
                'join_table_id' => 'o.id',
                'from_table_id' => 'oi.order_id'
            ]
        ];

        $request['item_name'] = urldecode($item_name);
        echo Item::FirstItemModel('items as i', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }
    
    public function getOtherItem(Request $request) {
        $columns = [
            'i.item_name',
            'oi.category_1',
            'oi.category_2',
            'oi.category_3',
            DB::raw("SUM(CASE WHEN o.status = 'pending' THEN oi.quantity ELSE 0 END) as pending_order"),
            DB::raw("SUM(CASE WHEN o.status = 'completed' THEN oi.quantity ELSE 0 END) as completed_order"),
            DB::raw("SUM(oi.quantity) as total_order")
        ];

        $getfiled = [
            'i.item_name',
            'oi.category_1',
            'oi.category_2',
            'oi.category_3',
            DB::raw("SUM(CASE WHEN o.status = 'pending' THEN oi.quantity ELSE 0 END) as pending_order"),
            DB::raw("SUM(CASE WHEN o.status = 'completed' THEN oi.quantity ELSE 0 END) as completed_order"),
            DB::raw("SUM(oi.quantity) as total_order")
        ];

        $condition = [];
        $join_str = [
            [
                'join_type' => 'inner',
                'table' => 'order_items as oi',
                'join_table_id' => 'oi.item_id',
                'from_table_id' => 'i.id'
            ],
            [
                'join_type' => 'inner',
                'table' => 'orders as o',
                'join_table_id' => 'o.id',
                'from_table_id' => 'oi.order_id'
            ]
        ];

        if ($request->has('item_name')) {
            $request['item_name'] = $request->input('item_name');
        }
        echo Item::OtherItemModel('items as i', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

}
