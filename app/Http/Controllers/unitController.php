<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Unit;
use DB;
use Auth;
use App\Models\Common;

class UnitController extends Controller {

    public $data = [];

    public function index() {
        return view('user.unit.unit');
    }

    public function getunit(Request $request) {

        $columns = array('id', 'name', 'created_at', 'status');
        $getfiled = array('id', 'name', 'created_at', 'status');
        $condition = array();
        $join_str = array();
        echo Unit::UnitModel('unit_masters', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function AddUnit() {
        return view('user.unit.add', $this->data);
    }

    public function Saveunit(Request $request) {
        $rules = array(
            'name' => 'required|min:2|max:200',
        );

        $messages = array(
            'name.required' => 'Please enter name',
            'name.min' => 'Title should be minimum :min characters',
            'name.max' => 'Title should be between 2 to 200 characters',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $units = Unit::where('name', $request->name)->get();
        if (!$units->isEmpty()) {
            return redirect()->back()->with('error', 'Unit already exists');
        }

        $saveunits = new Unit();
        $saveunits->name = $request->name;
        $saveunits->save();
        return redirect()->route('unit')->with('success', 'Unit added successfully');
    }

    public function editUnit($id) {
        $unit_detail = Unit::find($id);
        if (!$unit_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['unit_detail'] = $unit_detail;
        return view('user.unit.edit', $this->data);
    }

    public function UpdateUnit(Request $request) {
        $rules = array(
            'name' => 'required|min:2|max:200',
        );

        $messages = array(
            'name.required' => 'Please enter name',
            'name.min' => 'Title should be minimum :min characters',
            'name.max' => 'Title should be between 2 to 200 characters',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $units = Unit::where('name', $request->name)->where('id', '!=', base64_decode($request->unit_id))->get();
        if (!$units->isEmpty()) {
            return redirect()->back()->with('error', 'Unit already exists');
        }

        $edit_unit = Unit::find(base64_decode($request->unit_id));

        if (!$edit_unit) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $edit_unit->name = $request->name;
        $edit_unit->save();
        
        return redirect()->route('unit')->with('success', 'Unit updated successfully');
    }

    public function changeUnitStatus(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Unit::find($id);
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $changeStatus;
            $html = view('user.unit.statusmodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function updateUnitStatus(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->unit_id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = Unit::find(base64_decode($request->unit_id));

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

    public function UnitDeleteModal(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $unitsDetail = Unit::find($id);

            if (!$unitsDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $unitsDetail;
            $html = view('user.unit.deletemodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function DeleteUnit(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }

            if (Unit::find(base64_decode($request->serviceId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Unit deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }

}
