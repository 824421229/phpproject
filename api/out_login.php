<?php
session_start();
require '../config/result.php';

session_destroy();

resCode('退出成功');
