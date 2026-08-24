<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use DB;
use Auth;
use App\Models\Common;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;

class UserController extends Controller {

    public $data = [];

    public function index() {
        return view('user.user.user');
    }

    public function getuser(Request $request) {

        $columns = array('id', 'user_name', 'email', 'phone_number', 'created_at', 'status');
        $getfiled = array('id', 'user_name', 'email', 'phone_number', 'created_at', 'status');
        $condition = array();
        $join_str = array();
        echo User::UserModel('users', $columns, $condition, $getfiled, $request, $join_str);
        exit;
    }

    public function AddUser() {
        return view('user.user.add', $this->data);
    }

    public function Saveuser(Request $request) {
        $rules = [
            'user_name' => 'required|min:2|max:200',
            'email' => 'string|email|max:255|unique:users,email,NULL,NULL,deleted_at,NULL',
            'phone_number' => 'required',
        ];

        $messages = [
            'user_name.required' => 'Please enter user name',
            'user_name.min' => 'User name should be at least :min characters',
            'user_name.max' => 'User name should not exceed :max characters',
            'email.email' => 'Please enter valid email address.',
            'email.unique' => 'Email already exists.',
            'phone_number.required' => 'Please enter your phone number.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $existingUser = User::where('user_name', $request->user_name)->first();
        if ($existingUser) {
            return redirect()->back()->with('error', 'User already exists')->withInput();
        }
        
        if (User::where('phone_number', '=', str_replace("-", "", $request->phone_number))->exists()) {
            return redirect()->back()->with('error', 'Phone number is already registered')->withInput();
        }
        if(isset($request->email) && !empty($request->email)){
            if (User::where('email', '=', $request->email)->exists()) {
                return redirect()->back()->with('error', 'Email already exists')->withInput();
            }
        }

        $user = new User();
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->save();
        return redirect()->route('user')->with('success', 'User added successfully');
    }

    public function editUser($id) {
        $user_detail = User::find($id);
        if (!$user_detail) {
            return redirect()->back()->with('error', 'Information not found');
        }
        $this->data['user_detail'] = $user_detail;
        return view('user.user.edit', $this->data);
    }

    public function UpdateUser(Request $request) {
        $userID = base64_decode($request->user_id);
        $rules = [
            'user_name' => 'required|min:2|max:200',
            'email' => 'required|string|email|max:250',
        ];

        $messages = [
            'user_name.required' => 'Please enter user name',
            'user_name.min' => 'User name should be at least :min characters',
            'user_name.max' => 'User name should not exceed :max characters',
            'email.required' => 'Please enter a email address.',
            'email.email' => 'Please enter valid email address.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $users = User::where('email', $request->email)->where('id', '!=', base64_decode($request->user_id))->get();
        if (!$users->isEmpty()) {
            return redirect()->back()->with('error', 'Email is already registered');
        }
        
        $user = User::find(base64_decode($request->user_id));
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->save();
        
        return redirect()->route('user')->with('success', 'User updated successfully');
    }

    public function changeUserStatus(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = User::find($id);
            if (!$changeStatus) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $changeStatus;
            $html = view('user.user.statusmodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function updateUserStatus(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->user_id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $changeStatus = User::find(base64_decode($request->user_id));

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

    public function UserDeleteModal(Request $request, $id) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($id == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }
            $usersDetail = User::find($id);

            if (!$usersDetail) {
                return response()->json(['status' => $status, 'message' => 'Information not found']);
            }
            $this->data['edit_data'] = $usersDetail;
            $html = view('user.user.deletemodal', $this->data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        exit;
    }

    public function DeleteUser(Request $request) {
        if ($request->ajax()) {
            $status = 'fail';
            if ($request->serviceId == "") {
                return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
            }

            if (User::find(base64_decode($request->serviceId))->delete()) {
                return response()->json(['status' => 'success', 'message' => 'User deleted successfully']);
            }
            return response()->json(['status' => $status, 'message' => 'Something went Wrong.Please try again']);
        }
        exit;
    }
    
    public function importUser(Request $request) {
        $rules = [
            'user_file' => 'required|mimes:csv,txt,xlsx|max:2048'
        ];

        $messages = [
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        Excel::import(new UserImport, $request->file('user_file'));

        return redirect()->route('user')->with('success', 'Users imported successfully!');
    }

}
