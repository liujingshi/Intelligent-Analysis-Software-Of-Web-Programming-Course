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
    private function state($state, $data = "") {
        $result = [
            'state' => $state,
            'data' => $data
        ];
        return json_encode($result);
    }

    /**
     * table数据表格url数据格式
     *  {
     *   "code": 0,
     *   "msg": "",
     *   "count": 1000,
     *   "data": [{}, {}]
     *  } 
     */
    private function tableData($data) {
        $result = [
            "code" => 0,
            "msg"  => "",
            "count" => count($data),
            "data" => $data
        ];
        return $result;
    }

    /**
     * 删除一个案例的文件
     */
    private function delDir($dir) {
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
           if($file!="." && $file!="..") {
              $fullpath=$dir."/".$file;
              if(!is_dir($fullpath)) {
                 unlink($fullpath);
              } else {
                 deldir($fullpath);
              }
           }
        }
        closedir($dh);
        if(rmdir($dir)) {
           return true;
        } else {
           return false;
        }
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
            if(!captcha_check($post['captcha'])){
                return $this->state('fail');
            };
            $data = [
                'username' => $post['username'],
                'password' => md5($post['password'])
            ];
            if (Db::table('admin')->where($data)->find()) {
                Session::set('admin', $post['username']);
                $user = Db::table('admin')->where($data)->select();
                Session::set('user_id', $user[0]['id']);
                return $this->state('success');
            } else {
                return $this->state('fail');
            }
        } else {
            return $this->goto404();
        }
    }

    /**
     * 获取分类的table接口
     */
    public function getClass() {
        if ($this->check()) {
            $data = Db::table('iclass')->select();
            return $this->tableData($data);
        }
        return $this->goto404();
    }


    /**
     * 获取案例的table接口
     */
    public function getEgs() {
        if ($this->check()) {
            $data = Db::table('eg')->where('user_id', Session::get('user_id'))->select();
            return $this->tableData($data);
        }
        return $this->goto404();
    }

    /**
     * 获取用户的table接口
     */
    public function getUsers() {
        if ($this->check()) {
            $data = Db::table('admin')->select();
            return $this->tableData($data);
        }
        return $this->goto404();
    }

    /**
     * 获取目录的table接口
     */
    public function getDir() {
        if ($this->check()) {
            $request = Request::instance();
            $post = $request->param();
            $root = './pages/'.$post['eg'];
            $dir = $root.$post['dir'];
            $sdir = scandir($dir);
            $data = [];
            foreach ($sdir as $t) {
                if ($t == '.' || $t == '..') {
                    continue;
                }
                $f = [
                    'name' => $t,
                    'ftype' => ''
                ];
                if (is_dir($dir.$t)) {
                    $f['ftype'] = '目录';
                    $data[] = $f;
                } else if (is_file($dir.$t)) {
                    $f['ftype'] = '文件';
                    $data[] = $f;
                }
            }
            return $this->tableData($data);
        }
        return $this->goto404();
    }

    /**
     * 添加用户
     */
    public function addUser() {
        if ($this->checkMethod()) {
            if ($this->check()) {
                $request = Request::instance();
                $post = $request->param();
                $username = $post['username'];
                $password = md5($post['password']);
                Db::table('admin')->insert([
                    'username' => $username,
                    'password' => $password
                ]);
                return $this->state('success');
            }
        }
        return $this->goto404();
    }


    /**
     * 添加案例
     */
    public function addEg() {
        if ($this->checkMethod()) {
            if ($this->check()) {
                $request = Request::instance();
                $post = $request->param();
                $name = $post['name'];
                $class_id = $post['iclass'];
                $user_id = Session::get('user_id');
                $data = [
                    'name' => $name,
                    'class_id' => $class_id,
                    'user_id' => $user_id
                ];
                Db::table('eg')->insert($data);
                $eg = Db::table('eg')->where($data)->select();
                $id = $eg[0]['id'];
                mkdir('./pages/eg'.$id, 0777, true);
                return $this->state('success');
            }
        }
        return $this->goto404();
    }

    
    /**
     * 添加分类
     */
    public function addClass() {
        if ($this->checkMethod()) {
            if ($this->check()) {
                $request = Request::instance();
                $post = $request->param();
                $name = $post['name'];
                Db::table('iclass')->insert([
                    'name' => $name
                ]);
                return $this->state('success');
            }
        }
        return $this->goto404();
    }

    /**
     * 删除案例
     */
    public function delEg() {
        if ($this->checkMethod()) {
            if ($this->check()) {
                $request = Request::instance();
                $post = $request->param();
                $id = $post['id'];
                Db::table('eg')->where('id', $id)->delete();
                $this->delDir('./pages/eg'.$id);
                return $this->state('success');
            }
        }
        return $this->goto404();
    }

    /**
     * 新建目录
     */
    public function newdir() {
        if ($this->checkMethod()) {
            if ($this->check()) {
                $request = Request::instance();
                $post = $request->param();
                $eg = $post['eg'];
                $dir = $post['dir'];
                $newdir = $post['newdir'];
                $root = './pages/'.$eg;
                $dir = $root.$dir;
                mkdir($dir.$newdir, 0777, true);
                return $this->state('success');
            }
        }
        return $this->goto404();
    }

}
