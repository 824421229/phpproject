<?php

require '../config/database.php';
require '../config/result.php';

$link = $_POST['link'];
$img = $_POST['img'];
$id = $_POST['id'];

$update_time = date('Y-m-d H:i:s');

$sql = "UPDATE ad SET `link`='$link', `img`='$img',`update_time`='$update_time' WHERE `id` = '$id'";
$result = mysqli_query($connID, $sql);
if (mysqli_error($connID)) {
  resCode(mysqli_error($connID), 250);
}

resCode("保存成功");
