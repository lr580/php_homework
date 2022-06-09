<?php
namespace app\index\controller;

use think\Controller;

class Login extends Controller
{
    public function login(){
        return view();
    }
    
    public function doLogin(){
        if(empty(input('post.email')))
        {
            $this->error('email不能为空！');
        }
        
        $rs=db('tb_member')->where('email',input('post.email'))->find();
        if(empty($rs))
        {
            $this->error('用户名错误！');
        }
        
        
        if($rs['password']!=md5(input('post.passw'))){
            $this->error('密码错误!');
        }
        $data = input('post.');
        if(!captcha_check($data['verifyCode'])) {
            
            // 校验失败
            
            $this->error('验证码不正确');
            
        }
        
        session('email',$rs['email']);
        $this->redirect(url('index/index/index'));
    }
    
    
    public function LogOut(){
        session('email',null);
        $this->redirect(url('index/index/index'));
    }
}

