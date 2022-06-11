<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Comment extends Controller
{
    public function show()
    {
        $data = Db::table('shoplist')->where('pjtime', 'gt', '1901-1-1 0:0:0')->order('pjtime', 'desc')->paginate(5);
        $page = $data->render();
        $comment = [];
        foreach ($data as $item) {
            $item2 = [];
            foreach ($item as $k => $i) {
                // array_push($item2, $i);
                $item2[$k] = $i;
            }
            $msg = Db::table('flower')->where('flowerID', $item['flowerID'])->select();
            foreach ($msg[0] as $k => $i) {
                $item2[$k] = $i;
            }
            array_push($comment, $item2);
        }
        $this->assign('comment', $comment);
        $this->assign('page', $page);
        return $this->fetch();
    }
}
