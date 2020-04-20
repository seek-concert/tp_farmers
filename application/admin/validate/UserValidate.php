<?php
/**
 * 管理员验证器
 */
namespace app\admin\validate;
use think\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        ['user_name', 'unique:user', '管理员已经存在']
    ];

}