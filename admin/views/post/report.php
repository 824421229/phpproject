<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>举报的文章</title>
  <link rel="stylesheet" href="../../layui/css/layui.css">
  <script src="../../layui/layui.js"></script>

  <style>
    .box {
      padding: 20px;
    }
  </style>
</head>

<body>
  <fieldset class="layui-elem-field layui-field-title">
    <legend>举报的文章</legend>
  </fieldset>
  <div class="box">
    <table id="demo" lay-filter="myTable"></table>
  </div>
</body>

<script type="text/html" id="titleTpl">
  <button class="layui-btn layui-btn-xs" lay-event="look">查看文章</button>
  <button class="layui-btn layui-btn-xs" lay-event="lookReport">查看举报内容</button>
  <!-- {{# if(d.is_edit == 0){ }} -->
  <button class="layui-btn layui-btn-xs layui-btn-danger" lay-event="pass">下架文章</button>
  <!-- {{# }else{ }} -->
  <span>已操作</span>
  <!-- {{# } }} -->
</script>

<script type="text/html" id="imgTpl">
  <img src="{{d.img}}" alt="">
</script>

<script>
  layui.use('table', function() {
    var table = layui.table;
    var $ = layui.$

    //第一个实例
    table.render({
      elem: '#demo',
      url: '../../api/get_report_post.php',
      page: true,
      cols: [
        [{
          field: 'title',
          title: '标题'
        }, {
          field: 'html_text',
          title: '文章描述'
        }, {
          field: 'img',
          title: '封面图',
          width: 80,
          templet: '#imgTpl'
        }, {
          field: 'post_type_name',
          title: '文章类型',
          width: 100
        }, {
          field: 'create_time',
          title: '发布时间',
          width: 177,
        }, {
          title: '操作',
          templet: '#titleTpl',
          width: 300
        }]
      ],
      parseData: function(res) { //res 即为原始返回的数据
        return {
          "code": res.code, //解析接口状态
          "msg": res.msg, //解析提示文本
          "count": res.data.count, //解析数据长度
          "data": res.data.list //解析数据列表
        };
      },
      response: {
        statusCode: 200 //规定成功的状态码，默认：0
      }
    });

    //单元格工具事件
    table.on('tool(myTable)', function(obj) {
      var data = obj.data;
      var layEvent = obj.event;

      if (layEvent === 'look') {
        layer.open({
          type: 1,
          content: data.html,
          title: data.title
        });
      } else if (layEvent === 'lookReport') {
        layer.open({
          type: 1,
          content: data.text,
          title: '查看举报内容'
        });
      } else if (layEvent === 'pass') {
        layer.confirm('确认通过下架文章吗？', {
          icon: 3,
          title: '提示'
        }, function(index) {
          $.ajax({
            url: '../../api/pass_post.php',
            type: 'POST',
            data: {
              id: data.post_id,
              status: 3
            },
            success: function(res) {
              $.ajax({
                url: '../../api/changer_report.php',
                data: {
                  id: data.post_report_id
                },
                success: function() {
                  table.reload('demo')
                }
              })
            }
          })
          layer.close(index);
        });
      }
    });

  });
</script>

</html>