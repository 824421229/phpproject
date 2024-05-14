<?php
// 注册接口
require '../config/database.php';
require '../config/result.php';

$uname = $_POST['uname'];
$phone = $_POST['phone'];
$account = $_POST['account'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM `user` WHERE `uname`='$uname'";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_array($result);
if ($result) {
  resCode('用户名称已存在', 201);
}

$sql = "SELECT * FROM `user` WHERE `phone`='$phone'";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_array($result);
if ($result) {
  resCode('手机号已存在', 201);
}

$sql = "SELECT * FROM `user` WHERE `account`='$account'";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_array($result);
if ($result) {
  resCode('账号已存在', 201);
}

$sql1 = "INSERT INTO `user` (`uname`,`phone`,`account`,`password`) VALUE ('$uname','$phone','$account','$password')";
$result = mysqli_query($connID, $sql1);
if (!$result) {
  resCode(mysqli_error($connID), 250);
}


resCode('注册成功');
