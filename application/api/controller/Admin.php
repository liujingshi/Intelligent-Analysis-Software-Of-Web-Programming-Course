<?php
namespace app\api\controller;

use \think\Session;
use \think\Request;

/**
 * 后台API接口
 * 所有数据全使用Ajax POST方式传输
 */
class Admin
{

    /**
     * 检查管理员是否登录
     * 返回值: true/false
     */
    private function check() {
        if (Session::has("admin") && Session::get("admin") != "") {
            return true;
        }
        return false;
    }

    /**
     * 检查请求方式(是否为POST以及Ajax)
     * 返回值: true/false
     */
    private function checkMethod() {
        $request = Request::instance();
        $method = $request->method();
        if ($request->isAjax() && $method == "POST") {
            return true;
        }
        return false;
    }

    /**
     * 前往404页面
     * 返回值: 重定向到404页面
     */
    private function goto404() {
        return redirect('error/error/four_zero_four');
    }

    public function index()
    {
        return $this->goto404();
    }
}
