<?php

require '../config/database.php';
require '../config/result.php';

$page = $_GET['page'];
$limit = $_GET['limit'];
$start = ($page - 1) * $limit;

$sql = "SELECT post.*,user.uname,post_type.name as post_type_name FROM post 
JOIN user ON post.user_id = user.id
JOIN post_type ON post.post_type_id = post_type.id
WHERE post.status = 1 LIMIT $start,$limit";
$result = mysqli_query($connID, $sql);
$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT count(*) as c FROM post WHERE `status` = 1";
$count = mysqli_query($connID, $sql);
$count = mysqli_fetch_array($count, MYSQLI_ASSOC);

resCodeWithData(['list' => $result, 'count' => $count['c']]);
