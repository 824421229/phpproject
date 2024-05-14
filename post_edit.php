<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>写文章</title>
  <link rel="stylesheet" href="./style/common.css">
  <link rel="stylesheet" href="./style/post_edit.css">

  <script src="./js/wangEditor.min.js"></script>
  <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./js/common.js"></script>
</head>

<body>
  <?php
  require './config/database.php';

  require './common/top.php';

  $id = $_GET['id'];

  $sql = "SELECT * FROM `post_type` WHERE `status` = 1";
  $post_type_list = mysqli_query($connID, $sql);
  $post_type_list = mysqli_fetch_all($post_type_list, MYSQLI_ASSOC);

  if ($id) {
    $sql = "SELECT * FROM post WHERE id = '$id'";
    $post_details = mysqli_query($connID, $sql);
    $post_details = mysqli_fetch_array($post_details);
  }
  ?>
  <div class="content">
    <form class="post_form">
      <div class="type_select">
        <label for="">文章类型</label>
        <select name="post_type_id" id="">
          <?php for ($i = 0; $i < count($post_type_list); $i++) { ?>
            <?php if ($post_details['post_type_id'] == $post_type_list[$i]['id']) { ?>
              <option value="<?php echo $post_type_list[$i]['id'] ?>" selected>
                <?php echo  $post_type_list[$i]['name'] ?>
              </option>
            <?php } else { ?>
              <option value="<?php echo $post_type_list[$i]['id'] ?>">
                <?php echo  $post_type_list[$i]['name'] ?>
              </option>
            <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="post_img">
        <label for="">封面图</label>
        <img src="<?php echo $id ? $post_details['img'] : '' ?>" alt="点击图片上传">
        <input type="file">
      </div>
      <input type="text" name="title" class="titl_input" placeholder="请输入文章标题" value="<?php echo $id ? $post_details['title'] : '' ?>">
    </form>
    <div id="editor"></div>

    <div class="btn_box">
      <button class="normal_btn post_save">保存草稿</button>
      <button class="post_sbmit">提交审核</button>
    </div>
  </div>

  <input type="hidden" id="_html" value="<? echo htmlentities($post_details['html']) ?>">
</body>

<script>
  var id = '<?php echo $id ?>'

  var E = window.wangEditor
  var editor = new E("#editor")
  editor.config.uploadFileName = 'file'
  editor.config.uploadImgMaxLength = 1
  editor.config.uploadImgServer = './api/upload_imt.php'
  editor.config.uploadImgHooks = {
    customInsert: function(insertImgFn, res) {
      if (res.code === 200) {
        insertImgFn(res.msg)
      } else {
        alert(res.msg)
      }

    }
  }
  editor.config.excludeMenus = [
    'video'
  ]
  editor.create()
  if (id) {
    editor.txt.html($('#_html').val())
  }

  $(function() {
    var file = null
    $('.post_img img').on('click', function() {
      $('.post_img input').click()
    })
    $('.post_img input').on('change', function() {
      file = this.files[0]
      $('.post_img img').attr('src', URL.createObjectURL(file))
    })

    $('.post_sbmit').on('click', function() {
      submitPost(1)
    })

    $('.post_save').on('click', function() {
      submitPost(0)
    })

    function submitPost(status) {
      var formData = getFormData('.post_form')
      formData['html'] = editor.txt.html()
      formData['html_text'] = editor.txt.text()
      if (formData['html_text'].length > 200) {
        formData['html_text'] = formData['html_text'].substr(0, 200)
      }
      formData['status'] = status
      if (file) {
        formData['file'] = file
      }


      var formObj = new FormData()
      $.each(formData, function(key, value) {
        formObj.append(key, value)
      })
      if (id) {
        formObj.append('id', id)
      }

      $.ajax({
        url: './api/create_post.php',
        type: 'POST',
        data: formObj,
        processData: false,
        contentType: false,
        success: function(res) {
          if (res.code === 200) {
            if (status === 1) {
              alert('文章提交成功,正在审核中...')
            } else {
              alert('文章保存成功')
            }
            location.href = './user.php'
          } else if (res.code === 250) {
            alert('系统发生了错误，请联系管理员！')
          } else {
            alert(res.msg)
          }
        }
      })
    }
  })
</script>

</html>