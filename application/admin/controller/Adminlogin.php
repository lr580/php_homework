<?php
namespace app\admin\controller;
use app\admin\model\Admin;
use think\Controller;

class Adminlogin extends Controller
{
    public function login(){
        return $this->fetch();
    }
    
    public function doLogin(){
        $username = input('post.username');
        $password = input('post.password');
        if(empty($username)){
            $this->error('用户名不能为空');
        }
        if(empty($password)){
            $this->error('密码不能为空');
        }
        $user=Admin::get($username);
        if(empty($user)){
            $this->error('您输入的用户名不存在!');
        }elseif($user->password == md5($password)){          
             session('username',$username);
             $this->redirect(url('index/index'));
        }else{
            $this->error('您输入的密码错误!');
        }
    }
    
    public function logout(){
        session('username',null);
        $this->redirect('index/index/index');
    }
}

