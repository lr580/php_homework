<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
            if(empty(session('username'))){
                $this->error('请先登录!','adminlogin/login');
            }
            return $this->fetch('adminindex');   
    }
}
