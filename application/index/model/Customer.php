<?php
namespace app\index\model;

use think\Model;

class Customer extends Model
{
    //	设置完整的数据表名（包含前缀）
    protected $table = 'tb_customer';
    public function member(){
        return $this->belongsTo('member');
    }
    
}

