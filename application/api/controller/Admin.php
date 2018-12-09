<?php
namespace app\api\controller;

use \think\Session;
use \think\Request;
use \think\Db;

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

    /**
     * 返回状态的JSON字符串
     * 参数: 状态字符串
     * 返回值: JSON字符串
     */
    private function state($state) {
        $result = [
            'state' => $state
        ];
        return json_encode($result);
    }

    /**
     * 管理员登录接口
     * 参数: Ajax POST 'username' 'password'
     * 返回值: JSON state => 'success' 'fail'
     */
    public function login() {
        if ($this->checkMethod()) {
            $request = Request::instance();
            $post = $request->param();
            $data = [
                'username' => $post['username'],
                'password' => md5($post['password'])
            ];
            if (Db::table('admin')->where($data)->find()) {
                Session::set('admin', '');
                return $this->state('success');
            } else {
                return $this->state('fail');
            }
        } else {
            return $this->goto404();
        }
    }

}
