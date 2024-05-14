<?php

require '../config/database.php';
require '../config/result.php';

$page = $_GET['page'];
$limit = $_GET['limit'];
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM `admin` LIMIT $start,$limit";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT count(*) as c FROM `admin`";
$count = mysqli_query($connID, $sql);
$count = mysqli_fetch_array($count, MYSQLI_ASSOC);

resCodeWithData(['list' => $result, 'count' => $count['c']]);