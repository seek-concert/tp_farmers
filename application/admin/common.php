<?php
/**
 * 生成操作按钮
 * @param array $operate 操作按钮数组
 * @return string
 */
function showOperate($operate = [])
{
    if(empty($operate)){
        return '';
    }
    $option = '';
    foreach($operate as $key=>$vo){
        if(authCheck($vo['auth'])){
            $option .= ' <a href="' . $vo['href'] . '"><button type="button" class="btn btn-' . $vo['btnStyle'] . ' btn-sm">'.
                '<i class="' . $vo['icon'] . '"></i> ' . $key . '</button></a>';
        }
    }
    return $option;
}

/**
 * 将字符解析成数组
 * @param $str
 * @return array
 */
function parseParams($str)
{
    $arrParams = [];
    parse_str(html_entity_decode(urldecode($str)), $arrParams);
    return $arrParams;
}

/**
 * 子孙树 用于菜单整理
 * @param $param
 * @param int $pid
 * @return array
 */
function subTree($param, $pid = 0)
{
    static $res = [];
    foreach($param as $key=>$vo){

        if( $pid == $vo['pid'] ){
            $res[] = $vo;
            subTree($param, $vo['id']);
        }
    }

    return $res;
}

/**
 * 整理菜单住方法
 * @param $param
 * @return array
 */
function prepareMenu($param)
{
    $param = objToArray($param);
    $parent = []; //父类
    $child = [];  //子类

    foreach($param as $key=>$vo){

        if(0 == $vo['type_id']){
            $vo['href'] = '#';
            $parent[] = $vo;
        }else{
            $vo['href'] = url($vo['control_name'] .'/'. $vo['action_name']); //跳转地址
            $child[] = $vo;
        }
    }

    foreach($parent as $key=>$vo){
        foreach($child as $k=>$v){

            if($v['type_id'] == $vo['id']){
                $parent[$key]['child'][] = $v;
            }
        }
    }
    unset($child);

    return $parent;
}

/**
 * 解析备份sql文件
 * @param $file
 * @return array
 */
function analysisSql($file)
{
    // sql文件包含的sql语句数组
    $sqls = array ();
    $f = fopen ( $file, "rb" );
    // 创建表缓冲变量
    $create = '';
    while ( ! feof ( $f ) ) {
        // 读取每一行sql
        $line = fgets ( $f );
        // 如果包含空白行，则跳过
        if (trim ( $line ) == '') {
            continue;
        }
        // 如果结尾包含';'(即为一个完整的sql语句，这里是插入语句)，并且不包含'ENGINE='(即创建表的最后一句)，
        if (! preg_match ( '/;/', $line, $match ) || preg_match ( '/ENGINE=/', $line, $match )) {
            // 将本次sql语句与创建表sql连接存起来
            $create .= $line;
            // 如果包含了创建表的最后一句
            if (preg_match ( '/ENGINE=/', $create, $match )) {
                // 则将其合并到sql数组
                $sqls [] = $create;
                // 清空当前，准备下一个表的创建
                $create = '';
            }
            // 跳过本次
            continue;
        }

        $sqls [] = $line;
    }
    fclose ( $f );

    return $sqls;
}

/**
 * 统一返回信息
 * @param $code
 * @param $data
 * @param $msg
 * @return array
 */
function msg($code, $data, $msg)
{
    return compact('code', 'data', 'msg');
}

/**
 * 对象转换成数组
 * @param $obj
 * @return mixed
 */
function objToArray($obj)
{
    return json_decode(json_encode($obj), true);
}

/**
 * 权限检测
 * @param $rule
 * @return bool
 */
function authCheck($rule)
{
    $control = explode('/', $rule)['0'];
    if(in_array($control, ['login', 'index'])){
        return true;
    }

    if(in_array($rule, session('action'))){
        return true;
    }

    return false;
}

/**
 * 整理出tree数据 ---  layui tree
 * @param $pInfo
 * @param bool $spread
 * @return array
 */
function getTree($pInfo, $spread = true)
{

    $res = [];
    $tree = [];
    //整理数组
    foreach($pInfo as $key=>$vo){
        if($spread){
            $vo['spread'] = true;  //默认展开
        }
        $res[$vo['id']] = $vo;
        $res[$vo['id']]['children'] = [];
    }
    unset($pInfo);

    //查找子孙
    foreach($res as $key=>$vo){
        if(0 != $vo['pid']){
            $res[$vo['pid']]['children'][] = &$res[$key];
        }
    }

    //过滤杂质
    foreach( $res as $key=>$vo ){
        if(0 == $vo['pid']){
            $tree[] = $vo;
        }
    }
    unset( $res );

    return $tree;
}

/**
 * 整理出tree数据 ---  layui tree
 * @param $pInfo
 * @param bool $spread
 * @return array
 */
function getTrees($pInfo, $spread = true)
{

    $res = [];
    $tree = [];
    //整理数组
    foreach($pInfo as $key=>$vo){
        if($spread){
            $vo['spread'] = true;  //默认展开
        }
        $res[$vo['id']] = $vo;
        $res[$vo['id']]['children'] = [];
    }
    unset($pInfo);

    //查找子孙
    foreach($res as $key=>$vo){
         if(0 != $vo['pid']){
            $res[$vo['pid']]['children'][$key] = &$res[$key];
             $new_val = &$res[$key];
             $res[$vo['pid']]['children'][$key]['names'] = $new_val['name'];
             $res[$vo['pid']]['children'][$key]['name'] = $new_val['name'].'【产量:'.$new_val['yield'].' 销量:'.$new_val['sales'].'】';
             sort($res[$vo['pid']]['children']);
        }else{
             $res[$key]['name'] = $vo['name'].'【产量:'.$vo['yield'].' 销量:'.$vo['sales'].'】';
             $res[$key]['names'] = $vo['name'];
         }
    }

    //过滤杂质
    foreach( $res as $key=>$vo ){
        if(0 == $vo['pid']){
            $tree[] = $vo;
        }
    }

    unset( $res );

    return $tree;
}

/**
 * Excel导入
 * @param string $file excel文件
 * @param int $sheet
 * @return array 返回解析数据
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Reader_Exception
 */
function importExecl($file=''){
    // 判断文件是什么格式
    $type = pathinfo($file);
    $type = strtolower($type["extension"]);
    $type=$type==='csv' ? $type : 'Excel5';
    ini_set('max_execution_time', '0');
    // 判断使用哪种格式
    $objReader = PHPExcel_IOFactory::createReader($type);
    $objPHPExcel = $objReader->load($file);
    $sheet = $objPHPExcel->getSheet(0);
    // 取得总行数
    $highestRow = $sheet->getHighestRow();
    // 取得总列数
    $highestColumn = $sheet->getHighestColumn();
    //循环读取excel文件,读取一条,插入一条
    $data=array();
    //从第二行开始读取数据
    for($j=2;$j<=$highestRow;$j++){
        //从A列读取数据
        for($k='A';$k<=$highestColumn;$k++){
            // 读取单元格
            $data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
        }
    }
    return $data;
}



