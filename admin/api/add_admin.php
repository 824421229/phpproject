<?php

require '../config/database.php';
require '../config/result.php';

$account = $_POST['account'];
$password = md5($_POST['password']);
$admin_user = $_POST['admin_user'];
$phone = $_POST['phone'];

$sql = "SELECT * FROM `admin` WHERE account = '$account'";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_array($result);
if ($result) {
  resCode('账户已被注册', 201);
}

$sql = "INSERT INTO `admin` (account,`password`,admin_user,phone) 
VALUE ('$account','$password','$admin_user','$phone')";
$result = mysqli_query($connID, $sql);
if (mysqli_error($connID)) {
  resCode(mysqli_error($connID), 250);
}

resCode('添加成功');
