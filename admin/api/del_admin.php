<?php

require '../config/database.php';
require '../config/result.php';


$id = $_GET['id'];

$sql = "DELETE FROM `admin` WHERE id = $id ";
$result = mysqli_query($connID,$sql);

resCode('删除成功');