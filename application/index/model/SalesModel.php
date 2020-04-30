<?php
/**
 * 销售记录模型
 */
namespace app\index\model;
use think\Model;

class SalesModel extends Model
{
    // 确定链接表名
    protected $table = 'pq_sales';

    //关联农户信息
    public function levels(){
        return $this->hasOne('LevelModel','id','l_id')
            ->bind(['farmers_name'=>'name','farmers_num'=>'num','yield'=>'yield','sales'=>'sales',
                'imgurl'=>'imgurl','imgurls'=>'imgurls']);
    }
  
}