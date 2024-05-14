<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../layui/css/layui.css">
  <script src="../../layui/layui.js"></script>

  <style>
    .box {
      padding: 20px;
    }
  </style>
</head>

<?php
require '../../config/database.php';
$id = $_GET['id'];

$sql = "SELECT * FROM `admin` WHERE id = $id";
$admin_info = mysqli_query($connID, $sql);
$admin_info = mysqli_fetch_array($admin_info);
?>

<body class="box">
  <form class="layui-form" action="">
    <div class="layui-form-item">
      <label class="layui-form-label">账户</label>
      <div class="layui-input-block">
        <input type="text" name="account" required lay-verify="required" placeholder="请输入账户" autocomplete="off" class="layui-input" value="<?php echo $admin_info['account'] ?>">
      </div>
    </div>
    <?php if (!$id) {  ?>
      <div class="layui-form-item">
        <label class="layui-form-label">密码框</label>
        <div class="layui-input-inline">
          <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">辅助文字</div>
      </div>
    <?php } ?>
    <div class="layui-form-item">
      <label class="layui-form-label">名称</label>
      <div class="layui-input-block">
        <input type="text" name="admin_user" required lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input" value="<?php echo $admin_info['admin_user'] ?>">
      </div>
    </div>
    <div class="layui-form-item">
      <label class="layui-form-label">手机号</label>
      <div class="layui-input-block">
        <input type="text" name="phone" required lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input" value="<?php echo $admin_info['phone'] ?>">
      </div>
    </div>

    <div class="layui-form-item">
      <div class="layui-input-block">
        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
      </div>
    </div>
  </form>
</body>

<script>
  //Demo
  layui.use(function() {
    var form = layui.form;
    var $ = layui.$

    //提交
    form.on('submit(formDemo)', function(data) {
      var form_data = data.field
      var id = "<? echo $id ?>"
      if (id) {
        form_data['id'] = id
        $.ajax({
          url: '../../api/update_admin.php',
          data: form_data,
          type: 'POST',
          success: function(res) {
            if (res.code === 200) {
              layer.msg('修改成功')
            } else if (res.code === 250) {
              layer.msg('系统异常')
            } else {
              layer.msg(res.msg)
            }
          }
        })
      } else {
        $.ajax({
          url: '../../api/add_admin.php',
          data: form_data,
          type: 'POST',
          success: function(res) {
            if (res.code === 200) {
              layer.msg('人员添加成功')
            } else if (res.code === 250) {
              layer.msg('系统异常')
            } else {
              layer.msg(res.msg)
            }
          }
        })
      }
      return false;
    });
  });
</script>

</html>