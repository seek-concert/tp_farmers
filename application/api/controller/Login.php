<?php
/**
 * 注册登陆接口
 */
namespace app\api\controller;
use app\api\model\VipModel;
use think\Controller;
use \Exception;

class Login extends Controller
{
    /**
     * 注册
     * @return array|\think\response\Json
     * @throws Exception
     */
    public function reg()
    {
        try {
            //接收数据
            $data = input('post.');
            //验证数据
            $result = $this->validate($data, 'RegValidate');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return msg(0, $result);
            }
            //实例化模型
            $vip = new VipModel();
            //判断openid是否存在
            $vip_id = $vip->where(['openid' => $data['openid']])->value('id');
            if (!empty($vip_id)) {
                return msg(0, '已注册！');
            }
            //存入数据库
            $row = [];
            $row['avatar'] = $data['avatar'];
            $row['name'] = $data['name'];
            $row['openid'] = $data['openid'];
            $row['input_time'] = time();
            $vip->data($row);
            $list = $vip->save();
            if ($list) {
                return msg(1, '注册成功！', ['vip_id' => $vip->id]);
            } else {
                return msg(0, '注册失败！');
            }
        } catch (Exception $e) {
            throw new Exception();
        }
    }

    /**
     * 登录
     * @return array|\think\response\Json
     * @throws Exception
     */
    public function login()
    {
        try {
            //接收数据
            $data = input('post.');
            //验证数据
            $result = $this->validate($data, 'LoginValidate');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return msg(0, $result);
            }
            //实例化模型
            $vip = new VipModel();
            $list = $vip->where(['openid' => $data['openid']])->find();
            if ($list) {
                return msg(1, '登录成功！', ['vip_id' => $list['id']]);
            } else {
                return msg(0, '登录失败,用户不存在！');
            }
        } catch (Exception $e) {
            throw new Exception();
        }
    }
}