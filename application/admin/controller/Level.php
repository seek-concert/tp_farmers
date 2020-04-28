<?php
/**
 * 产销管理
 */
namespace app\admin\controller;
use app\admin\model\LevelModel;

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

        return $this->fetch();
    }

    /**
     * 添加产销
     * @return mixed|\think\response\Json
     */
    public function levelAdd()
    {
        $param = input('post.');

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
        $file = $_FILES['file'];
        if ($file['error'] == 4){
            $this->error('请选择上传excel文件');
        }
        $file_types = explode ( ".", $file['name'] );
        $excel_type = array('xls','csv','xlsx');
        if (!in_array(strtolower(end($file_types)),$excel_type)){
         $this->error("不是Excel文件，请重新上传");
        }
//        dump($file);dump(111);
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'upload/excel');
        if ($info) {
            $src = '/upload' . '/excel/' . date('Ymd') . '/' . $info->getFilename();
        } else {
            // 上传失败获取错误信息
            return json(msg(-1, '', $file->getError()));
        }
//        dump($file);
//        $data = importExecl(ROOT_PATH.'/public/'.$src);
        $excel_class = new Excels();
        $data = $excel_class->excel_import(ROOT_PATH.'/public/'.$src);
//        dump($data);
//        Loader::import('PHPExcel.PHPExcel');
//        Loader::import('PHPExcel.PHPExcel.PHPExcel_IOFactory');
//        Loader::import('PHPExcel.PHPExcel.PHPExcel_Cell');
//
//        //从前台获取excel文件
//        $file = request()->file('file');
//
//        //上传该文件
//        $path = ROOT_PATH . 'public' . DS . 'imgs' . DS;
//        $info = $file->move(ROOT_PATH . 'public' . DS . 'imgs'. DS);//上传位置
//        if($info){
//            echo '文件上传成功'.'<br/>';
//        }
//        else{
//            echo '文件上传失败'.'<br/>';
//        }
//
//        //上传后的EXCEL路径
//        $file_path = $path . $info->getSaveName();
//
//        //设置一个存放图片的路径
//        $imgPath = ROOT_PATH . 'public' . DS . 'imgs'. DS;
//        if(!file_exists($imgPath)){
//            mkdir($imgPath);
//        }
//
//        //获取文件后缀：xls、xlsx等
//        $extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION) );
//        //加上这个判断的目的就是防止报错，但目前只支持Excel5
//        if($extension =='xls'){
//            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
//        }else{
//            $objReader = \PHPExcel_IOFactory::createReader('excel2007');
//        }
//
//        //载入文件
//        $filenames=[];
//        $objPHPExcel = $objReader->load($file_path);
//        foreach ($objPHPExcel->getSheet(0)->getDrawingCollection() as $k => $drawing) {
//            $codata = $drawing->getCoordinates(); //得到单元数据 比如G2单元
//            $filename = $drawing->getIndexedFilename();  //文件名
//
//            //如果多张图片，就存入数组
//            $filenames[]=$imgPath.'123'.$filename;
//            echo $filename."<br/>";
//            ob_start();
//            call_user_func(
//                $drawing->getRenderingFunction(),
//                $drawing->getImageResource()
//            );
//            $imageContents = ob_get_contents();
//            file_put_contents($imgPath.'123'.$filename,$imageContents); //把图片保存到本地（上方自定义的路径）
//            ob_end_clean();
//            dump(123323121);
//            dump($imgPath.'123'.$filename,$imageContents);
//        }
//        print_r($filenames);
//        die;

die;
    }


}