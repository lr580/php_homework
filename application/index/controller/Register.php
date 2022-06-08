<?php
namespace app\index\controller;
use think\Db;
use think\Controller;

class register extends Controller
{
    public function register(){
        return view();
    }
   public function doRegister()
   {
       
       if(empty(input('post.email')))
       {
            $this->error('email不能为空');    
       }
       
       if(empty(input('post.passw1')))
       {
           $this->error('passw1不能为空');
       }
       if(empty(input('post.passw2')))
       {
           $this->error('passw2不能为空');
       }
       if(input('post.passw1')!=input('post.passw2')){
           $this->error("两次密码输入不一致！");
       }
       
       $data = db('tb_member')->where('email', input('post.email'))->find();  //使用了db助手
       if(!empty($data))
       {
           $this->error('email已经被注册！');
       }
       $result = Db::execute("insert into tb_member(email,password,jifen,ye) values('" . input('post.email') . "','" .md5(input('post.passw1')) . "',0,0)");
    
       session('email',input('post.email'));//自动登录
        $this->success('注册成功！跳转回主页！',url('index/index/index'));
   }
}

