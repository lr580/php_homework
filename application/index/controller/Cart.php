<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
class Cart extends Controller
{
    
    public function index(){
        if(empty(session('email'))){
            $this->error('请先登录!','login/login');
        }
        $data=Db::table('vcart')->where('email',session('email'))->select();
    
        $this->assign('result',$data);
        return $this->fetch();
    }
    
    
    public function addCart(){
        $flowerID = input('get.flowerID');
        //是否已经登录
        if(empty(session('email'))){
            $this->error('请先登录!','index/login/login');
        }
        //是否选择商品
        if(empty($flowerID)){
        $this->error('请选择商品!','index/index');
    }
    //d)判断购物车是否已经存放了该用户所选的商品，如果不存在，则将该商品放入购物车,如果存在，则把购物车该商品原来数量加1。
        $data = db('cart')->where('email',session('email'))->where('flowerID',$flowerID)->find();
        if(empty($data)){
            $data=[
                'email'=>session('email'),
                'flowerID'=>$flowerID,
                'num'=>1
            ];
            db('cart')->insert($data);
        }else{
            db('cart')->where('email',session('email'))
            ->where('flowerID',$flowerID)
            ->setInc('num');
        }
        $this->redirect ('cart/showcart');
        }
        
    public function showcart(){
        $flowerID = input('get.flowerID');
        //是否已经登录
        if(empty(session('email'))){
            $this->error('请先登录!','index/login/login');
        }
        //b)查找购物车
        $data=db('vcart')->where('email',session('email'))->select();
        //c)将查询结果绑定，传递到showcart.html中显示
        $this->assign("result",$data);
        return $this->fetch();
        
    }
    
    public function clearCart(){
        $data=db("cart")->where("email",session('email'))->delete();
        return redirect("index\index");
    }
    public function deleteCart(){
        $cartId=input("get.cartID");
        db('cart')->delete($cartID);
    }
    public function updateCart(){
        $cartID=input('get.cartID');
        $num=input('get.num');
        db('cart')->where('cartID',$cartID)->setField('num',$num);
    }
    
}
