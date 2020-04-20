<?php
/**
 * 工具
 */
namespace app\admin\controller;
use think\Controller;

class Tool extends Controller
{
    /**
     * 上传图片
     * @return bool|\think\response\Json
     */
    public function uploadImg()
    {
        if (request()->isAjax()) {
            $file = request()->file('file');
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload/imgs');
            if ($info) {
                $src = '/upload' . '/imgs/' . date('Ymd') . '/' . $info->getFilename();
                return json(msg(0, ['src' => $src], ''));
            } else {
                // 上传失败获取错误信息
                return json(msg(-1, '', $file->getError()));
            }
        }
        return false;
    }
}