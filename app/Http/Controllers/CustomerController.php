<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use DB;
use Auth;
use App\Models\Common;

class CustomerController extends Controller {

    public $data = [];

    public function index() {
        return view('user.customer.customer');
    }

    public function getcustomer(Request $request) {

        $columns = array('id', 'customer_name', 'created_at', 'status');
        $getfiled = array('id', 'customer_name', 'created_at', 'status');
        $condition = array();
        $join_str = array();
        echo Customer::CustomerModel('customers', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function AddCustomer() {
        return view('user.customer.add', $this->data);
    }

    public function Savecustomer(Request $request) {
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $existingCustomer = Customer::where('customer_name', $request->customer_name)->first();
        if ($existingCustomer) {
            return redirect()->back()->with('error', 'Customer already exists')->withInput();
        }

        $customer = new Customer();
        $customer->customer_name = $request->customer_name;
        $customer->location = $request->location;
        $customer->country = $request->country;
        $customer->state = $request->state;
        $customer->type = $request->type;
        $customer->gst_no = $request->gst_no;
        $customer->save();
        return redirect()->route('customer')->with('success', 'Customer added successfully');
    }

    public function editCustomer($id) {
        $customer_detail = Customer::find($id);
        if (!$customer_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['customer_detail'] = $customer_detail;
        return view('user.customer.edit', $this->data);
    }

    public function UpdateCustomer(Request $request) {
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
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $customers = Customer::where('customer_name', $request->customer_name)->where('id', '!=', base64_decode($request->customer_id))->get();
        if (!$customers->isEmpty()) {
            return redirect()->back()->with('error', 'Customer already exists');
        }
        
        $customer = Customer::find(base64_decode($request->customer_id));
        $customer->customer_name = $request->customer_name;
        $customer->location = $request->location;
        $customer->country = $request->country;
        $customer->state = $request->state;
        $customer->type = $request->type;
        $customer->gst_no = $request->gst_no;
        $customer->save();
        
        return redirect()->route('customer')->with('success', 'Customer updated successfully');
    }

    public function changeCustomerStatus(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Customer::find($id);
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $changeStatus;
            $html = view('user.customer.statusmodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function updateCustomerStatus(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->customer_id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Customer::find(base64_decode($request->customer_id));

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

    public function CustomerDeleteModal(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $customersDetail = Customer::find($id);

            if (!$customersDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $customersDetail;
            $html = view('user.customer.deletemodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function DeleteCustomer(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }

            if (Customer::find(base64_decode($request->serviceId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Customer deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }

}
