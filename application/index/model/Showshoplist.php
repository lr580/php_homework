<?php
namespace app\index\model;

use think\Model;

class Showshoplist extends Model
{
    public function showorder(){
        return $this->belongsTo('showorder');
    }
}

