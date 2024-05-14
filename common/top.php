<?php
session_start();
require './config/database.php';
require './common/login.php';

$url = $_SERVER['SCRIPT_NAME'];

$sql = "SELECT * FROM `post_type` WHERE `status` = 1";
$post_type_list = mysqli_query($connID, $sql);
$post_type_list = mysqli_fetch_all($post_type_list, MYSQLI_ASSOC);
?>

<div class="top-bg"></div>

<div class="top-box">
  <div class="top">
    <div class="left">
      <div class="logo">
        <img src="https://webinput.nie.netease.com/img/party/logo.png" alt="">
      </div>
      <div class="moduel-top-list">
        <div class="item <?php if (!$post_type_id && $url == '/index.php') {
                            echo 'active';
                          } ?>">全部</div>
        <?php for ($i = 0; $i < count($post_type_list); $i++) { ?>
          <?php if ($post_type_id == $post_type_list[$i]['id']) { ?>
            <div class="item active" data-id='<?php echo $post_type_list[$i]['id'] ?>'>
              <?php echo $post_type_list[$i]['name'] ?>
            </div>
          <?php } else { ?>
            <div class="item" data-id='<?php echo $post_type_list[$i]['id'] ?>'>
              <?php echo $post_type_list[$i]['name'] ?>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
    <div class="right">
      <div class="search">
        <input type="text" placeholder="探索未知的世界社区" value="<?php echo $search_word ?>">
        <div class="search-btn">搜索</div>
      </div>
      <?php if (empty($_SESSION['user_id'])) { ?>
        <button class="login-btn">登录</button>
      <?php } else { ?>
        <?php if ($url != '/post_edit.php') { ?>
          <button class="open_post_edit">发布文章</button>
        <?php } ?>
        <div class="user top_">
          <img src="<?php echo $_SESSION['user_info']['header'] ?>" class="hander" alt="">
          <p><?php echo $_SESSION['user_info']['uname'] ?></p>

          <div class="out_login">
            <p>退出登录</p>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('.login-btn').on('click', function() {
      $('.login_box').fadeIn()
      $('.login').show()
      $('.register').hide()
    })

    $('.user.top_').on('click', function() {
      location.href = './user.php'
    })

    $('.out_login').on('click', function() {
      $.ajax({
        url: './api/out_login.php',
        success: function(res) {
          location.href = './index.php'
        }
      })
    })

    $('.open_post_edit').on('click', function() {
      location.href = './post_edit.php'
    })

    // 头部导航点击切换
    $('.moduel-top-list').on('click', '.item', function() {
      var id = $(this).attr('data-id') || ''
      location.href = 'index.php?post_type_id=' + id
    })

    // 搜索
    $('.top-box .search-btn').on('click', function() {
      var search_word = $('.top-box .search input').val()
      if (search_word) {
        location.href = './index.php?search_word=' + search_word
      } else {
        location.href = './index.php'
      }
    })

  })
</script>

<style>
  .top-bg {
    height: 60px;
  }

  .top-box {
    height: 60px;
    border-bottom: 1px solid #f1f1f1;
    background-color: #fff;
    position: fixed;
    top: 0;
    width: 100%;
  }

  .top-box .top {
    height: 100%;
    width: 1140px;
    margin: 0 auto;

    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .top-box .top .left,
  .top-box .top .right {
    height: 100%;
    display: flex;
    align-items: center;
  }

  .top-box .top .logo {
    margin-right: 15px;
  }

  .top-box .top .logo img {
    width: 110px;
  }

  .top-box .top .moduel-top-list {
    height: 100%;
    display: flex;
    align-items: center;
  }

  .top-box .top .moduel-top-list .item {
    padding: 0 15px;
    cursor: pointer;
    height: 100%;
    line-height: 60px;
    position: relative;
  }

  .top-box .top .moduel-top-list .item.active {
    color: #ff5722;
    font-weight: 700;
  }

  .top-box .top .moduel-top-list .item.active::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #ff5722;
  }

  .top-box .top .search {
    box-sizing: border-box;
    border: 1px solid #c2c8d1;
    display: flex;
    align-items: center;
    width: 280px;
    height: 36px;
    padding: 4px;
    padding-left: 15px;
    border-radius: 4px;
  }

  .top-box .top .search input {
    flex: 1;
  }

  .top-box .top .search .search-btn {
    background-color: #f2f3f5;
    font-size: 12px;
    height: 100%;
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #505866;
    cursor: pointer;
  }

  .top-box .top .user {
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: bold;
    position: relative;
  }

  .top-box .top .user img {
    width: 36px;
    margin: 0 15px;
  }

  .top-box .top .user:hover .out_login {
    display: block;
  }

  .top-box .top .user .out_login {
    position: absolute;
    height: 32px;
    line-height: 32px;
    text-align: center;
    width: 91px;
    bottom: -32px;
    background-color: #fff;
    border: 1px solid #f2f3f5;
    border-radius: 4px;
    cursor: pointer;
    display: none;
  }

  .top-box .top .user .out_login:hover {
    color: #ff5722;
  }

  .login-btn {
    margin-left: 15px;
  }

  .open_post_edit {
    width: 100px;
    margin-left: 15px;
  }
</style>
