<?php
/**
 * 产销模型
 */
namespace app\index\model;
use think\Model;

class LevelModel extends Model
{
    // 确定链接表名
    protected $table = 'pq_level';

    /**
     * 获取地区
     * @param $id  农户ID
     * @return bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get_area($id){
        if(!$id){
            return false;
        }
        $area_name = '';
        global $pid;
        $pid = $id;
        do{
            $info = $this->field(['id','type_id','name','level'])->where('id',$pid)->find();
            $info = objToArray($info);
            $area_name = $info['name'].$area_name;
            $pid = $info['type_id'];
        }while ($pid!=0);

        return $area_name;
    }

}