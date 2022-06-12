<?php
namespace app\admin\controller;

use app\admin\model\Peisong;
// use app\admin\model\Showorder;
use app\index\model\Myorder;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
            if(empty(session('username'))){
                $this->error('请先登录!','adminlogin/login');
            }
            // $fclass = Db::table('flower')->distinct('true')->field('fclass')->select();
            // $this->assign('fclasses', $fclass);
            
            $flowernum=Db::table('flower')->count();
            $this->assign('flowernum', $flowernum);

            $shoplistnum=Db::table('shoplist')->count();
            $this->assign('shoplistnum', $shoplistnum);

            $ordernum=Db::table('showorder')->count();
            $this->assign('ordernum', $ordernum);

            $membernum=Db::table('tb_member')->count();
            $this->assign('membernum', $membernum);

            $addnum=Db::table('tb_customer')->count();
            $this->assign('addnum', $addnum);
            
            return $this->fetch('adminindex');
    }
}
