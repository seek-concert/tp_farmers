<?php
/**
 * 密码验证场景
 */
namespace app\admin\validate;
use think\Validate;

class CipherValidate extends Validate
{
    protected $rule = [
        ['used', 'require', '原密码不能为空'],
        ['password', 'require|confirm', '新密码不能为空|新密码与确认密码不一致']
    ];

}