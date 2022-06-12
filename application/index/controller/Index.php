<?php
namespace app\index\controller;

use app\index\controller\Showflower;
use app\index\model\Flower;
use app\index\model\Shoplist;
use think\Controller;
use think\Db;
use think\Request;
use think\Console;

class Index extends Controller
{
    public function index()
    {
        $fclass = Db::table('flower')->distinct('true')->field('fclass')->select();
        $this->assign('fclasses', $fclass);

        $fname = input('post.fname');
        $fcls = input('post.fclass');
        $minprice = input('post.minprice');
        $maxprice = input('post.maxprice');

        if (empty($maxprice)) {
            $maxprice = 100000;
        }

        if (empty($minprice)) {
            $minprice = 0;
        }

//         $searchstr='yourprice between'.$minprice.'and'.$maxprice;
        $searchstr = "yourprice >$minprice and yourprice<$maxprice";

        if (!empty($fcls)) {
            $searchstr .= " and fclass='$fcls'";
        }

        if (!empty($fname)) {
            $searchstr .= " and fname like '%$fname%'";
        }

        $data = Db::table('flower')->where($searchstr)->order('SelledNum desc')->select();
        $this->assign('flower', $data);

        return $this->fetch();
    }
    public function showflower()
    {
        // $data = Db::table('flower')->order('SelledNum', 'desc')->paginate(5, false, ['path' => 'javascript:AjaxPage([PAGE]);']);
        // $this->assign('flowers', $data);
        // $page = $data->render();
        // $this->assign('pageHtml', $page);
        $flowers = Db::table('flower')
            ->order(['SelledNum' => 'desc', 'price' => 'asc'])
            ->paginate(5, false, [
                'path' => 'javascript:AjaxPage([PAGE]);']);
        $pageHtml = $flowers->render();

        $this->assign('flowers', $flowers);
        $this->assign('pageHtml', $pageHtml);

        Showflower::renderSideBar($this);
        return $this->fetch();
    }
    // ajax请求分页内容的方法
    public function showflowerajax(Request $request)
    {
        // 在url中取出当前的页码
        $page = $request->param('page');
        if (!empty($page)) {
            // 当前页显示的数据
            $flowers = Db::table('flower')
                ->order(['SelledNum' => 'desc', 'price' => 'asc'])
                ->paginate(5, false, [
                    'path' => 'javascript:AjaxPage([PAGE]);']);
            // 修改按钮的路径，点击按钮执行JS函数AjaxPage()。page（页码）由tp5赋值

            // 按钮组的的Html代码
            $pageHtml = $flowers->render();

            $data['flowers'] = $flowers;
            $data['pageHtml'] = $pageHtml;
  
            // 向前端返回Json字符串
            return json($data);
        }
    }
    public function flowerdetail()
    {
        $flowerID = input('get.flowerID');
        $flower = Flower::get($flowerID);
        $this->assign('flower', $flower);
        $shoplists = Shoplist::where("flowerID='" . $flowerID . "' and pjstar is not null")->select();
        $this->assign('shoplists', $shoplists);
        return $this->fetch();
    }
}
