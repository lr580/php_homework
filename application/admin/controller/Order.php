<?php
namespace app\admin\controller;
use app\admin\model\Peisong;
use app\index\model\Myorder;
use think\Controller;
use think\Db;

class Order extends Controller
{
    public function orderlist(){
        if(empty(session('username'))) {
            $this->error('请先登录！','adminlogin/login');
        }
        $peisongs=Peisong::all();
        $this->assign('peisongs',$peisongs);
        $orderlists=array();
        foreach($peisongs as $order){
            $shoplistitems=array();
            $showshoplists=Db::table('showshoplist')->where('orderID',$order->orderID)->order('orderID desc')->select();
            foreach($showshoplists as $shoplist){
                array_push($shoplistitems, $shoplist);
            }
            array_push($orderlists,$shoplistitems);
        }
        $this->assign('orderlists',$orderlists);
        return $this->fetch();
    }
    public function send(){
        $orderID = input('post.orderID/d');
        $order=Myorder::get($orderID);
        $order->kddh= input('post.kddh');
        $order->status='已发货';
        $order->cltime=date('Y-m-d H:i:s');
        $order->save();
        $this->redirect('order/orderlist');
    }
}

