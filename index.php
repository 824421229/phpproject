<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>小航航の社区</title>
  <link rel="stylesheet" href="./style/common.css">
  <link rel="stylesheet" href="./style/index.css">

  <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./js/common.js"></script>
</head>

<body class="index">
  <?php
  require './config/database.php';

  $post_type_id = $_GET['post_type_id'];
  $search_word = $_GET['search_word'];
  $is_reco = $_GET['is_reco'];
  require './common/top.php';

  if ($post_type_id) {
    $sql = "SELECT post.*, post_type.name as post_type_name , user.uname  FROM `post`
    JOIN `post_type` ON post.post_type_id = post_type.id
    JOIN `user` ON post.user_id = user.id
    WHERE post.status = '2' AND `delete_time` is null AND post_type_id = '$post_type_id' ORDER BY post.id DESC";
  } elseif ($search_word) {
    $sql = "SELECT post.*, post_type.name as post_type_name , user.uname  FROM `post`
    JOIN `post_type` ON post.post_type_id = post_type.id
    JOIN `user` ON post.user_id = user.id
    WHERE post.status = '2' AND `delete_time` is null
    AND post.title LIKE '%$search_word%' OR  post.html_text LIKE '%$search_word%' ORDER BY post.id DESC";
  } else {
    $sql = "SELECT post.*, post_type.name as post_type_name , user.uname  FROM `post`
    JOIN `post_type` ON post.post_type_id = post_type.id
    JOIN `user` ON post.user_id = user.id
    WHERE post.status = '2' AND `delete_time` is null ORDER BY post.id DESC";
  }

  if ($is_reco) {
    $sql = "SELECT post.*, post_type.name as post_type_name , user.uname  FROM `post`
    JOIN `post_type` ON post.post_type_id = post_type.id
    JOIN `user` ON post.user_id = user.id
    WHERE post.status = '2' AND `delete_time` is null AND is_reco = '$is_reco'";
  }

  $post_list = mysqli_query($connID, $sql);
  $post_list = mysqli_fetch_all($post_list, MYSQLI_ASSOC);

  // 排行榜
  $sql = "SELECT user.*,(SELECT count(*) FROM post_give WHERE user.id = post_give.post_user_id) AS gives
  FROM user ORDER BY gives DESC LIMIT 5";
  $users = mysqli_query($connID, $sql);
  $users = mysqli_fetch_all($users, MYSQLI_ASSOC);

  // 广告
  $sql = "SELECT * FROM ad";
  $ad_data = mysqli_query($connID, $sql);
  $ad_data = mysqli_fetch_all($ad_data, MYSQLI_ASSOC);
  ?>

  <div class="content">
    <div class="navbar">
      <div class="item <?php if (!$is_reco) echo 'active' ?>" data-type="0">最新</div>
      <div class="item <?php if ($is_reco) echo 'active' ?>" data-type="1">推荐</div>
    </div>
    <div class="content-list">
      <?php for ($i = 0; $i < count($post_list); $i++) {
        $item = $post_list[$i];
      ?>
        <a href="./post_details.php?id=<?php echo $item['id'] ?>">
          <div class="item">
            <div class="left" style="<?php if (!$item['img']) {
                                        echo 'width: 616px;';
                                      } ?>">
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
    <div class="content-right">
      <div class="ad">
        <?php
        for ($i = 0; $i < count($ad_data); $i++) {
          $item = $ad_data[$i];

        ?>
          <a href="<?php echo $item['link'] ?>">
            <img src="<?php echo $item['img'] ?>" alt="">
          </a>
        <?php } ?>
      </div>
      <div class="rank">
        <div class="rank-title">作者排行榜</div>
        <div class="ranl-list">
          <?php for ($i = 0; $i < count($users); $i++) {
            $item =  $users[$i] ?>
            <div class="item">
              <img src="<?php echo $item['header'] ?>" alt="" class="hander">
              <div class="info">
                <div class="name"><?php echo $item['uname'] ?></div>
                <div class="sign"><?php echo $item['sign'] ?> </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

</body>

<script>
  $(function() {
    $('.navbar').on('click', '.item', function() {
      var type = $(this).attr('data-type')
      location.href = './index.php?is_reco=' + type
    })
  })
</script>

</html>
