<?php
// 数据库配置文件
// 关闭报错等级
error_reporting(5);

// 声明数据库需要的信息
$data_host = '127.0.0.1';
$data_name = 'root';
$data_pwd = 'root';
$dbname = 'test';

// 链接数据库
$connID = mysqli_connect($data_host, $data_name, $data_pwd, $dbname);

if (mysqli_connect_errno($connID)) {
  print_r( '数据库链接失败了' . mysqli_connect_errno());
  exit;
}
