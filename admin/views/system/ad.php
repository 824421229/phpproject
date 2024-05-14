<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>广告管理</title>
  <link rel="stylesheet" href="../../layui/css/layui.css">
  <script src="../../layui/layui.js"></script>

  <style>
    .box {
      padding: 20px;
    }

    .btnBox {
      text-align: right;
    }
  </style>
</head>
<?php
require '../../config/database.php';

$ad_sql = "SELECT * FROM ad";
$ad_data = mysqli_query($connID, $ad_sql);
$ad_data = mysqli_fetch_all($ad_data, MYSQLI_ASSOC);
$ad1  = $ad_data[0];
$ad2  = $ad_data[1];
?>

<body>
  <fieldset class="layui-elem-field layui-field-title">
    <legend>广告管理</legend>
  </fieldset>

  <div class="box">
    <fieldset class="layui-elem-field">
      <legend>广告一</legend>
      <div class="layui-field-box">
        <form class="layui-form" action="">
          <div class="layui-form-item">
            <label class="layui-form-label">广告图</label>
            <div class="layui-input-block">
              <div class="layui-upload-drag" id="upload1">
                <i class="layui-icon"></i>
                <p>点击上传，或将文件拖拽到此处</p>
                <div  id="uploadDemoView1">
                  <hr>
                  <img src="<?php echo $ad1['img'] ?>" alt="上传成功后渲染" style="max-width: 196px" class="ad1">
                </div>
              </div>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">广告链接</label>
            <div class="layui-input-block">
              <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输广告链接" class="layui-input adInput1" value="<?php echo $ad1['link'] ?>">
            </div>
          </div>
        </form>
        <div class="btnBox">
          <button class="layui-btn" id="save1">保存广告一</button>
        </div>
      </div>
    </fieldset>


    <fieldset class="layui-elem-field">
      <legend>广告二</legend>
      <div class="layui-field-box">
        <form class="layui-form" action="">
          <div class="layui-form-item">
            <label class="layui-form-label">广告图</label>
            <div class="layui-input-block">
              <div class="layui-upload-drag" id="upload2">
                <i class="layui-icon"></i>
                <p>点击上传，或将文件拖拽到此处</p>
                <div id="uploadDemoView2">
                  <hr>
                  <img src="<?php echo $ad2['img'] ?>" alt="上传成功后渲染" style="max-width: 196px" class="ad2">
                </div>
              </div>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">广告链接</label>
            <div class="layui-input-block">
              <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输广告链接" class="layui-input adInput2" value="<?php echo $ad2['link'] ?>">
            </div>
          </div>
        </form>
        <div class="btnBox">
          <button class="layui-btn" id="save2">保存广告二</button>
        </div>
      </div>
    </fieldset>
  </div>

</body>

<script>
  layui.use(function() {
    var $ = layui.jquery,
      upload = layui.upload,
      element = layui.element,
      layer = layui.layer;

    upload.render({
      elem: '#upload1',
      url: '../../api/upload_img.php',
      done: function(res) {
        layer.msg('上传成功');
        layui.$('#uploadDemoView1').removeClass('layui-hide').find('img').attr('src', res.msg);
      }
    });
    upload.render({
      elem: '#upload2',
      url: '../../api/upload_img.php',
      done: function(res) {
        layer.msg('上传成功');
        layui.$('#uploadDemoView2').removeClass('layui-hide').find('img').attr('src', res.msg);
      }
    });

    $('#save1').on('click', function() {
      var img = $('.ad1').attr('src')
      var link = $('.adInput1').val()

      save({
        link: link,
        img: img,
        id: 1
      })
    })

    $('#save2').on('click', function() {
      var img = $('.ad2').attr('src')
      var link = $('.adInput2').val()

      save({
        link: link,
        img: img,
        id: 2
      })
    })

    function save(obj) {
      $.ajax({
        url: '../../api/ad_update.php',
        type: 'POST',
        data: obj,
        success: function(res) {
          layer.msg(res.msg)
        }
      })
    }
  })
</script>

</html>