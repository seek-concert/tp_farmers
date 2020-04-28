<?php
/**
 * 验证器
 */
namespace app\admin\validate;
use think\Validate;

class LevelValidate extends Validate
{
    protected $rule = [
        ['type_id', 'require', '上级不能为空！'],
    ];

}