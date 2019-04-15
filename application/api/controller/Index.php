<?php

namespace app\api\controller;

use \think\Request;
use \think\Session;

class Index
{

    private function check() {
        if (Session::has("admin") && Session::get("admin") != "") {
            return true;
        }
        return false;
    }

    private function delDir($dir) {
        if (is_dir($dir)) {
            $dh=opendir($dir);
            while ($file=readdir($dh)) {
                if($file!="." && $file!="..") {
                    $fullpath=$dir."/".$file;
                    if(!is_dir($fullpath)) {
                        unlink($fullpath);
                    } else {
                        $this->delDir($fullpath);
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
    }

    private function xCopy($source, $destination, $child){

        if(is_dir($source)) {

            if(!is_dir($destination)) {
            mkdir($destination,0777);   
            }

            $handle=dir($source);   
            
            while($entry=$handle->read()) {   
                if(($entry!=".")&&($entry!="..")){   
                    if(is_dir($source."/".$entry)){   
                        if($child){
                            $this->xCopy($source."/".$entry,$destination."/".$entry,$child);   
                        } 
                    } else {
                        copy($source."/".$entry,$destination."/".$entry);
                    }

                }     
            }   
        }  
    }

    private function egCopy($eg){   

        $source = "./pages/".$eg;
        $destination = "./pages/temp";
        $child = 1;
        
        $this->xCopy($source, $destination, $child);
    }  

    public function analyze() {
        $request = Request::instance();
        $post = $request->param();
        $cmd = "python main.py ".$post['eg'];
        $t = shell_exec($cmd);
        return $t;
    }

    public function change() {
        if ($this->check()) {
            $request = Request::instance();
            $post = $request->param();
            $this->delDir("./pages/temp");
            $this->egCopy($post['eg']);
            $file = fopen("./pages/".$post['eg']."/".$post['name'], "w") or die("Unable to open file");
            fwrite($file, $post['text']);
            fclose($file);
            return '{"status": "success"}';
        } else {
            return '{"status": "login"}';
        }
    }

}
