<?php
/**
 * 公用函数
 */

/**
 * 对象转换成数组
 * @param object $obj
 * @return array
 */
function objToArray($obj)
{
    return json_decode(json_encode($obj), true);
}