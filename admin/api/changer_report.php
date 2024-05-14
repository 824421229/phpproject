<?php

require '../config/database.php';
require '../config/result.php';

$id = $_GET['id'];

$sql = "UPDATE post_report SET is_edit = 1 WHERE id = '$id'";
$result = mysqli_query($connID, $sql);

resCode();
