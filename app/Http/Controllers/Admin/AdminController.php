<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}
	
    public function index(){
      dump('admin page will design later');
    }
}
