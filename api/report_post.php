<?php
session_start();

require '../config/database.php';
require '../config/result.php';

$user_id = $_SESSION['user_id'];

$post_id = $_POST['post_id'];
$text = $_POST['text'];

$sql = "INSERT INTO post_report (`user_id`,`text`,`post_id`)
VALUE ('$user_id','$text','$post_id')";
$result = mysqli_query($connID, $sql);
if (mysqli_error($connID)) {
  resCode(mysqli_error($connID), 250);
}

resCode();
