<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Common;
use App\Models\Admin;
use Auth;
use Hash;
use Session;
use App\Models\Settings;
use App\Mail\EmailTemplate;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public $data = [];
    
    public function index(Request $request) {
        if (!Auth::check()) {
            return view('user.login.index', $this->data);
        }
        return redirect()->route('dashboard');
    }
        
    public function saveLogin(Request $request) {
        $messages = array(
            'email.required' => 'Please enter an email',
            'email.email' => 'Invalid Email',
            'password.required' => 'Please enter a password',
            'password.min' => 'Password must conatin atleast 6 characters',
            'password.max' => 'Password must conatin maximum 24 characters',
        );
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6|max:24',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                return redirect()->back()->with('error', $messages[0])->withInput();
            }
        }
        if (!empty(Session::get('requestEmail'))) {
            Session::forget('requestEmail');
        }
        $checkEmailExist = Admin::where('email',$request->email)->get();
        if ($checkEmailExist->isEmpty()) {
            return redirect()->back()->with('error', 'Email does not exist');
        }
        
        if (!Hash::check($request->password, $checkEmailExist[0]->password)) {
            return redirect()->back()->with('error', 'Invalid password')->withInput($request->all);
        }
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with('error', 'Email and password does not match')->withInput($request->all);
    }
    
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
