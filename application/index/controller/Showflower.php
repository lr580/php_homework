<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Showflower extends Controller
{
    private static $dbname = 'flower';
    public function clsflower()
    {
        $pname = input('get.pname');
        $handler = Db::table($this::$dbname);
        if (substr($pname, 0, 6) == 'fclass' || $pname == 'tejia') {
            $pvalue = input('get.pvalue');
            $handler->where($pname, $pvalue);
        } else {
            $pvalue1 = input('get.pvalue1');
            $pvalue2 = input('get.pvalue2');
            $handler->where($pname, 'egt', $pvalue1)->where($pname, 'elt', $pvalue2);
            // return $pname.$pvalue1.$pvalue2;
        }
        // $data = $handler->order('SelledNum', 'desc');
        // $this->assign('flowers', $data);
        // $this->assign('page', null);
        // return $this->fetch('index/showflower');

        $data = $handler->order('SelledNum', 'desc')->paginate(114514);
        $this->assign('flowers', $data);
        $page = $data->render();
        $this->assign('page', $page);
        return $this->fetch('index/showflower');
        /*存在bugs：翻页后不再有分类，所以删除了分页功能 */
    }
}
