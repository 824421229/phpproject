<?php
require '../config/result.php';

$file = $_FILES['file'];

if ($file) {
  $ext = strchr($file['name'], '.');
  $fielNmae = date('YmdHis') . rand(100, 999) . $ext;
  $fielPath = '/public/ad_img/' . $fielNmae;
  move_uploaded_file($file['tmp_name'], '../..' . $fielPath);

  resCode($fielPath);
}

resCode('操作不当', 201);
