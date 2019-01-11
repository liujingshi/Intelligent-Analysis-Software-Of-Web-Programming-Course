<?php
namespace app\admin\controller;

use \think\Session;

class Index
{
    public function index()
    {
        if (Session::has('admin') && Session::get('admin') != "") {
            return view('index');
        } else {
            return view('login');
        }
    }
}
