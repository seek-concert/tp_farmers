<?php
/**
 * 登陆验证器
 */
namespace app\admin\validate;
use think\Validate;

class LoginValidate extends Validate
{
    protected $rule = [
        ['userName', 'require', '账号不能为空！'],
        ['password', 'require', '密码不能为空！'],
        ['code', 'require', '验证码不能为空！']
    ];

}