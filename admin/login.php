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

    html,
    body {
      width: 100%;
      height: 100%;
      background: url('./img/login_bg.jpg') no-repeat center;
    }

    .login_box {
      width: 320px;
      background-color: #fff;
      position: fixed;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      border-radius: 20px;
      box-shadow: 0 0 10px #00000035;
    }

    h2 {
      margin-bottom: 5px;
    }
  </style>
</head>

<body>
  <div class="login_box">
    <h2>欢迎访问后台登录管理</h2>
    <form class="layui-form" action="">
      <div class="layui-form-item">
        <input type="text" name="account" required lay-verify="required" placeholder="请输入账号" autocomplete="off" class="layui-input">

      </div>
      <div class="layui-form-item">
        <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">

      </div>
      <div class="layui-form-item">
        <button class="layui-btn  layui-btn-normal layui-btn-fluid" lay-submit lay-filter="formDemo">登 录</button>
      </div>
    </form>

  </div>

</body>

<script>
  layui.use(function() {
    var form = layui.form;
    var $ = layui.$

    //提交
    form.on('submit(formDemo)', function(data) {
      $.ajax({
        url: './api/login.php',
        type: 'POST',
        data: data.field,
        success: function(res) {
          if (res.code !== 200) {
            layer.msg(res.msg, {
              icon: 5
            })
          } else {
            layer.msg(res.msg, {
              icon: 1
            })
            location.href = './index.php'
          }
        }
      })
      return false;
    });
  });
</script>

</html>