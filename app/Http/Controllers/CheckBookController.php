<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CheckBook;
use DB;
use Auth;
use App\Models\Common;

class CheckBookController extends Controller {

    public $data = [];

    public function index() {
        return view('user.checkbook.checkbook');
    }

    public function getcheckbook(Request $request) {

        $columns = array('id', 'payee_name', 'cheque_number', 'cheque_date', 'amount', 'drop_date', 'clearing_date', 'return_date', 'receiver_name', 'created_at');
        $getfiled = array('id', 'payee_name', 'cheque_number', 'cheque_date', 'amount', 'drop_date', 'clearing_date', 'return_date', 'receiver_name','created_at');
        $condition = array();
        $join_str = array();
        echo CheckBook::CheckBookModel('cheque_books', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function AddCheckBook() {
        return view('user.checkbook.add', $this->data);
    }

    public function Savecheckbook(Request $request) {
        $rules = [
            'payee_name' => 'required|max:255',
            'cheque_number' => 'required|max:50',
            'amount' => 'required|numeric|min:0',
            'receiver_name' => 'required|string|max:255',
        ];

        $messages = [
            'payee_name.required' => 'Payee Name is required',
            'cheque_number.required' => 'Cheque Number is required',
//            'cheque_number.unique' => 'Cheque Number already exists',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a valid number',
            'amount.min' => 'Amount cannot be negative',
            'receiver_name.required' => 'Receiver Name is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

//        $existingCheque = CheckBook::where('cheque_number', $request->cheque_number)->first();
//        if ($existingCheque) {
//            return redirect()->back()->with('error', 'Cheque number already exists')->withInput();
//        }

        $checkbook = new CheckBook();
        $checkbook->payee_name = $request->payee_name;
        $checkbook->cheque_number = $request->cheque_number;
        $checkbook->cheque_date = $request->cheque_date;
        $checkbook->amount = $request->amount;
        $checkbook->drop_date = $request->drop_date;
        $checkbook->clearing_date = $request->clearing_date;
        $checkbook->return_date = $request->return_date;
        $checkbook->receiver_name = $request->receiver_name;
        $checkbook->save();
        return redirect()->route('checkbook')->with('success', 'CheckBook added successfully');
    }

    public function editCheckBook($id) {
        $checkbook_detail = CheckBook::find($id);
        if (!$checkbook_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['checkbook'] = $checkbook_detail;
        return view('user.checkbook.edit', $this->data);
    }

    public function UpdateCheckBook(Request $request) {
        $rules = [
            'payee_name' => 'required|string|max:255',
            'cheque_number' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'receiver_name' => 'required|string|max:255',
        ];

        $messages = [
            'payee_name.required' => 'Please enter payee name',
            'cheque_number.required' => 'Please enter cheque number',
            'amount.required' => 'Please enter amount',
            'amount.numeric' => 'Amount must be a valid number',
            'receiver_name.required' => 'Please enter receiver name',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

//        $checkbooks = CheckBook::where('cheque_number', $request->cheque_number)->where('id', '!=', base64_decode($request->checkbook_id))->get();
//        if (!$checkbooks->isEmpty()) {
//            return redirect()->back()->with('error', 'CheckBook already exists');
//        }

        $checkbook = CheckBook::find(base64_decode($request->checkbook_id));

        if (!$checkbook) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $checkbook->payee_name = $request->payee_name;
        $checkbook->cheque_number = $request->cheque_number;
        $checkbook->cheque_date = $request->cheque_date;
        $checkbook->amount = $request->amount;
        $checkbook->drop_date = $request->drop_date;
        $checkbook->clearing_date = $request->clearing_date;
        $checkbook->return_date = $request->return_date;
        $checkbook->receiver_name = $request->receiver_name;
        $checkbook->save();
        
        return redirect()->route('checkbook')->with('success', 'CheckBook updated successfully');
    }

    public function changeCheckBookStatus(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = CheckBook::find($id);
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $changeStatus;
            $html = view('user.checkbook.statusmodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function updateCheckBookStatus(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->checkbook_id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = CheckBook::find(base64_decode($request->checkbook_id));

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

    public function CheckBookDeleteModal(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $checkbooksDetail = CheckBook::find($id);

            if (!$checkbooksDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $checkbooksDetail;
            $html = view('user.checkbook.deletemodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function DeleteCheckBook(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }

            if (CheckBook::find(base64_decode($request->serviceId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'CheckBook deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }

}
