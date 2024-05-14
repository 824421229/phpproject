<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>后台管理</title>
  <link rel="stylesheet" href="./layui/css/layui.css">
  <script src="./layui/layui.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
    }

    body,
    html {
      height: 100%;
    }

    .layui-nav {
      border-radius: 0px;
    }

    .main {
      display: flex;
      height: calc(100% - 60px);
    }

    .main_content {
      flex: 1;
    }

    .layui-nav {
      margin-right: 0px !important;
    }

    #mainIf {
      width: 100%;
      height: 100%;
      display: block;
    }

    .top {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  </style>
</head>

<?php
session_start();

$admin_id = $_SESSION['admin_id'];

?>

<script>
  var admin_id = '<?php echo $admin_id ?>'
  if (!admin_id) {
    location.href = './login.php'
  }
</script>

<body>
  <ul class="layui-nav top" lay-bar="disabled">
    <h2>后台管理</h2>
    <li class="layui-nav-item" lay-unselect="">
      <a href="javascript:;"><img src="../public/header/11.png" class="layui-nav-img"></a>
      <dl class="layui-nav-child">
        <dd style="text-align: center;" id="out"><a href="javascript:;">退出登录</a></dd>
      </dl>
    </li>
  </ul>

  <div class="main">
    <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="demo" style="margin-right: 10px;">
      <li class="layui-nav-item layui-this"><a href="javascript:;" data-href="./views/main.php">首页</a></li>
      <li class="layui-nav-item ">
        <a href="javascript:;">文章管理</a>
        <dl class="layui-nav-child">
          <dd><a href="javascript:;" data-href="./views/post/check.php">审核文章</a></dd>
          <dd><a href="javascript:;" data-href="./views/post/pass.php">已通过文章</a></dd>
          <dd><a href="javascript:;" data-href="./views/post/report.php">被举报的文章</a></dd>
          <dd><a href="javascript:;" data-href="./views/post/sold.php">下架的文章</a></dd>
        </dl>
      </li>

      <li class="layui-nav-item ">
        <a href="javascript:;">后台系统管理</a>
        <dl class="layui-nav-child">
          <dd><a href="javascript:;" data-href="./views/system/ad.php">广告管理</a></dd>
          <dd><a href="javascript:;" data-href="./views/system/user.php">后台人员管理</a></dd>
        </dl>
      </li>
    </ul>
    <div class="main_content">
      <iframe src="./views/main.php" frameborder="0" id="mainIf"></iframe>
    </div>
  </div>
</body>
<script>
  layui.use(function() {
    var $ = layui.$
    $('.layui-nav-tree').on('click', 'a', function() {
      var href = $(this).attr('data-href')
      if (href) {
        $('#mainIf').attr({
          src: href
        })
      }
    })

    $('#out').on('click', function() {
      $.ajax({
        url: './api/out.php',
        success: function(res) {
          location.reload()
        }
      })
    })
  })
</script>

</html>
