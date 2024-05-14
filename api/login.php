<?php
session_start();

require '../config/database.php';
require '../config/result.php';

$account = $_POST['account'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM `user` WHERE `account` = '$account'";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_array($result);
if (empty($result)) {
  resCode('用户账号不存在!', 201);
}
if ($result['password'] != $password) {
  resCode('用户密码错误!', 201);
}

$_SESSION['user_id'] = $result['id'];
$_SESSION['user_info'] = $result;

resCode('登录成功');
