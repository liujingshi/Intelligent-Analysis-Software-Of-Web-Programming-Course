<?php
namespace app\admin\controller;

use \think\Session;
use \think\Db;

class Index
{
    public function index()
    {
        if (Session::has('admin') && Session::get('admin') != "") {
            $iclass = Db::table('iclass')->select();
            return view('index', [
                'iclass' => $iclass
            ]);
        } else {
            return view('login');
        }
    }
}
