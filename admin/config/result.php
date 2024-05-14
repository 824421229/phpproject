<?php

/** code 介绍
 *   - 200 成功
 *   - 201 意料之中的错误，需要提示给用户
 *   - 250 数据库
 * 
 */
function resCode($msg = '操作成功', $code = 200)
{
  header('Content-Type:application/json');
  echo json_encode([
    'code' => $code,
    'msg' => $msg,
    'data' => []
  ]);
  exit;
}
function resCodeWithData($data = [], $msg = '操作成功', $code = 200)
{
  header('Content-Type:application/json');
  echo json_encode([
    'code' => $code,
    'msg' => $msg,
    'data' => $data
  ]);
  exit;
}
