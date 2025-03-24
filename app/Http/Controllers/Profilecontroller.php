<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Common;
use Auth;
use App\Models\Admin;
use Session;
use DB;

class Profilecontroller extends Controller 
{

    public $data = [];

    public function index(Request $request) {
        $this->data['user_detail'] = Admin::find(Auth::User()->id);
        return view('user.profile.profileform', $this->data);
    }

    public function updateprofile(Request $request) {

        $messages = array(
            'first_name.required' => 'Please enter an first name',
            'first_name.string' => 'Please enter only string',
            'first_name.min' => 'First name must conatin minimum 2 characters',
            'first_name.max' => 'First name must conatin maximum 32 characters',
            'last_name.required' => 'Please enter an last name',
            'last_name.string' => 'Please enter only string',
            'last_name.min' => 'Last name should be minimum :min characters',
            'last_name.max' => 'Last name must conatin maximum 32 characters',
            'email.required' => 'Please enter a email',
            'email.email' => 'Invalid Email Formate',
            'email.max' => 'Email must be 255 character',
            'number.required' => 'Please enter Phone number',
            'number.max' => 'Phone number must contains 10 character',
//            'number.numeric' => 'Please enter valid phone number',
        );
        $rules = array(
            'first_name' => 'required|string|min:2|max:32',
            'last_name' => 'required|string|min:2|max:32',
            'email' => 'required|email|max:255',
            'number' => 'required|min:12|regex:/^\d{3}-\d{3}-\d{4}$/',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }

        $user_detail = Admin::find(Auth::User()->id);

        if (!$user_detail) {
            return redirect()->back()->with('error', 'Information not found.');
        } else {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $isUploadImage = Common::uploadSingleImage($image, 'admin_profile');
                if (!$isUploadImage) {
                    return redirect()->back()->with('error', 'Something went wrong.Please try again');
                }
                if (file_exists(public_path('/uploads/admin_profile/' . $user_detail->image)) && !empty($user_detail->image)) {
                    unlink(public_path('/uploads/admin_profile/' . $user_detail->image));
                }
                $user_detail->image = $isUploadImage;
            }

            $user_detail->first_name = $request->first_name;
            $user_detail->last_name = $request->last_name;
            $user_detail->email = $request->email;
            $user_detail->number = str_replace('-', '', $request->number);
            $user_detail->updated_at = date('Y-m-d h:i:s');

            if ($user_detail->save()) {                
                return redirect()->back()->with('success', 'Profile updated successfully.');
            }
            return redirect()->back()->with('error', 'Something went wrong.please try again.');
        }
    }

}
