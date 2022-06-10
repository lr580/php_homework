<?php
namespace app\index\controller;
use think\Db;
use app\index\model\Flower;
use app\index\model\Shoplist;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        $fclass=Db::table('flower')->distinct('true')->field('fclass')->select();
        $this->assign('fclasses',$fclass);
        
        $fname=input('post.fname');
        $fcls=input('post.fclass');
        $minprice=input('post.minprice');
        $maxprice=input('post.maxprice');
        
        if(empty($maxprice)){
            $maxprice=100000;
        }
        
        if(empty($minprice)){
            $minprice=0;
        }
        
//         $searchstr='yourprice between'.$minprice.'and'.$maxprice;
        $searchstr="yourprice >$minprice and yourprice<$maxprice";
        
        if(!empty($fcls)){
            $searchstr .=" and fclass='$fcls'";
        }
        
        if(!empty($fname)){
            $searchstr.=" and fname like '%$fname%'";
            //瑕佹湁绌烘牸瀛楃涓查噷闈㈣鏈�''
        }
        
        $data=Db::table('flower')->where($searchstr)->order('SelledNum desc')->select();
        $this->assign('flower',$data);
        //瑕佷紶杈撴暟鎹殑鏃跺�欓噰鐢╢etch
        return $this->fetch();
    }
    public function showflower(){
        $data=Db::table('flower')->order('SelledNum','desc')->paginate(5);//鎺掑簭锛涘垎椤垫樉绀猴紝涓�椤�5涓�
        $this->assign('flowers',$data);
        $page=$data->render();//瀵艰埅鏉�
        $this->assign('page',$page);
        return $this->fetch();
        
    }
    public function flowerdetail(){ 
        $flowerID = input('get.flowerID');
        $flower=Flower::get($flowerID);
        $this->assign('flower',$flower);
        $shoplists=Shoplist::where("flowerID='".$flowerID."' and pjstar is not null")->select();
        $this->assign('shoplists',$shoplists);
        return $this->fetch();
    }
}
