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
use App\Models\ItemCategory;
use App\Models\Unit;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OrderImport;
use Illuminate\Support\Str;
use App\Models\orderItems;

class OrderController extends Controller {

    public $data = [];

    public function index() {
        return view('user.order.order');
    }

    public function getOrder(Request $request) {
        $columns = array(
            'o.id', 
            'o.order_no', 
            'c.customer_name', 
            'i.item_name', 
            'o.address', 
            'o.order_type', 
            'o.category_1', 
            'o.category_2', 
            'o.category_3', 
            'o.quantity', 
            'um.name', 
            'o.order_date', 
            'o.delivery_date', 
            'o.close_date', 
            'o.remarks', 
            'o.location', 
            'o.bill_no', 
            'o.vehicle_no', 
            'o.status', 
            'o.created_at'
        );
        $getfiled = array(
            'o.id', 
            'o.order_no', 
            'c.customer_name', 
            'i.item_name', 
            'o.address', 
            'o.order_type', 
            'o.category_1', 
            'o.category_2', 
            'o.category_3', 
            'o.quantity', 
            'um.name', 
            'o.order_date', 
            'o.delivery_date', 
            'o.close_date', 
            'o.remarks', 
            'o.location', 
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
            'table' => 'items as i',
            'join_table_id' => 'i.id',
            'from_table_id' => 'o.item_id'
        );
        $join_str[3] = array(
            'join_type' => 'left',
            'table' => 'unit_masters as um',
            'join_table_id' => 'um.id',
            'from_table_id' => 'o.unit_id'
        );
        echo Order::OrderModel('orders as o', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function pastOrder() {
        return view('user.order.pastorder');
    }

    public function getPastOrder(Request $request) {
        $columns = array(
            'o.id', 
            'o.order_no', 
            'c.customer_name', 
//            'i.item_name', 
            'o.address', 
            'o.order_type', 
//            'o.category_1', 
//            'o.category_2', 
//            'o.category_3', 
//            'o.quantity', 
//            'um.name', 
            'o.order_date', 
            'o.delivery_date', 
            'o.close_date', 
            'o.remarks', 
            'o.location', 
            'o.bill_no', 
            'o.vehicle_no', 
            'o.status', 
            'o.created_at'
        );
        $getfiled = array(
            'o.id', 
            'o.order_no', 
            'c.customer_name', 
//            'i.item_name', 
            'o.address', 
            'o.order_type', 
//            'o.category_1', 
//            'o.category_2', 
//            'o.category_3', 
//            'o.quantity', 
//            'um.name', 
            'o.order_date', 
            'o.delivery_date', 
            'o.close_date', 
            'o.remarks', 
            'o.location', 
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
            'table' => 'items as i',
            'join_table_id' => 'i.id',
            'from_table_id' => 'o.item_id'
        );
        $join_str[3] = array(
            'join_type' => 'left',
            'table' => 'unit_masters as um',
            'join_table_id' => 'um.id',
            'from_table_id' => 'o.unit_id'
        );
        echo Order::PastOrderModel('orders as o', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function AddOrder() {
        $this->data['customers'] = Customer::where('status', 'active')->get();
        $this->data['items'] = Item::where('status', 'active')->get();
        $this->data['units'] = Unit::where('status', 'active')->get();
        return view('user.order.add', $this->data);
    }

    public function Saveorder(Request $request) {
        $rules = array(
            'customer_id' => 'required',
//            'item_id' => 'required',
            'order_date' => 'required',
            'item_id.*' => 'required|exists:items,id',
        );

        $messages = array(
            'customer_id.required' => 'Please select customer',
//            'item_id.required' => 'Please select item',
            'item_id.required' => 'Please select at least one item',
            'order_date.required' => 'Please select order date',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        $lastOrder = Order::withTrashed()->orderBy('id', 'desc')->first();

        if ($lastOrder && $lastOrder->order_no) {
            $lastNumber = (int) str_replace('JJ-', '', $lastOrder->order_no);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $order_no = 'JJ-' . str_pad($newNumber, 9, '0', STR_PAD_LEFT);

        $order = new Order();
        $order->order_no = $order_no;
        $order->customer_id = $request->customer_id;
//        $order->item_id = $request->item_id;
        $order->address = $request->address;
        $order->order_type = $request->order_type;
//        $order->category_1 = $request->category_1;
//        $order->category_2 = $request->category_2;
//        $order->category_3 = $request->category_3;
//        $order->quantity = $request->quantity;
//        $order->unit_id = $request->unit_id;
        $order->order_date = $request->order_date;
        $order->delivery_date = $request->delivery_date;
        $order->close_date = $request->close_date;
        $order->location = $request->location;
        $order->remarks = $request->remarks;
        $order->bill_no = $request->bill_no;
        $order->vehicle_no = $request->vehicle_no;        
        if(!empty($order->bill_no) && !empty($order->delivery_date) && !empty($order->close_date)) {
            $order->status = 'completed';
        }        
        $order->save();
        
        foreach ($request->item_id as $index => $itemId) {
            orderItems::create([
                'order_id' => $order->id,
                'item_id' => $itemId,
                'quantity' => $request->quantity[$index],
                'unit_id' => $request->unit_id[$index],
                'category_1' => $request->category_1[$index] ?? null,
                'category_2' => $request->category_2[$index] ?? null,
                'category_3' => $request->category_3[$index] ?? null,
            ]);
        }
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
        $this->data['units'] = Unit::where('status', 'active')->get();
        return view('user.order.edit', $this->data);
    }

    public function UpdateOrder(Request $request) {
        $rules = array(
            'customer_id' => 'required',
            'item_id' => 'required',
            'order_date' => 'required',
        );

        $messages = array(
            'customer_id.required' => 'Please select customer',
            'item_id.required' => 'Please select item',
            'order_date.required' => 'Please select order date',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        
        $edit_order = Order::find(base64_decode($request->order_id));

        if (!$edit_order) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $edit_order->customer_id = $request->customer_id;
//        $edit_order->item_id = $request->item_id;
        $edit_order->address = $request->address;
        $edit_order->order_type = $request->order_type;
//        $edit_order->category_1 = $request->category_1;
//        $edit_order->category_2 = $request->category_2;
//        $edit_order->category_3 = $request->category_3;
//        $edit_order->quantity = $request->quantity;
//        $edit_order->unit_id = $request->unit_id;
        $edit_order->order_date = $request->order_date;
        $edit_order->delivery_date = $request->delivery_date;
        $edit_order->close_date = $request->close_date;
        $edit_order->location = $request->location;
        $edit_order->remarks = $request->remarks;
        $edit_order->bill_no = $request->bill_no;
        $edit_order->vehicle_no = $request->vehicle_no;        
        if(!empty($edit_order->bill_no) && !empty($edit_order->delivery_date) && !empty($edit_order->close_date)) {
            $edit_order->status = 'completed';
        }
        $edit_order->save();
        
        OrderItems::where('order_id', $edit_order->id)->delete();

        foreach ($request->item_id as $key => $item_id) {
            if ($item_id != '') {
                OrderItems::create([
                    'order_id' => $edit_order->id,
                    'item_id' => $item_id,
                    'quantity' => $request->quantity[$key],
                    'unit_id' => $request->unit_id[$key],
                    'category_1' => $request->category_1[$key] ?? null,
                    'category_2' => $request->category_2[$key] ?? null,
                    'category_3' => $request->category_3[$key] ?? null,
                ]);
            }
        }
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
    
    public function getItemsByCustomer(Request $request) {
        $items = Item::where('customer_id', $request->customer_id)->get();

        return response()->json($items);
    }
    
    public function importOrder(Request $request) {
        $rules = [
            'order_file' => 'required|mimes:csv,txt,xlsx|max:2048'
        ];

        $messages = [
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        Excel::import(new OrderImport, $request->file('order_file'));

        return redirect()->route('order')->with('success', 'Orders imported successfully!');
    }

    public function getItemCategories(Request $request) {
        $itemId = $request->input('item_id');

        $category1 = ItemCategory::where('item_id', $itemId)->pluck('category_1')->filter()->unique()->values();
        $category2 = ItemCategory::where('item_id', $itemId)->pluck('category_2')->filter()->unique()->values();
        $category3 = ItemCategory::where('item_id', $itemId)->pluck('category_3')->filter()->unique()->values();

        return response()->json([
                    'category1' => $category1,
                    'category2' => $category2,
                    'category3' => $category3,
        ]);
    }

    public function getItemCategory1(Request $request) {
        $itemId = $request->input('item_id');

        $category1 = ItemCategory::where('item_id', $itemId)
                ->orderBy('id', 'DESC')
                ->pluck('category_1')
                ->filter()
                ->unique()
                ->values();

        return response()->json(['category1' => $category1]);
    }

    public function getItemCategory2And3(Request $request) {
        $itemId = $request->input('item_id');
        $category1Name = $request->input('category_1');

        $category2 = ItemCategory::where('item_id', $itemId)
                ->where('category_1', $category1Name)
                ->orderBy('id', 'DESC')
                ->pluck('category_2')
                ->filter()
                ->unique()
                ->values();

        $category3 = ItemCategory::where('item_id', $itemId)
                ->where('category_1', $category1Name)
                ->orderBy('id', 'DESC')
                ->pluck('category_3')
                ->filter()
                ->unique()
                ->values();

        return response()->json(['category2' => $category2, 'category3' => $category3]);
    }
    
    public function saveOrderCustomer(Request $request) {
        $rules = [
            'customer_name' => 'required|min:2|max:200',
        ];

        $messages = [
            'customer_name.required' => 'Please enter customer name',
            'customer_name.min' => 'Customer name should be at least :min characters',
            'customer_name.max' => 'Customer name should not exceed :max characters',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $existingCustomer = Customer::where('customer_name', $request->customer_name)->first();
        if ($existingCustomer) {
            return response()->json(['status' => 'error', 'message' => 'Customer already exists'], 409);
        }

        $customer = new Customer();
        $customer->customer_type = $request->customer_type;
        $customer->customer_name = $request->customer_name;
        $customer->location = $request->location;
        $customer->country = $request->country;
        $customer->state = $request->state;
        $customer->type = $request->type;
        $customer->gst_no = $request->gst_no;
        $customer->save();
        return response()->json(['status' => 'success', 'message' => 'Customer added successfully',
            'data' => [
                'id' => $customer->id,
                'customer_name' => $customer->customer_name,
                'location' => $customer->location
            ]
        ]);
    }

}
