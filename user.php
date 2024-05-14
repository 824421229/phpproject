<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>个人中心</title>

  <link rel="stylesheet" href="./style/common.css">
  <link rel="stylesheet" href="./style/user.css">

  <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./js/common.js"></script>
</head>

<body>
  <?php
  require './config/database.php';

  require './common/top.php';

  $user_id = $_SESSION['user_id'];
  $user_info = $_SESSION['user_info'];

  $status = $_GET['status'];

  if (empty($status) && $status  != '0') {
    $sql = "SELECT post.*, post_type.name as post_type_name , user.uname  FROM `post` 
  JOIN `post_type` ON post.post_type_id = post_type.id
  JOIN `user` ON post.user_id = user.id
  WHERE `user_id` = '$user_id' AND `delete_time` is null";
  } elseif ($status != 99) {
    $sql = "SELECT post.*, post_type.name as post_type_name , user.uname  FROM `post` 
    JOIN `post_type` ON post.post_type_id = post_type.id
    JOIN `user` ON post.user_id = user.id
    WHERE `user_id` = '$user_id' AND `delete_time` is null AND post.status = '$status'";
  } else {
    $sql = "SELECT post_id FROM post_give WHERE give_user_id = '$user_id'";
    $post_ids = mysqli_query($connID, $sql);
    $post_ids = mysqli_fetch_all($post_ids, MYSQLI_ASSOC);
    $ids = '';
    foreach ($post_ids as $item) {
      if ($ids) {
        $ids = $ids . ',' . $item['post_id'];
      } else {
        $ids = $item['post_id'];
      }
    }

    $sql = "SELECT post.*, post_type.name as post_type_name , user.uname  FROM `post` 
    JOIN `post_type` ON post.post_type_id = post_type.id
    JOIN `user` ON post.user_id = user.id
    WHERE `user_id` = '$user_id' AND `delete_time` is null AND post.id IN ($ids)";
  }

  $post_list = mysqli_query($connID, $sql);
  $post_list = mysqli_fetch_all($post_list, MYSQLI_ASSOC);

  $sql = "SELECT count(*) FROM post_give WHERE post_user_id = '$user_id'";
  $count = mysqli_query($connID, $sql);
  $count = mysqli_fetch_array($count);
  ?>

  <div class="content">
    <div class="user">
      <div class="left">
        <img src="<?php echo $user_info['header'] ?>" alt="" class="hander">
        <div class="user_info">
          <div class="name"><?php echo $user_info['uname'] ?></div>
          <div class="sign"><?php echo $user_info['sign'] ?></div>
        </div>
      </div>
      <div class="right">
        <div class="give">
          获赞数量 <?php echo $count['count(*)'] ?>
        </div>
        <button class="edit_user_info">编辑个人资料</button>
      </div>
    </div>
    <div class="post_box">
      <div class="nav">
        <div class="item <?php if (empty($status) && $status != '0') {
                            echo 'active';
                          } ?>">全部文章</div>
        <div class="item <?php if ($status == '2') {
                            echo 'active';
                          } ?>" data-status="2">已发布</div>
        <div class="item <?php if ($status == '1') {
                            echo 'active';
                          } ?>" data-status="1">审核中</div>
        <div class="item <?php if ($status == '0') {
                            echo 'active';
                          } ?>" data-status="0">草稿</div>
        <div class="item <?php if ($status == '99') {
                            echo 'active';
                          } ?>" data-status="99">赞</div>
      </div>

      <div class="content-list">
        <?php for ($i = 0; $i < count($post_list); $i++) {
          $item = $post_list[$i];
        ?>
          <a href="./post_details.php?id=<?php echo $item['id'] ?>">
            <div class="item">
              <div class="left">
                <div class="item-tag">
                  <span><?php echo $item['uname'] ?></span>
                  <span><?php echo $item['create_time'] ?></span>
                  <span><?php echo $item['post_type_name'] ?></span>
                </div>
                <div class="title"><?php echo $item['title'] ?></div>
                <div class="item-inco"><?php echo $item['html_text'] ?></div>
                <div class="data-number">
                  <div class="look">预览</div>
                  <div class="give">点赞</div>
                  <div class="valuate">评论</div>
                </div>
              </div>
              <?php if ($item['img']) { ?>
                <div class="right">
                  <img src="<?php echo $item['img'] ?>" alt="">
                </div>
              <?php } ?>
            </div>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="edit_user_box">
    <div class="edit_user">
      <div class="edit_title">
        <div class="title">编辑个人资料</div>
        <div class="close">关闭</div>
      </div>
      <form action="#" class="edit_form">
        <img src="<?php echo $_SESSION['user_info']['header'] ?>" alt="" class="hander">
        <input type="file" class="header_file">
        <div class="item">
          <label for="uname">用户名称：</label>
          <input id="uname" type="text" name="uname" placeholder="请输入用户名称" value="<?php echo $_SESSION['user_info']['uname'] ?>">
        </div>
        <div class="item">
          <label for="sign">个性签名：</label>
          <input id="sign" type="text" name="sign" placeholder="请输入个性签名" value="<?php echo $_SESSION['user_info']['sign'] ?>">
        </div>
        <div class="item">
          <label for="phone">手机号：</label>
          <input id="phone" type="text" name="phone" placeholder="请输入手机号" value="<?php echo $_SESSION['user_info']['phone'] ?>">
        </div>
        <button type="submit">保 存</button>
      </form>
    </div>
  </div>

</body>

<script>
  $(function() {
    $('.edit_user_info').on('click', function() {
      $('.edit_user_box').fadeIn()
    })
    $('.edit_title .close').on('click', function() {
      $('.edit_user_box').fadeOut()
    })

    var file = null
    $('.edit_form .hander').on('click', function() {
      console.log(123)
      $('.header_file').click()
    })
    $('.header_file').on('change', function() {
      file = this.files[0]
      $('.edit_form .hander').attr('src', URL.createObjectURL(file))
    })


    $('.edit_form').on('submit', function(e) {
      e.preventDefault()

      var formData = getFormData(this)

      var formObj = new FormData()

      if (file) {
        formObj.append('file', file)
      }
      formObj.append('uname', formData.uname)
      formObj.append('phone', formData.phone)
      formObj.append('sign', formData.sign)


      $.ajax({
        url: './api/user_edit.php',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formObj,
        success: function(res) {
          if (res.code === 200) {
            location.reload()
          } else if (res.code === 250) {
            alert('系统发生了错误，请联系管理员！')
          } else {
            alert(res.msg)
          }
        }
      })
    })

    $('.post_box .nav').on('click', '.item', function() {
      var status = $(this).attr('data-status') ?? ''
      location.href = './user.php?status=' + status
    })
  })
</script>

</html>