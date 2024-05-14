<?php

require '../config/database.php';
require '../config/result.php';

$id = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE post SET `status` = '$status' WHERE id = '$id'";
$result = mysqli_query($connID, $sql);
if (mysqli_error($connID)) {
  resCode(mysqli_error($connID), 250);
}

resCode();
