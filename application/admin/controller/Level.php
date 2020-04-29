<?php
/**
 * 产销管理
 */
namespace app\admin\controller;
use app\admin\model\LevelModel;
use app\common\service\Office;
use think\Db;

class Level extends Base
{
    /**
     * 产销列表
     * @return mixed|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        if(request()->isAjax()){
            $level = new LevelModel();
            $levels = $level->getLevelList();

            $levels = getTrees(objToArray($levels), true);
            return json(msg(1, $levels, 'ok'));
        }
        $order_info = 'http://'.$_SERVER['HTTP_HOST'].'/excel/农户销售记录导入模板.xlsx';
        $name_info = 'http://'.$_SERVER['HTTP_HOST'].'/excel/农户资料导入模板.xlsx';
        $this->assign([
            'order_info'=>$order_info,
            'name_info'=>$name_info,
        ]);
        return $this->fetch();
    }

    /**
     * 添加产销
     * @return mixed|\think\response\Json
     */
    public function levelAdd()
    {
        $param = input('post.');
        unset($param['file']);

        $level = new LevelModel();
        $flag = $level->insertLevel($param);

        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    /**
     * 编辑产销
     * @return mixed|\think\response\Json
     */
    public function levelEdit()
    {
        $param = input('post.');
        unset($param['file']);

        $level = new LevelModel();
        $flag = $level->editLevel($param);

        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    /**
     * 删除产销
     * @return mixed|\think\response\Json
     */
    public function levelDel()
    {
        $id = input('param.id');

        $role = new LevelModel();
        $flag = $role->delLevel($id);
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    /**
     * 导入
     */
    public function excelData(){
        //文件检测
        $file = $_FILES['file'];
        if ($file['error'] == 4){
            $this->error('请选择上传excel文件');
        }
        $file_types = explode ( ".", $file['name'] );
        $excel_type = array('xlsx');
        if (!in_array(strtolower(end($file_types)),$excel_type)){
         $this->error("仅xlsx格式的Excel文件，请重新上传");
        }
        $parm = input('');
        if($parm['types']&&!in_array($parm['types'],[3,4])){
            $this->error("上传不合法！");
        }
        //上传
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'upload/excel');
        if ($info) {
            $src = 'upload' . '/excel/' . date('Ymd') . '/' . $info->getFilename();
            $excel = new Office();
            //读取EXCEL表数据
            if($parm['types']==3){
                //农户资料
                $row = $excel->importExeclImg($src);
                $new_arr = [];
                unset($row[0]);
                foreach ($row as $k=>$v){
                    $new_arr[$k]['type_id'] = $parm['pid'];
                    $new_arr[$k]['name'] = $v[0];
                    $new_arr[$k]['level'] = $parm['types'];
                    $new_arr[$k]['yield'] = $v[2];
                    $new_arr[$k]['sales'] = $v[3];
                    $new_arr[$k]['is_menu'] = 2;
                    $new_arr[$k]['num'] = $v[1];
                    $new_arr[$k]['linkurl'] = $v[4];
                    $new_arr[$k]['imgurl'] = $v[5];
                    $new_arr[$k]['imgurls'] = $v[6];
                    $new_arr[$k]['sort'] = 0;
                    $new_arr[$k]['update_time'] = time();
                }
                //新增数据
                $filed_key = ['type_id','name','level','yield','sales','is_menu','num','linkurl','imgurl','imgurls','sort','update_time'];
                $data_add = batch_update_or_insert_sql('pq_level',$filed_key,$new_arr,$filed_key);
                if(!empty($data_add)){
                    foreach ($data_add as $k=>$v){
                        Db::query($v);
                    }
                }
            }
            if($parm['types']==4){
                //农户销售记录
                $row = $excel->importExecl($src);
                $new_arr = [];
                unset($row[1]);
                foreach ($row as $k=>$v){
                    $new_arr[$k]['l_id'] = $parm['pid'];
                    $new_arr[$k]['buyer'] = $v['A'];
                    $new_arr[$k]['sold_to'] = $v['C'];
                    $new_arr[$k]['order_num'] = $v['B'];
                    $new_arr[$k]['sales_time'] = strtotime(gmdate('Y-m-d', ($v['D'] - 25569) * 86400));
                    $new_arr[$k]['update_time'] = time();
                }
                //新增数据
                $filed_key = ['l_id','buyer','sold_to','order_num','sales_time','update_time'];
                $data_add = batch_update_or_insert_sql('pq_sales',$filed_key,$new_arr,$filed_key);
                if(!empty($data_add)){
                    foreach ($data_add as $k=>$v){
                        Db::query($v);
                    }
                }
            }

            return json(msg(1, '', '导入数据成功'));
        } else {
            // 上传失败获取错误信息
            return json(msg(-1, '', $file->getError()));
        }
    }


}