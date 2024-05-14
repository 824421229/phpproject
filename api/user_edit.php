<?php
session_start();
// 修改用户资料

require '../config/database.php';
require '../config/result.php';

$user_id = $_SESSION['user_id'];
$uname = $_POST['uname'];
$phone = $_POST['phone'];
$sign = $_POST['sign'];
$file = $_FILES['file'];



$sql = "UPDATE user SET `uname` = '$uname' , `phone` = '$phone', `sign` = '$sign' WHERE `id` = '$user_id'";
$result = mysqli_query($connID, $sql);

if (empty($result)) {
  resCode(mysqli_error($connID), 250);
}


if ($file) {
  $ext = strchr($file['name'], '.');
  $fielNmae = date('YmdHis') . rand(100, 999) . $ext;
  $fielPath = '/public/header/' . $fielNmae;
  move_uploaded_file($file['tmp_name'], '..' . $fielPath);

  $sql = "UPDATE user SET `header` ='$fielPath' WHERE `id` = $user_id ";
  $result = mysqli_query($connID, $sql);
  if (empty($result)) {
    resCode(mysqli_error($connID), 250);
  }
}

$sql = "SELECT * FROM `user` WHERE `id` = '$user_id'";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_array($result);
$_SESSION['user_info'] = $result;

resCode();
