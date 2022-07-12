<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SHOP - @yield('title')</title>
</head>
<style>
    .wrap {
    text-align: center;
    padding-top: 20%;
  }
  .btn {
    background-color: #ceccc8;
    text-decoration: none;
    color: #1e1e1e;
    padding: 16px;
    border-radius: 5px;
  }
  
  .popup-wrap {
    width: 100%;
    height: 100%;
    display: none;
    position: fixed;
    top: 0px;
    left: 0px;
    content: '';
    background: rgba(0, 0, 0, 0.85);
  }
  
  .popup-box {
    width: 50%;
    padding: 50px 75px;
    transform: translate(-50%, -50%) scale(0.5);
    position: absolute;
    top: 50%;
    left: 50%;
    box-shadow: 0px 2px 16px rgba(0, 0, 0, 0.5);
    border-radius: 3px;
    background: #fff;
    text-align: center;
  }
  h2 {
    font-size: 32px;
    color: #1a1a1a;
  }
  
  h3 {
    font-size: 24px;
    color: #888;
  }
  
  .close-btn {
    width: 50px;
    height: 50px;
    display: inline-block;
    position: absolute;
    top: 10px;
    right: 10px;
    border-radius: 100%;
    background: #d75f70;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    line-height: 40px;
    font-size: 32px;
  }
  
  .transform-in, .transform-out {
    display: block;
    -webkit-transition: all ease 0.5s;
    transition: all ease 0.5s;
  }
  
  .transform-in {
    -webkit-transform: translate(-50%, -50%) scale(1);
    transform: translate(-50%, -50%) scale(1);
  }
  
  .transform-out {
    -webkit-transform: translate(-50%, -50%) scale(0.5);
    transform: translate(-50%, -50%) scale(0.5);
  }
</style>
<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand">SHOP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/member">Member</a>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="/orders">Orders</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Category
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" id="dropdown"></div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contact_us">Contact us</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form> &nbsp;&nbsp;&nbsp;
          @if(Session::has('name') && Session::has('token'))
            <input type="hidden" id="userToken" value="{{Session::get('token')}}">
            <input type="hidden" id="user_id" value="{{Session::get('user_id')}}">
            <div class="form-inline my-2 my-lg-0">
                <button class="btn popup-btn" id="register" href="#register_form" style="display: none">Register</button>&nbsp;&nbsp;
                <button class="btn popup-btn" id="login" href="#login_form" style="display: none">Login</button>
            </div>
            <div class="form-inline my-2 my-lg-0" id="logout">
                {{Session::get('name')}}，您好&nbsp;&nbsp;
                <button class="btn popup-btn" id="logout-submit">Logout</button>
            </div>
          @else
            <div class="form-inline my-2 my-lg-0">
                <button class="btn popup-btn" id="register" href="#register_form">Register</button>&nbsp;&nbsp;
                <button class="btn popup-btn" id="login" href="#login_form">Login</button>
            </div>
            <div class="form-inline my-2 my-lg-0" id="logout" style="display: none">
                {{Session::get('name')}}，您好&nbsp;&nbsp;
                <button class="btn popup-btn" id="logout-submit">Logout</button>
            </div>
          @endif
          <div class="popup-wrap" id="login_form">
            <div class="popup-box transform-out">
                <h2>
                    <label>帳號：</label>
                    <input type="text" id="login-email"><br>
                    <label>密碼：</label>
                    <input type="text" id="login-password"><br><br>
                    <button id="login-submit">登入</button>
                </h2>
                <a class="close-btn popup-close" href="#">x</a>
            </div>
          </div>

          <div class="popup-wrap" id="register_form">
            <div class="popup-box transform-out">
                <h2>
                    <label>姓名：</label>
                    <input type="text" id="register-name"><br>
                    <label>信箱：</label>
                    <input type="text" id="register-email"><br>
                    <label>密碼：</label>
                    <input type="text" id="register-password"><br>
                    <label>確認密碼：</label>
                    <input type="text" id="register-password-confirmed"><br><br>
                    <button id="register-submit">註冊會員</button>
                </h2>
                <a class="close-btn popup-close" href="#">x</a>
            </div>
          </div>
        </div>
    </nav>
    <script>
        $( document ).ready(function() {
            $.ajax({
                method: "GET",
                url: "http://api.test/api/categories",
            })
            .done(function(response){
                $.each(JSON.parse(JSON.stringify(response)), function(key, value){
                    $("#dropdown").append(`<a class="dropdown-item" href="/categories/${value.slug}">${value.name}</a>`)
                });
            })
        });
        $("#login").click(function() {
            var href = $(this).attr("href")
            $(href).fadeIn(250);
            $(href).children$("popup-box").removeClass("transform-out").addClass("transform-in");
            e.preventDefault();
        });
        
        $("#register").click(function() {
            var href = $(this).attr("href")
            $(href).fadeIn(250);
            $(href).children$("popup-box").removeClass("transform-out").addClass("transform-in");
            e.preventDefault();
        });

        $(".popup-close").click(function() {
            closeWindow();
        });
        function closeWindow(){
            $(".popup-wrap").fadeOut(200);
            $(".popup-box").removeClass("transform-in").addClass("transform-out");
            event.preventDefault();
        }
        $("#login-submit").click(function(){
            closeWindow();
            $.ajax({
                method: "POST",
                url: "http://api.test/api/login",
                data: {
                    'email' : $("#login-email").val(),
                    'password' : $("#login-password").val()
                }
            })
            .done(function(response){
                if(JSON.parse(JSON.stringify(response)).code == 201){
                    alert(JSON.parse(JSON.stringify(response)).user + "您好，您已成功登入了")
                    var subscribe = new Array();
                    $.ajax({
                        method: "GET",
                        headers: {
                            "Authorization": "Bearer"+" " + JSON.parse(JSON.stringify(response)).token
                        },
                        url: "http://api.test/api/subscribe/" + JSON.parse(JSON.stringify(response)).user_id,
                    })
                    .done(function(response){
                        $.each(JSON.parse(JSON.stringify(response)), function(key, value){
                            subscribe.push(value.category_id)
                        })
                        $.ajax({
                            url: "/add_subscribe",
                            method: "POST",
                            data: {
                                '_token': '{{csrf_token()}}',
                                'category_id' : subscribe
                            }
                        })
                    })
                    $.ajax({
                        method: "POST",
                        url: '/login_token',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'token': JSON.parse(JSON.stringify(response)).token,
                            'user_id': JSON.parse(JSON.stringify(response)).user_id,
                            'name': JSON.parse(JSON.stringify(response)).user,
                            'email': JSON.parse(JSON.stringify(response)).email
                        }
                    })
                    .done(function(){
                        window.location.reload();
                    })
                }
                else{
                    alert(JSON.parse(JSON.stringify(response)).message)
                }
            })
        })

        $("#register-submit").click(function(){
            closeWindow();
            $.ajax({
                method: "POST",
                url: "http://api.test/api/register",
                data: {
                    'name': $("#register-name").val(),
                    'email': $("#register-email").val(),
                    'password': $("#register-password").val(),
                    'password_confirmation': $("#register-password-confirmed").val()
                }
            })
            .done(function(response){
                if(JSON.parse(JSON.stringify(response)).code == 201){
                    alert(JSON.parse(JSON.stringify(response)).message)
                }
                else{
                    alert(JSON.stringify(response))
                }
            })
        })

        $("#logout-submit").click(function(){
            $.ajax({
                method: "POST",
                url: "http://api.test/api/logout",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Bearer"+" "+$("#userToken").val()
                },
            })
            .done(function(response){
                alert(JSON.parse(JSON.stringify(response)).message)
                $.ajax({
                    method: "POST",
                    url: "/logout",
                    data: {
                        '_token': '{{csrf_token()}}',
                        'userStatus': 0
                    }
                })
                .done(function(){
                        window.location.reload();
                })
            })
        })
    </script>
    <div class="container">
        @yield('content')
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

