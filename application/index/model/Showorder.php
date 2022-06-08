<?php
namespace app\index\model;

use think\Model;

class Showorder extends Model
{
    public function showshoplist(){
        return $this->hasMany('showshoplist','orderID','SLID');
    }
}

