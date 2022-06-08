<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use app\index\model\Member as MemberModel;



class Member extends Controller
{
    public function showmember(){
        if(session('email')==null){
            $this->error("请先登录！",url("login/login"));
        }
        $data=MemberModel::get(session('email'));
        $this->assign("member",$data);
        return $this->fetch();
        
    }
    
    public function changpw(){
        $oldpassw=md5(input("post.oldpassw"));
        $newpassw1=md5(input("post.newpassw1"));
        $data=MemberModel::where("email",session('email'))->where('password',$oldpassw)->find();
        if($data==null){
            $this->error("您输入得旧密码不正确",url("login/login"));
        }
        Db::execute("update tb_member set password ='$newpassw1'
            where email='".session('email')."'");
        $this->success("修改成功!",url('member/showmember'));
    }
    
    public function changmember(){
        $mname=input("post.mname");
        $mobile=input("post.mobile");
        $address=input("post.address");
        Db::execute("update tb_member set mname='$mname',
            mobile='$mobile',
            address='$address'
            where email='".session('email')."'");
        $this->success('修改成功！',url('member/showmember'));
    }
    public function editMember(){
        Db::execute("update tb_member set 
            mname='".input('post.name')."',
            mobile='".input('post.phone')."'
            where email='".session('email')."'");
        $this->success('修改成功，跳转到主页',url('order/order'));
    }
}

