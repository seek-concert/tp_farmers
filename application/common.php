<?php
/**
 * 公用函数
 */
/** 批量 更新或插入数据的sql
 * @param string $table 数据表名
 * @param array $insert_columns 数据字段
 * @param array $values 原始数据
 * @param array|string $update_columns 更新字段
 * @return bool|array  返回false(条件不符)，返回array(sql语句)
 */
function batch_update_or_insert_sql($table = '', $insert_columns = [], $values = [], $update_columns = [])
{
    if (empty($table) || empty($insert_columns) || empty($values) || empty($update_columns)) {
        return false;
    }
    // 数据字段必须包含更新字段
    if (is_string($update_columns)) {
        if (!in_array($update_columns, $insert_columns)) {
            return false;
        }
    } else {
        $common_columns = array_intersect($insert_columns, $update_columns);
        sort($common_columns);
        sort($update_columns);
        if ($common_columns != $update_columns) {
            return false;
        }
    }

    //数据字段
    $sql_insert_columns = [];
    foreach ($insert_columns as $insert_column) {
        $sql_insert_columns[] = '`' . $insert_column . '`';
    }
    $sql_insert_columns = implode(',', $sql_insert_columns);
    //数据分页
    $num = 100;
    $page_values = [];
    foreach ($values as $k => $value) {
        $p = ceil(($k + 1) / $num);
        $temp_values = [];
        foreach ($insert_columns as $insert_column) {
            $temp = (string)$value[$insert_column] or '';
            $temp_values[] = "'" . $temp . "'";
        }
        $temp_values = implode(',', $temp_values);
        $page_values[$p][] = '(' . $temp_values . ')';
    }
    //更新字段
    if (is_string($update_columns)) {
        $sql_update_columns = ' `' . $update_columns . '` = values(`' . $update_columns . '`) ';
    } else {
        $sql_update_columns = [];
        foreach ($update_columns as $update_column) {
            $sql_update_columns[] = ' `' . $update_column . '` = values(`' . $update_column . '`) ';
        }
        $sql_update_columns = implode(',', $sql_update_columns);
    }
    // 生成sql
    $sqls = [];
    foreach ($page_values as $p => $value) {
        $sql_values = implode(',', $value);
        $sqls[] = 'insert into `' . $table . '` (' . $sql_insert_columns . ') values ' . $sql_values . ' on duplicate key update ' . $sql_update_columns;
    }

    return $sqls;
}
