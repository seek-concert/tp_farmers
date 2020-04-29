<?php
/**
 * 产销模型
 */
namespace app\admin\model;
use think\Model;

class LevelModel extends Model
{
    // 确定链接表名
    protected $table = 'pq_level';

    /**
     * 获取产销数据
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getLevelList()
    {
        return $this->field('id,type_id pid,level,name,yield,sales,is_menu,num,linkurl,imgurl,imgurls,sort')->order('sort asc,id desc')->select();
    }

    /**
     * 插入产销信息
     * @param $param
     * @return array|\think\response\Json
     */
    public function insertLevel($param)
    {
        try{
            if($param['level']>4||$param['level']==4){
                return msg(-2, '', '已经到底了，添加失败');
            }
            $this->save($param);
            return msg(1, '', '添加成功');
        }catch(\Exception $e){

            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑产销
     * @param $param
     * @return array|\think\response\Json
     */
    public function editLevel($param)
    {
        try{
            $this->save($param, ['id' => $param['id']]);
            return msg(1, '', '编辑成功');
        }catch(\Exception $e){

            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 删除产销
     * @param $id
     * @return array|\think\response\Json
     */
    public function delLevel($id)
    {
        try{
            $this->where('id', $id)->delete();
            return msg(1, '', '删除成功');

        }catch(\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }
}