<?php
/**
 * 统一返回信息
 * @param $status
 * @param $msg
 * @param string $data
 * @param int $code
 * @return \think\response\Json
 */
function msg($status,$msg,$data='',$code=200){
    return json(['status'=>$status,'message'=>$msg,'data'=>$data],$code);
}

