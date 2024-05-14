<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>文章详情</title>
  <link rel="stylesheet" href="./style/common.css">
  <link rel="stylesheet" href="./style/post_details.css">

  <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./js/common.js"></script>
</head>

<body>
  <?php
  require './config/database.php';

  require './common/top.php';

  $current_user_id = $_SESSION['user_id'];

  $post_id = $_GET['id'];
  $sql = "SELECT post.*,user.header as user_header,user.uname as user_uname, user.sign as user_sign
  FROM post 
  JOIN user ON post.user_id = user.id
  WHERE post.id = '$post_id'";
  $post_details = mysqli_query($connID, $sql);
  $post_details = mysqli_fetch_array($post_details);


  $sql = "SELECT * FROM post_give WHERE give_user_id = '$current_user_id' AND post_id = '$post_id'";
  $is_give_post = mysqli_query($connID, $sql);
  $is_give_post = mysqli_fetch_array($is_give_post);

  $sql = "SELECT discuss.*,user.uname,user.sign,user.header FROM discuss
  JOIN user ON discuss.discuss_user_id = user.id
  WHERE post_id = '$post_id'";
  $discuss_list = mysqli_query($connID, $sql);
  $discuss_list = mysqli_fetch_all($discuss_list, MYSQLI_ASSOC);
  ?>

  <div class="content">
    <div class="left">
      <div class="post">
        <div class="post_title"><?php echo $post_details['title'] ?></div>
        <div class="user_box">
          <div class="user">
            <img src="<?php echo $post_details['user_header'] ?>" alt="" class="hander">
            <div class="user_info">
              <div class="user_name">
                <?php echo $post_details['user_uname'] ?>
              </div>
              <div class="data">
                <?php echo $post_details['create_time'] ?> · 阅读 804
              </div>
            </div>
          </div>
        </div>
        <div class="post_details">
          <?php echo $post_details['html'] ?>
        </div>
      </div>

      <?php if ($post_details['status'] != 0) { ?>
        <div class="discuss" id='评论'>
          <a href="#评论" id="_评论"></a>
          <div class="discuss_title">评论</div>
          <div class="discuss_input">
            <textarea placeholder="输入评论"></textarea>
            <div class="btn_box">
              <button>发布评论</button>
            </div>
          </div>

          <div class="discuss_title">全部评论</div>
          <div class="discuss_list">
            <?php for ($i = 0; $i < count($discuss_list); $i++) {
              $item = $discuss_list[$i]
            ?>
              <div class="item">
                <img src="<?php echo $item['header'] ?>" class="hander" alt="">
                <div>
                  <div class="user_info">
                    <div class="user">
                      <div class="name"><?php echo $item['uname'] ?></div>
                      <div class="sign"><?php echo $item['sign'] ?></div>
                    </div>
                    <div class="date"><?php echo $item['create_time'] ?></div>
                  </div>
                  <div class="discuss_details">
                    <?php echo $item['discuss'] ?>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="right">
      <div class="user_box">
        <div class="user">
          <img src="<?php echo $post_details['user_header'] ?>" alt="" class="hander">
          <div class="user_info">
            <div class="user_name">
              <?php echo $post_details['user_uname'] ?>
            </div>
            <div class="data">
              <?php echo $post_details['user_sign'] ?>
            </div>
          </div>
        </div>
      </div>
      <div class="user_data">
        <p>获得点赞 3,625</p>
        <p>文章被阅读 64,974</p>
      </div>

      <div class="btn_box">
        <?php if ($post_details['status'] != 0) { ?>
          <div class="btn btn_give <?php if ($is_give_post) {
                                      echo 'active';
                                    } ?> " title="点赞">
            <img src="./img/give.png" alt="">
          </div>
          <div class="btn btn_valuate" title='评论'>
            <img src="./img/valuate.png" alt="">
          </div>
          <div class="btn btn_full" title='全屏'>
            <img src="./img/full.png" alt="">
          </div>
          <div class="btn btn_report" title='举报'>
            <img src="./img/report.png" alt="">
          </div>
        <?php } else { ?>
          <h4>草稿文章</h4>
          <div class="btn btn_full" title='全屏'>
            <img src="./img/full.png" alt="">
          </div>
        <?php } ?>
        <?php if ($current_user_id == $post_details['user_id']) { ?>
          <div class="btn btn_edit" title='修改'>
            <img src="./img/edit.png" alt="">
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="report_box">
    <div class="report">
      <h3>举报文章</h3>
      <textarea id="report_input" placeholder="请输入举报内容"></textarea>
      <div class="btn_box">
        <button class="sbmit">提 交</button>
        <button class="normal_btn">取 消</button>
      </div>
    </div>
  </div>

</body>

<script>
  $(function() {
    document.title = '<?php echo $post_details['title'] ?>'

    // 全屏
    $('.btn_full').on('click', function() {
      document.querySelector('.post').requestFullscreen()
    })

    // 举报
    $('.btn_report').on('click', function() {
      var current_user_id = '<?php echo $current_user_id ?>'
      if (!current_user_id) {
        return $('.login-btn').click()
      }
      $('.report_box').fadeIn()
    })
    // 举报框
    $('.report_box .normal_btn').on('click', function() {
      $('.report_box').fadeOut()
    })
    $('.report_box .sbmit').on('click', function() {
      var text = $('#report_input').val()
      if (text) {
        $.ajax({
          url: './api/report_post.php',
          type: 'POST',
          data: {
            post_id: '<?php echo $post_id ?>',
            text: text
          },
          success: function(res) {
            if (res.code === 200) {
              alert('举报成功')
              $('.report_box').fadeOut()
            } else if (res.code === 250) {
              alert('系统异常，请联系管理员!')
            } else {
              alert(res.msg)
            }
          }
        })
      } else {
        alert('请输入举报内容')
      }
    })

    // 评论按钮
    $('.btn_valuate').on('click', function() {
      document.getElementById('_评论').click()
    })

    // 文章编辑
    $('.btn_edit').on('click', function() {
      location.href = './post_edit.php?id=<? echo $post_id ?>'
    })

    // 点赞
    $('.btn_give').on('click', function() {
      var current_user_id = '<?php echo $current_user_id ?>'
      if (!current_user_id) {
        return $('.login-btn').click()
      }

      var param = {
        post_id: '<?php echo $post_id ?>',
        post_user_id: '<?php echo $post_details['user_id'] ?>'
      }

      $.ajax({
        url: './api/give.php',
        type: 'POST',
        data: param,
        success: function(res) {
          if (res.code === 200) {
            if (res.msg === '点赞成功') {
              $('.btn_give').addClass('active')
            } else {
              $('.btn_give').removeClass('active')
            }
          } else if (res.code === 250) {
            alert('系统异常，请联系管理员!')
          } else {
            alert(res.msg)
          }
        }
      })
    })

    // 评论
    $('.discuss_input button').on('click', function() {
      var val = $('.discuss_input textarea').val()
      if (val && val.length > 5) {
        $.ajax({
          url: './api/discuss_create.php',
          type: 'POST',
          data: {
            discuss: val,
            post_id: '<?php echo $post_id ?>'
          },
          success: function(res) {
            if (res.code === 200) {
              location.reload()
              alert('评论成功')
              localStorage.setItem('isToDiscuss', 'true')
            } else if (res.code === 250) {
              alert('系统异常，请联系管理员!')
            } else {
              alert(res.msg)
            }
          }
        })
      } else {
        alert('评论数必须大于5位！')
        $('.discuss_input textarea').focus()
      }
    })


    var isToDiscuss = localStorage.getItem('isToDiscuss')
    if (isToDiscuss) {
      setTimeout(function() {
        $('.btn_valuate').click()
      }, 300)
    }
  })
</script>

</html>