<?php
session_start();

require '../config/database.php';
require '../config/result.php';

$user_id = $_SESSION['user_id'];

if(!$user_id) {
  resCode('请先登录',201);
}

$post_id = $_POST['post_id'];
$post_user_id = $_POST['post_user_id'];

$sql = "SELECT * FROM post_give WHERE give_user_id = '$user_id' AND 	post_id = '$post_id'";
$result = mysqli_query($connID,$sql);
$result = mysqli_fetch_array($result);

$error = mysqli_error($connID);
if($error) {
  resCode($error,250);
}

// 添加点赞记录
if(!$result) {
  $sql = "INSERT INTO post_give (	give_user_id,post_id,post_user_id) VALUE ('$user_id','$post_id','$post_user_id')";
  $result = mysqli_query($connID,$sql);
  if(empty($result)) {
    resCode(mysqli_error($connID),250);
  }
  resCode('点赞成功');
}

// 点赞取消，删除点赞记录
$id = $result['id'];
$sql = "DELETE FROM post_give WHERE id='$id'";
$result = mysqli_query($connID,$sql);
if(empty($result)) {
  resCode(mysqli_error($connID),250);
}
resCode('取消点赞成功');
