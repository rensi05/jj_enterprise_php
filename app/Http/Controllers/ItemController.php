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
use App\Models\ItemCategory;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemImport;

class ItemController extends Controller {

    public $data = [];

    public function index() {
        return view('user.item.item');
    }

    public function getitem(Request $request) {

        $columns = array(
            'i.id', 
            'i.item_name', 
            'c.customer_name', 
            'i.quantity', 
            'i.unit', 
            'i.quantity_1', 
            'i.unit_1', 
            'i.remarks', 
            'i.location', 
            'i.created_at', 
            'i.status'
        );
        $getfiled = array(
            'i.id', 
            'i.item_name', 
            'c.customer_name', 
            'i.quantity', 
            'i.unit', 
            'i.quantity_1', 
            'i.unit_1', 
            'i.remarks', 
            'i.location', 
            'i.created_at', 
            'i.status'
        );
        $condition = array();
        $join_str = array();
        $join_str[0] = array(
            'join_type' => 'left',
            'table' => 'customers as c',
            'join_table_id' => 'c.id',
            'from_table_id' => 'i.customer_id'
        );
        echo Item::ItemModel('items as i', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function AddItem() {
        $this->data['customers'] = Customer::where('status', 'active')->where('customer_type', 'purchase')->get();
        return view('user.item.add', $this->data);
    }

    public function Saveitem(Request $request) {
        $rules = array(
            'item_name' => 'required|min:2|max:200',
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

//        $items = Item::where('item_name', $request->item_name)->get();
//        if (!$items->isEmpty()) {
//            return redirect()->back()->with('error', 'Item already exists');
//        }

        $saveitems = new Item();
        $saveitems->item_name = $request->item_name;
        $saveitems->quantity = $request->quantity;
        $saveitems->unit = $request->unit;
        $saveitems->quantity_1 = $request->quantity_1;
        $saveitems->unit_1 = $request->unit_1;
        $saveitems->remarks = $request->remarks;
        $saveitems->location = $request->location;
        $saveitems->save();
        
        $category_1 = $request->category_1 ?? [];
        $category_2 = $request->category_2 ?? [];
        $category_3 = $request->category_3 ?? [];

        for ($i = 0; $i < count($category_1); $i++) {
            $saveCitems = new ItemCategory();
            $saveCitems->item_id = $saveitems->id;
            $saveCitems->category_1 = $category_1[$i] ?? null;
            $saveCitems->category_2 = $category_2[$i] ?? null;
            $saveCitems->category_3 = $category_3[$i] ?? null;
            $saveCitems->save();
        }
        return redirect()->route('item')->with('success', 'Item added successfully');
    }

    public function editItem($id) {
        $item_detail = Item::with('categories')->find($id);
        if (!$item_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['item_detail'] = $item_detail;
        $this->data['customers'] = Customer::where('status', 'active')->where('customer_type', 'purchase')->get();
        return view('user.item.edit', $this->data);
    }

    public function UpdateItem(Request $request) {
        $rules = array(
            'item_name' => 'required|min:2|max:200',
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

        $edit_item = Item::find(base64_decode($request->item_id));
        if (!$edit_item) {
            return redirect()->back()->with('error', 'Information not found');
        }

        $edit_item->item_name = $request->item_name;
        $edit_item->quantity = $request->quantity;
        $edit_item->unit = $request->unit;
        $edit_item->quantity_1 = $request->quantity_1;
        $edit_item->unit_1 = $request->unit_1;
        $edit_item->remarks = $request->remarks;
        $edit_item->location = $request->location;
        $edit_item->save();
        
        $category_1 = $request->category_1 ?? [];
        $category_2 = $request->category_2 ?? [];
        $category_3 = $request->category_3 ?? [];

        $edit_item->categories()->delete();
        for ($i = 0; $i < count($category_1); $i++) {
            $saveCitems = new ItemCategory();
            $saveCitems->item_id = $edit_item->id;
            $saveCitems->category_1 = $category_1[$i] ?? null;
            $saveCitems->category_2 = $category_2[$i] ?? null;
            $saveCitems->category_3 = $category_3[$i] ?? null;
            $saveCitems->save();
        }

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
    
    public function importItem(Request $request) {
        $rules = [
            'item_file' => 'required|mimes:csv,txt,xlsx|max:2048'
        ];

        $messages = [
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        Excel::import(new ItemImport, $request->file('item_file'));

        return redirect()->route('item')->with('success', 'Items imported successfully!');
    }

}
