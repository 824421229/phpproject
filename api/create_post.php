<?php
session_start();

require '../config/database.php';
require '../config/result.php';

$user_id = $_SESSION['user_id'];

$title = $_POST['title'];
$html = addslashes($_POST['html']);
$html_text = addslashes($_POST['html_text']);
$post_type_id = $_POST['post_type_id'];
$status = $_POST['status'];

$file = $_FILES['file'];

$id = $_POST['id'];

if ($id) {
  $sql = "UPDATE post SET title = '$title ',html='$html',html_text='$html_text',post_type_id='$post_type_id',`status`='$status' WHERE id = '$id'";
  $result = mysqli_query($connID, $sql);
  if (empty($result)) {
    resCode(mysqli_error($connID), 250);
  }
} else {
  $sql = "INSERT INTO `post` (`title`,`html`,`html_text`,`post_type_id`,`user_id`,`status`)  
  VALUE ('$title','$html','$html_text','$post_type_id','$user_id','$status')";
  $result = mysqli_query($connID, $sql);
  if (empty($result)) {
    resCode(mysqli_error($connID), 250);
  }
  $id = mysqli_insert_id($connID);
}



if ($file) {
  $ext = strchr($file['name'], '.');
  $fielNmae = date('YmdHis') . rand(100, 999) . $ext;
  $fielPath = '/public/post_img/' . $fielNmae;
  move_uploaded_file($file['tmp_name'], '..' . $fielPath);

  $sql = "UPDATE post SET `img` = '$fielPath' WHERE `id` = $id ";
  $result = mysqli_query($connID, $sql);
  if (empty($result)) {
    resCode(mysqli_error($connID), 250);
  }
}

if ($_POST['id']) {
  resCode('文章编辑成功');
} else {
  resCode('文章提交成功');
}
