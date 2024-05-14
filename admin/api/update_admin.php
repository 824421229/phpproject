<?php

require '../config/database.php';
require '../config/result.php';

$id = $_POST['id'];
$account = $_POST['account'];
$admin_user = $_POST['admin_user'];
$phone = $_POST['phone'];

$sql = "UPDATE `admin` SET account='$account',admin_user='$admin_user',phone='$phone' WHERE id = $id";
$result = mysqli_query($connID,$sql);

resCode('修改成功');