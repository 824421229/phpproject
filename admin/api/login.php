<?php
session_start();

require '../config/database.php';
require '../config/result.php';

$account = $_POST['account'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM `admin` WHERE account = '$account' AND `password` = '$password'";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_array($result);

if (!$result) {
  resCode('账号或者密码出错', 201);
}

$_SESSION['admin_id'] = $result['id'];
$_SESSION['admin_info'] = $result;


resCode('登录成功');
