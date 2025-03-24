<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use DB;
use Auth;
use App\Models\Common;
use App\Models\Customer;

class ItemController extends Controller {

    public $data = [];

    public function index() {
        return view('user.item.item');
    }

    public function getitem(Request $request) {

        $columns = array('id', 'item_name', 'created_at', 'status');
        $getfiled = array('id', 'item_name', 'created_at', 'status');
        $condition = array();
        $join_str = array();
        echo Item::ItemModel('items', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function AddItem() {
        $this->data['customers'] = Customer::where('status', 'active')->get();
        return view('user.item.add', $this->data);
    }

    public function Saveitem(Request $request) {
        $rules = array(
            'customer_id' => 'nullable|integer',
            'item_name' => 'required|min:2|max:200',
            'category_1' => 'nullable|string|max:200',
            'category_2' => 'nullable|string|max:200',
            'category_3' => 'nullable|string|max:200',
            'quantity' => 'nullable|integer',
            'unit' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
            'order_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'close_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'order_no' => 'nullable|string|max:100',
            'vehicle_no' => 'nullable|string|max:100',
            'bill_no' => 'nullable|string|max:100',
            'order_type' => 'nullable|string|max:100',
        );

        $messages = array(
            'item_name.required' => 'Please enter item name',
            'item_name.min' => 'Item name should be minimum :min characters',
            'item_name.max' => 'Item name should be between 2 to 200 characters',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $items = Item::where('item_name', $request->item_name)->get();
        if (!$items->isEmpty()) {
            return redirect()->back()->with('error', 'Item already exists');
        }

        $saveitems = new Item();
        $saveitems->customer_id = $request->customer_id;
        $saveitems->item_name = $request->item_name;
        $saveitems->category_1 = $request->category_1;
        $saveitems->category_2 = $request->category_2;
        $saveitems->category_3 = $request->category_3;
        $saveitems->quantity = $request->quantity;
        $saveitems->unit = $request->unit;
        $saveitems->remarks = $request->remarks;
        $saveitems->order_date = $request->order_date;
        $saveitems->delivery_date = $request->delivery_date;
        $saveitems->close_date = $request->close_date;
        $saveitems->location = $request->location;
        $saveitems->order_no = $request->order_no;
        $saveitems->vehicle_no = $request->vehicle_no;
        $saveitems->bill_no = $request->bill_no;
        $saveitems->order_type = $request->order_type;
        $saveitems->save();
        return redirect()->route('item')->with('success', 'Item added successfully');
    }

    public function editItem($id) {
        $item_detail = Item::find($id);
        if (!$item_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['item_detail'] = $item_detail;
        $this->data['customers'] = Customer::where('status', 'active')->get();
        return view('user.item.edit', $this->data);
    }

    public function UpdateItem(Request $request) {
        $rules = array(
            'customer_id' => 'nullable|integer',
            'item_name' => 'required|min:2|max:200',
            'category_1' => 'nullable|string|max:200',
            'category_2' => 'nullable|string|max:200',
            'category_3' => 'nullable|string|max:200',
            'quantity' => 'nullable|integer',
            'unit' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
            'order_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'close_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'order_no' => 'nullable|string|max:100',
            'vehicle_no' => 'nullable|string|max:100',
            'bill_no' => 'nullable|string|max:100',
            'order_type' => 'nullable|string|max:100',
        );

        $messages = array(
            'item_name.required' => 'Please enter item name',
            'item_name.min' => 'Item name should be minimum :min characters',
            'item_name.max' => 'Item name should be between 2 to 200 characters',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $items = Item::where('item_name', $request->item_name)->where('id', '!=', base64_decode($request->item_id))->get();
        if (!$items->isEmpty()) {
            return redirect()->back()->with('error', 'Item already exists');
        }

        $edit_item = Item::find(base64_decode($request->item_id));
        if (!$edit_item) {
            return redirect()->back()->with('error', 'Information not found');
        }

        $edit_item->customer_id = $request->customer_id;
        $edit_item->item_name = $request->item_name;
        $edit_item->category_1 = $request->category_1;
        $edit_item->category_2 = $request->category_2;
        $edit_item->category_3 = $request->category_3;
        $edit_item->quantity = $request->quantity;
        $edit_item->unit = $request->unit;
        $edit_item->remarks = $request->remarks;
        $edit_item->order_date = $request->order_date;
        $edit_item->delivery_date = $request->delivery_date;
        $edit_item->close_date = $request->close_date;
        $edit_item->location = $request->location;
        $edit_item->order_no = $request->order_no;
        $edit_item->vehicle_no = $request->vehicle_no;
        $edit_item->bill_no = $request->bill_no;
        $edit_item->order_type = $request->order_type;
        $edit_item->save();

        return redirect()->route('item')->with('success', 'Item updated successfully');
    }

    public function changeItemStatus(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Item::find($id);
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $changeStatus;
            $html = view('user.item.statusmodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function updateItemStatus(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->item_id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Item::find(base64_decode($request->item_id));

            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            if ($changeStatus->status == 'active') {
                $changeStatus->status = 'inactive';
            } else {
                $changeStatus->status = 'active';
            }
            if (!$changeStatus->save()) {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            return response()->json(['status' => 'success', 'message' => "Status change successfully"]);
        }
        exit;
    }

    public function ItemDeleteModal(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $itemsDetail = Item::find($id);

            if (!$itemsDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $itemsDetail;
            $html = view('user.item.deletemodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function DeleteItem(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }

            if (Item::find(base64_decode($request->serviceId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Item deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }

}
