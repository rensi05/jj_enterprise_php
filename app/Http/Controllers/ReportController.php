<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use DB;
use Auth;
use App\Models\Common;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomerImport;

class ReportController extends Controller {

    public $data = [];

    public function customerReport() {
        return view('user.report.customerreport');
    }

    public function getCustomerReport(Request $request) {

        $columns = array('id', 'customer_name');
        $getfiled = array('id', 'customer_name');
        $condition = array();
        $join_str = array();
        echo Customer::CustomerReportModel('customers', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }
    
    public function viewCustomerReport(Request $request, $id) {
        $this->data['customer_detail'] = Customer::where('id', $id)->first();
        
        return view('user.report.viewcustomerreport', $this->data);
    }
    
    public function getCustomerOrder(Request $request, $id) {
        $columns = array(
            'o.id', 
            'o.order_no', 
            'i.item_name', 
            'o.order_type', 
            'oi.category_1', 
            'oi.category_2', 
            'oi.category_3', 
            'oi.quantity', 
            'um.name', 
            'o.order_date', 
            'o.delivery_date', 
            'o.close_date', 
            'o.remarks', 
//            'o.address', 
            'o.bill_no', 
            'o.vehicle_no', 
            'o.status', 
            'o.created_at'
        );
        $getfiled = array(
            'o.id', 
            'o.order_no', 
            'i.item_name', 
//            'o.address', 
            'o.order_type', 
            'oi.category_1', 
            'oi.category_2', 
            'oi.category_3', 
            'oi.quantity', 
            'um.name', 
            'o.order_date', 
            'o.delivery_date', 
            'o.close_date', 
            'o.remarks', 
//            'o.address', 
            'o.bill_no', 
            'o.vehicle_no', 
            'o.status', 
            'o.created_at'
        );
        $condition = array();
        $join_str = array();
        $join_str[0] = array(
            'join_type' => 'left',
            'table' => 'customers as c',
            'join_table_id' => 'c.id',
            'from_table_id' => 'o.customer_id'
        );
        $join_str[1] = array(
            'join_type' => 'left',
            'table' => 'order_items as oi',
            'join_table_id' => 'oi.order_id',
            'from_table_id' => 'o.id'
        );
        $join_str[2] = array(
            'join_type' => 'left',
            'table' => 'items as i',
            'join_table_id' => 'i.id',
            'from_table_id' => 'oi.item_id'
        );
        $join_str[3] = array(
            'join_type' => 'left',
            'table' => 'unit_masters as um',
            'join_table_id' => 'um.id',
            'from_table_id' => 'o.unit_id'
        );
        $id = $id;
        echo Customer::getCustomerOrder('orders as o', $columns, $condition, $getfiled, $request, $join_str, $id);
        exit;
    }
}
