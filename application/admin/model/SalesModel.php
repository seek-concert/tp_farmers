<?php
/**
 * 销售记录模型
 */
namespace app\admin\model;
use think\Model;

class SalesModel extends Model
{
    // 确定链接表名
    protected $table = 'pq_sales';

    /**
     * 根据搜索条件获取列表信息
     * @param $where
     * @param $offset
     * @param $limit
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getOrderByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

   
    /**
     * 删除订单
     * @param $id
     * @return array|\think\response\Json
     */
    public function delUser($id)
    {
        try{
            $this->where('id', $id)->delete();
            return msg(1, '', '删除订单成功');
        }catch(\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 根据订单号获取订单信息
     * @param $order_num
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function findOrder($order_num)
    {
        return $this->where('order_num', $order_num)->find();
    }

    //关联农户信息
    public function levels(){
        return $this->hasOne('Level','l_id','id')
            ->bind(['name'=>'farmers_name','num'=>'farmers_num','yield'=>'yield','sales'=>'sales',
                'imgurl'=>'imgurl','imgurls'=>'imgurls']);
    }
  
}