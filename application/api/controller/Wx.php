<?php
/**
 * 微信
 */
namespace app\api\controller;
use think\Controller;
use \Exception;

class Wx extends Controller
{
    /**
     * 获取微信openID
     * @return array|\think\response\Json
     * @throws Exception
     */
    public function openid()
    {
        try {
            $appid = "wx816d0409e86139f3";
            $secret = "fa784c722ab3615525b0da898fe09b60";
            $code = input('post.code');
            $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $secret . '&js_code=' . $code . '&grant_type=authorization_code';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 500);
            // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。  
            // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。  
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_URL, $url);
            $res = curl_exec($curl);
            curl_close($curl);
            $json_obj = json_decode($res, true);
            if (array_key_exists("openid", $json_obj)) {
                return msg(1, '获取成功！', $json_obj["openid"]);
            } else {
                return msg(0, '获取失败！');
            }
        }catch (Exception $e){
            throw new Exception();
        }
    }

}