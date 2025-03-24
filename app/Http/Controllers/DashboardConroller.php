<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DashboardConroller extends Controller
{
    public $data = [];
    
    public function index(Request $request) {
                
        return view('user.dashboard.dashboard', $this->data);
    }
}
