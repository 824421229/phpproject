<?php

require '../config/database.php';
require '../config/result.php';

$page = $_GET['page'];
$limit = $_GET['limit'];
$start = ($page - 1) * $limit;

$sql = "SELECT 
post_report.* , post_report.id as post_report_id ,
post.* , post.id as post_id,
post_type.name as post_type_name
FROM post_report 
JOIN post ON post.id = post_report.post_id
JOIN post_type ON post_type.id = post.post_type_id
LIMIT $start,$limit";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT count(*) as c FROM post_report";
$count = mysqli_query($connID, $sql);
$count = mysqli_fetch_array($count, MYSQLI_ASSOC);

resCodeWithData(['list' => $result, 'count' => $count['c']]);
