<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use DB;
use Auth;
use App\Models\Common;
use App\Models\Customer;
use App\Models\Item;

class OrderController extends Controller {

    public $data = [];

    public function index() {
        return view('user.order.order');
    }

    public function getorder(Request $request) {

        $columns = array('id', 'order_no', 'created_at');
        $getfiled = array('id', 'order_no', 'created_at');
        $condition = array();
        $join_str = array();
        echo Order::OrderModel('orders', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function AddOrder() {
        $this->data['customers'] = Customer::where('status', 'active')->get();
        $this->data['items'] = Item::where('status', 'active')->get();
        return view('user.order.add', $this->data);
    }

    public function Saveorder(Request $request) {
        $timestamp = strtotime(date('Y-m-d H:i:s'));
        $six_digit_random_number = substr($timestamp, strlen($timestamp) - 6, strlen($timestamp));
        $order_no = 'ORD-' . $six_digit_random_number;

        $order = new Order();
        $order->order_no = $order_no;
        $order->customer_id = $request->customer_id;
        $order->item_id = $request->item_id;
        $order->address = $request->address;
        $order->order_type = $request->order_type;
        $order->category_1 = $request->category_1;
        $order->category_2 = $request->category_2;
        $order->category_3 = $request->category_3;
        $order->quantity = $request->quantity;
        $order->unit = $request->unit;
        $order->order_date = $request->order_date;
        $order->delivery_date = $request->delivery_date;
        $order->close_date = $request->close_date;
        $order->location = $request->location;
        $order->remarks = $request->remarks;
        $order->bill_no = $request->bill_no;
        $order->vehicle_no = $request->vehicle_no;
        $order->save();
        return redirect()->route('order')->with('success', 'Order added successfully');
    }

    public function editOrder($id) {
        $order_detail = Order::find($id);
        if (!$order_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['order_detail'] = $order_detail;
        $this->data['customers'] = Customer::where('status', 'active')->get();
        $this->data['items'] = Item::where('status', 'active')->get();
        return view('user.order.edit', $this->data);
    }

    public function UpdateOrder(Request $request) {
        $edit_order = Order::find(base64_decode($request->order_id));

        if (!$edit_order) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $edit_order->customer_id = $request->customer_id;
        $edit_order->item_id = $request->item_id;
        $edit_order->address = $request->address;
        $edit_order->order_type = $request->order_type;
        $edit_order->category_1 = $request->category_1;
        $edit_order->category_2 = $request->category_2;
        $edit_order->category_3 = $request->category_3;
        $edit_order->quantity = $request->quantity;
        $edit_order->unit = $request->unit;
        $edit_order->order_date = $request->order_date;
        $edit_order->delivery_date = $request->delivery_date;
        $edit_order->close_date = $request->close_date;
        $edit_order->location = $request->location;
        $edit_order->remarks = $request->remarks;
        $edit_order->bill_no = $request->bill_no;
        $edit_order->vehicle_no = $request->vehicle_no;
        $edit_order->save();
        
        return redirect()->route('order')->with('success', 'Order updated successfully');
    }

    public function OrderDeleteModal(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $ordersDetail = Order::find($id);

            if (!$ordersDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $ordersDetail;
            $html = view('user.order.deletemodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function DeleteOrder(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }

            if (Order::find(base64_decode($request->serviceId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Order deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }

}
