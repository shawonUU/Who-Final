<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailSettingController extends Controller
{
  public function index()
  {
    return view('admin.email_setting.index');
  }

  public function store(Request $request)
  {
    return $request;
  }
}
