<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Customer as CustomerModel;
use function think\delete;

class Customer extends Controller
{
    public function deleteCustomer(){
        $custID=input('post.custID');
        $customer=CustomerModel::get($custID);
        if($customer!=null)
        {
            $customer->delete();
            return "success";
        }
        else {
            return "";
        }
        
    }
    
    //设置默认地址，删原默认，设新默认
    public function setDefault(){
        $newCustID=input("post.custID");
        $oldCustID=input("post.custID");
        $newCustomer=CustomerModel::get($newCustID);
        $oldCustomer=CustomerModel::get($oldCustID);
        
        try {
            $newCustomer->cdefault="1";
            $newCustomer->save();//修改后保存到数据库里面
            $oldCustomer->cdefault="0";
            $oldCustomer->save();
            return "success";
        } catch (Exception $e) {
            return "";
        }
    }
    
    public function addCustomer(){
        $sname=input('post.addName');
        $mobile=input('post.addPhone');
        $address=input('post.address');
        $customer=new CustomerModel();
        $customer->email=session("email");
        $customer->sname=$sname;
        $customer->mobile=$mobile;;
        $customer->address=$address;
        //查找数据库，判断是否有
        $data=CustomerModel::where('email',session("email"))->select();
        if($data!=null)
        {
            $customer->cdefault="0";
        }
        else{
            $customer->cdefault="1";
        }
        $customer->save();
//         $search="sname='".$sname."' and email='".session("email")."' and mobile='".$mobile."' and address='".$address."'";
//         $customer=CustomerModel::where($search)->order("custID","desc")->find();
       
//         return $customer->custID.' '.$customer->cdefault;
    //model自带ID
        return $customer;
       
    }
    
    public function editCustomer(){
        $sname=input('post.addName');
        $mobile=input('post.addPhone');
        $address=input('post.address');
        $custID=input('post.custID');
        
        //从数据库获取的对象
        $customer=CustomerModel::get($custID);
        if($sname!=null){
            $customer->sname=$sname;    
        }
        if($mobile!=null){
            $customer->mobile=$mobile;
        }
        if($address!=null){
            $customer->address=$address;
        }
        try {
            $customer->save();
            return "success";
        } catch (Exception $e) {
            return "";
        }
        
    }
    
   
}

