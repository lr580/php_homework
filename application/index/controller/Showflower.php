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
        $pvalue = input('get.pvalue');
        $pvalue1 = input('get.pvalue1');
        $pvalue2 = input('get.pvalue2');
        $handler = Db::table($this::$dbname);
        if (!$pname) {
            $pname = session('pname');
            $pvalue = session('pvalue');
            $pvalue1 = session('pvalue1');
            $pvalue2 = session('pvalue2');
        }
        session('pvalue', $pvalue);
        session('pname', $pname);
        session('pvalue1', $pvalue1);
        session('pvalue2', $pvalue2);
        if (substr($pname, 0, 6) == 'fclass' || $pname == 'tejia') {
            $handler->where($pname, $pvalue);
        } else if ($pname) {
            $handler->where($pname, 'egt', $pvalue1)->where($pname, 'elt', $pvalue2);
        }
        $data = $handler->order('SelledNum', 'desc')->paginate(5);

        $this->assign('flowers', $data);
        $page = $data->render();
        $this->assign('pageHtml', $page);
        $this->renderSideBar($this);
        $this->assign('pname', $pname);
        $this->assign('pvalue', $pvalue);
        $this->assign('pvalue1', $pvalue1);
        $this->assign('pvalue2', $pvalue2);
        return $this->fetch('index/showflower');
    }


    public static function renderSideBar($that)
    {
        $dbname = Showflower::$dbname;
        // $handler = Db::table($this::$dbname);
        $class0 = Db::query("select distinct fclass from $dbname");
        $class1 = Db::query("select distinct fclass1 from $dbname");
        // dump($class0);
        $that->assign('fclass', $class0);
        $that->assign('fclass1', $class1);
    }
}
