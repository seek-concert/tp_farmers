<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    /**
     * 搜索页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('index/searchs');
    }

    /**
     * 搜索结果页
     * @return mixed
     */
    public function search_result()
    {
        $param = input('');
        $prompt_info = '';
        $order_info = [];
        $area = '';
        if(!$param){
            $prompt_info = "<script>alert('暂无查询信息');</script>";
        }else{
            if(!$param['order_num']){
                $prompt_info = "<script>alert('查询结果异常');</script>";
            }else{
                $order_info = model('SalesModel')
                    ->with(['levels'])->where('order_num', $param['order_num'])->find();
                $order_info = objToArray($order_info);
                $area = model('LevelModel')->get_area($order_info['l_id']);
            }
        }

        $this->assign([
             'order_info'=>$order_info,
             'area'=>$area,
            'prompt_info'=>$prompt_info,

        ]);
        return $this->fetch('index/search_result');
    }

    /**
     * 树状图
     * @return mixed
     */
    public function trees()
    {
        return $this->fetch('index/trees');
    }
}
