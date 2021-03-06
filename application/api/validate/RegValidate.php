<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\api\validate;

use think\Validate;

class RegValidate extends Validate
{
    protected $rule = [
        ['avatar', 'require', '头像不能为空'],
        ['name', 'require', '呢称不能为空'],
        ['openid', 'require', 'openid不能为空']
    ];

}