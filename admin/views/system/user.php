<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>后台人员管理</title>
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
    <legend>后台人员管理</legend>
  </fieldset>
  <div class="box">
    <button class="layui-btn layui-btn-xs" id="addAdmin">添加人员</button>
    <table id="demo" lay-filter="myTable"></table>
  </div>
</body>

<script type="text/html" id="titleTpl">
  <button class="layui-btn layui-btn-xs" lay-event="edit">编辑</button>
  <button class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</button>
</script>


<script>
  layui.use('table', function() {
    var table = layui.table;
    var $ = layui.$

    $('#addAdmin').on('click', function() {
      layer.open({
        type: 2,
        content: './edit_admin.php',
        area: ['700px', '500px']
      });
    })

    //第一个实例
    table.render({
      elem: '#demo',
      url: '../../api/get_admin.php',
      page: true,
      cols: [
        [{
          field: 'account',
          title: '账户'
        }, {
          field: 'admin_user',
          title: '管理员姓名'
        }, {
          field: 'phone',
          title: '手机号'
        }, {
          field: 'create_time',
          title: '添加时间',
          width: 177,
        }, {
          title: '操作',
          templet: '#titleTpl',
          width: 250
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

      if (layEvent === 'edit') {
        layer.open({
          type: 2,
          content: './edit_admin.php?id=' + data.id,
          area: ['700px', '500px']
        });
      } else if (layEvent === 'del') {
        layer.confirm('确认删除此管理员吗？', {
          icon: 3,
          title: '提示'
        }, function(index) {
          $.ajax({
            url: '../../api/del_admin.php',
            type: 'GET',
            data: {
              id: data.id
            },
            success: function(res) {
              layer.msg(res.msg)
              obj.del()
            }
          })
          layer.close(index);
        });
      }
    });

  });
</script>

</html>