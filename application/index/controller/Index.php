<?php
namespace app\index\controller;

use \think\Db;

class Index
{
    public function index()
    {
        $egs = Db::table('eg')->select();
        return view('index', [
            'egs' => $egs
        ]);
    }
}
