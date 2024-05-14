<?php
session_start();

require '../config/database.php';
require '../config/result.php';

$discuss_user_id = $_SESSION['user_id'];

$discuss = $_POST['discuss'];
$post_id = $_POST['post_id'];

$sql = "INSERT INTO discuss (discuss_user_id,post_id,discuss) VALUE ('$discuss_user_id','$post_id','$discuss')";
$result = mysqli_query($connID, $sql);
if (empty($result)) {
  resCode(mysqli_error($connID), 250);
}

resCode('评论成功');
