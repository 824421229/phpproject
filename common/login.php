<!-- 登录框 -->

<div class="login_box">
  <div class="login">
    <img src="./img/login_start.svg" class="mascot no1">
    <img src="./img/login_password.svg" class="mascot no2">

    <div class="login_title">
      <div class="title">账号密码登录</div>
      <div class="close">关闭</div>
    </div>

    <form action="#" method="post" class="login_form">
      <input type="text" name="account" id="account_login" placeholder="请输入用户账号">
      <input type="password" name="password" id="password_login" placeholder="请输入您的密码" class="pwd">
      <button type="submit">登 录</button>
    </form>

    <div class="login_tips">
      <span class="open_register">账号注册</span>
      <span>忘记密码</span>
    </div>
  </div>

  <div class="register">
    <img src="./img/login_register.svg" class="mascot">

    <div class="login_title">
      <div class="title">欢迎用户注册</div>
      <div class="close">关闭</div>
    </div>

    <form action="#" method="post" class="register_form">
      <div class="item">
        <label for="uname">用户名称：</label>
        <input id="uname" type="text" name="uname" placeholder="请输入用户名称">
      </div>
      <div class="item">
        <label for="phone">手机号：</label>
        <input id="phone" type="text" name="phone" placeholder="请输入手机号">
      </div>
      <div class="item">
        <label for="account">账号：</label>
        <input id="account" type="text" name="account" placeholder="请输入用户账号">
      </div>
      <div class="item">
        <label for="password">密码：</label>
        <input id="password" type="password" name="password" placeholder="请输入您的密码" class="pwd">
      </div>
      <div class="item">
        <label for="password2">确认密码：</label>
        <input id="password2" type="password" name="password2" placeholder="请确认您的密码" class="pwd">
      </div>
      <button type="submit">注 册</button>
    </form>
    <button class="btn2 open_login">返回登录</button>
  </div>
</div>

<script>
  $(function() {
    $('.login_form input').on('focus', function() {
      $(this).addClass('active')
    })
    $('.login_form input').on('blur', function() {
      $(this).removeClass('active')
    })


    var mascot1 = $('.mascot.no1')
    var mascot2 = $('.mascot.no2')
    $('.pwd').on('focus', function() {
      mascot1.hide()
      mascot2.show()
    })
    $('.pwd').on('blur', function() {
      mascot1.show()
      mascot2.hide()
    })

    $('.close').on('click', function() {
      $('.login_box').fadeOut()
    })

    $('.open_register').on('click', function() {
      $('.login').fadeOut(function() {
        $('.register').fadeIn()
      })
    })
    $('.open_login').on('click', function() {
      $('.register').fadeOut(function() {
        $('.login').fadeIn()
      })
    })

    $('.register_form input').on('focus', function() {
      $(this).addClass('active')
    })
    $('.register_form input').on('blur', function() {
      $(this).removeClass('active')
    })

    // 注册
    $('.register_form').on('submit', function(e) {
      e.preventDefault()
      var formData = getFormData(this)

      if (!formData.uname) {
        $('#uname').focus()
        return alert('用户名称是必填的')
      }

      if (!formData.phone) {
        $('#phone').focus()
        return alert('请输入正确的手机号')
      }

      if (!formData.account) {
        $('#account').focus()
        return alert('请输入用户账号')
      }

      if (!formData.password) {
        $('#password').focus()
        return alert('请输入您的密码')
      }

      if (formData.password.length < 6) {
        $('#password').focus()
        return alert('密码必须6位以上')
      }

      if (formData.password !== formData.password2) {
        $('#password2').focus()
        return alert('两次输入的密码不一致')
      }

      $.ajax({
        url: './api/register.php',
        type: 'POST',
        data: formData,
        success: function(res) {
          if (res.code === 200) {
            alert('账号已经注册成功,前往登录吧！')
            $('.open_login').click()
          } else if (res.code === 250) {
            alert('系统发生了错误，请联系管理员！')
          } else {
            alert(res.msg)
          }
        }
      })
    })

    // 登录
    $('.login_form').on('submit', function(e) {
      e.preventDefault()
      var formData = getFormData(this)

      if (!formData.account) {
        $('#account_login').focus()
        return alert('账号是必填的')
      }
      if (!formData.password) {
        $('#password_login').focus()
        return alert('请输入您的密码')
      }

      $.ajax({
        url: './api/login.php',
        type: 'POST',
        data: formData,
        success: function(res) {
          if (res.code === 200) {
            location.reload()
          } else {
            alert(res.msg)
          }
        }
      })
    })
  })
</script>


<style>
  .login_box {
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    background-color: #00000035;
    z-index: 99;
    display: none;
  }

  .login,
  .register {
    box-sizing: border-box;
    width: 320px;
    height: 240px;
    background-color: #fff;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 15px;

  }

  .login .mascot,
  .register .mascot {
    position: absolute;
    top: -87px;
    left: 50%;
    transform: translateX(-50%);
  }

  .login .mascot.no2 {
    display: none;
  }

  .login_title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
  }

  .login_title .title {
    font-size: 20px;
    font-weight: bold;
  }

  .login_title .close {
    font-size: 14px;
    cursor: pointer;
    color: #b1b1b1;
  }

  .login_form input {
    box-sizing: border-box;
    width: 100%;
    height: 32px;
    border: 1px solid #e9e9e9;
    margin-bottom: 15px;
    padding-left: 15px;
  }

  .login_form input.active {
    border-color: #ff5722;
  }

  .login_form button {
    width: 100%;
    margin-bottom: 15px;
  }

  .login_tips {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
  }

  .login_tips span {
    cursor: pointer;
    color: #ff5722;
  }

  .register {
    display: block;
    height: 410px;
    display: none;
  }

  .register_form .item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;

  }

  .register_form .item label {
    font-size: 14px;
    width: 70px;
    text-align: right;
  }

  .register_form .item input {
    height: 32px;
    border: 1px solid #e9e9e9;
    padding-left: 15px;
    flex: 1;
  }

  .register_form input.active {
    border-color: #ff5722;
  }

  .register button {
    width: 100%;
    margin-bottom: 15px;
  }
</style>