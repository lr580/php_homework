<?php
namespace app\admin\controller;
use think\Request;
use think\Controller;
use app\index\model\Flower as FlowerModel;
class Flower extends Controller
{
    public function index(){
        if(empty(session('username')))
        {
            $this->error('请先登录','adminlogin/index');
        }
        $flowers=FlowerModel::all();
        $this->assign('flowers',$flowers);
        return $this->fetch('flowerindex');
    }
    public function floweradd(){
        return $this->fetch();
    }
    
    public function addFlower(Request $request){
        $flowerID=$request->param('flowerID');
        if(empty($flowerID)){
            $this->error('请填写鲜花编号');
        }
        $flower1=FlowerModel::get($flowerID);
        if(!empty($flower1)){
            $this->error('您填写鲜花编号已存在！');
        }
        $flower=new FlowerModel();
        $flower->flowerID=$flowerID;
        $flower->fname=$request->param('fname');
        $flower->myclass=$request->param('myclass');
        $flower->fclass=$request->param('fclass');
        $flower->fclass1=$request->param('fclass1');
        $flower->cailiao=$request->param('cailiao');
        $flower->baozhuang=$request->param('baozhuang');
        $flower->huayu=$request->param('huayu');
        $flower->shuoming=$request->param('shuoming');
        $flower->price=$request->param('price');
        $flower->yourprice=$request->param('yourprice');
        $flower->tejia=$request->param('tejia');
        $flower->SelledNum=0;
    
        $pictures=$request->file('pictures');
        if	(empty($pictures)){
            $this->error('请选择上传文件');
        }
        $info=$pictures->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
        $flower->pictures=$info->getSaveName();
    
        $picturem=$request->file('picturem');
        if	(empty($picturem)){
            $this->error('请选择上传文件');
        }
        $info=$picturem->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
        $flower->picturem=$info->getSaveName();
        $pictureb=$request->file('pictureb');
        if(empty($pictureb)){
            $this->error('请选择上传文件');
        }$info=$pictureb->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
        $flower->pictureb=$info->getSaveName();
         
        $pictured=$request->file('pictured');
        if(!empty($pictured)){
            $info=$pictured->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->pictured=$info->getSaveName();
        }
        $cailiaopicture=$request->file('cailiaopicture');
        if(!empty($cailiaopicture)){
            $info=$cailiaopicture->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->cailiaopicture=$info->getSaveName();
        }
        $bzpicture=$request->file('bzpicture');
        if(!empty($bzpicture)){
            $info=$bzpicture->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->bzpicture=$info->getSaveName();
        }
        $flower->save();
        $this->success('添加成功！','flower/index');
    }
    
    public function flowerDelete(){
        $flower=FlowerModel::get(input('get.flowerID'));
        $flower->delete();
        $this->redirect('flower/index');
    }
    
    public function flowerupdate(){
        $flower=FlowerModel::get(input('get.flowerID'));
        $this->assign('flower',$flower);
        return $this->fetch();
    }
    
    public function updateFlower(Request $request){
        $flower=FlowerModel::get(input('post.flowerID'));
        $flower->fname=$request->param('fname');
        $flower->myclass=$request->param('myclass');
        $flower->fclass=$request->param('fclass');
        $flower->fclass1=$request->param('fclass1');
        $flower->cailiao=$request->param('cailiao');
        $flower->baozhuang=$request->param('baozhuang');
        $flower->huayu=$request->param('huayu');
        $flower->shuoming=$request->param('shuoming');
        $flower->price=$request->param('price');
        $flower->yourprice=$request->param('yourprice');
        $flower->tejia=$request->param('tejia');
         
        $pictures=$request->file('pictures');
        if(!empty($pictures)){
            $info=$pictures->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->pictures=$info->getSaveName();
        }
    
        $picturem=$request->file('picturem');
        if(!empty($picturem)){
            $info=$picturem->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->picturem=$info->getSaveName();
        }
        $pictureb=$request->file('pictureb');
        if(!empty($pictureb)){
            $info=$pictureb->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->pictureb=$info->getSaveName();
        }
    
        $pictured=$request->file('pictured');
        if(!empty($pictured)){
            $info=$pictured->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->pictured=$info->getSaveName();
        }
    
        $cailiaopicture=$request->file('cailiaopicture');
        if(!empty($cailiaopicture)){
            $info=$cailiaopicture->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->cailiaopicture=$info->getSaveName();
        }
        $bzpicture=$request->file('bzpicture');
        if(!empty($bzpicture)){
            $info=$bzpicture->validate(['ext'=>'jpg,png'])->move(ROOT_PATH.'public/static'.DS.'picture','');
            $flower->bzpicture=$info->getSaveName();
        }
        $flower->save();
        $this->success('修改成功！','flower/index');
    }
}

