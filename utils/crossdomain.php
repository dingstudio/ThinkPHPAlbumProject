<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json; Charset=UTF-8');
    if (!session_id()) { //按需全局启用Session机制
        session_start();
    }
    if (!isset($_REQUEST['username']) || !isset($_REQUEST['usermail']) || !isset($_REQUEST['newtoken'])) {
        die('{"status":false}');
    }
    else {
        $user = file_get_contents('https://passport.dingstudio.cn/api?format=json&action=verify&token='.htmlspecialchars($_REQUEST['newtoken']).'&reqtime='.sha1(date('YmdHis',time())));
        $userinfo = json_decode($user);
        if ($userinfo->data->username != null && $userinfo->data->newtoken != null) {
            setcookie('myalbum_token', $userinfo->data->newtoken, time() + 1800, '/', $_SERVER['HTTP_HOST']);
            $_SESSION['myalbum_user'] = $userinfo->data->username;
            $_SESSION['myalbum_token'] = $userinfo->data->newtoken;
            $_SESSION['myalbum_email'] = $userinfo->data->usermail;
            die('{"status":true}');
        }
        else {
            die('{"status":false}');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DingStudio SSO Platform</title>
    <script type="text/javascript" src="http://static.album.dingstudio.cn/jquery-3.3.1.js"></script>
    <script>
        var SSOClient = window.location.href;
        var SSORoot = 'https://passport.dingstudio.cn/sso/';
        var LoginServlet = SSORoot + 'login?mod=caslogin&returnUrl=' + encodeURIComponent(SSOClient);
        var VerifyServlet = 'https://passport.dingstudio.cn/api?format=json&action=verify';
        var QueryServlet = 'https://passport.dingstudio.cn/api?format=json&action=status';
        var AppUrl = '../admin.php';
    </script>
</head>
<body>
<h2>用户互联登录授权</h2>
<h3>状态：<small><span id="statusBox">正在等待认证服务器响应</span></small></h3>
<script>
    $.ajax({
        url: QueryServlet,
        method: 'get',
        data: {
            'hostname': window.location.hostname,
            'requests': Date.parse(new Date()) / 1000
        },
        dataType: 'jsonp',
        jsonp: 'callback',
        success: function (response) {
            if (response.data.authcode === 1) {
                var usertoken = response.data.token;
                $.ajax({
                    url: VerifyServlet,
                    method: 'get',
                    data: {
                        'token': usertoken,
                        'reqtime': Date.parse(new Date()) / 1000
                    },
                    dataType: 'jsonp',
                    jsonp: 'callback',
                    success: function (response) {
                        if (response.code === 200) {
                            var username = response.data.username;
                            var usermail = response.data.usermail;
                            var newtoken = response.data.newtoken;
                            $('#statusBox').css('color', 'green');
                            $('#statusBox').html('<br>\
                            ' + username + '，欢迎回来。<br>\
                            您的邮箱：' + usermail + '<br>\
                            正在为您同步用户信息并自动登录，请稍候。');
                            $.ajax({
                                url: SSOClient,
                                method: 'post',
                                data: {
                                    'username': username,
                                    'usermail': usermail,
                                    'newtoken': newtoken
                                },
                                dataType: 'json',
                                async: true,
                                success: function (response) {
                                    if (response.status === true) {
                                        location.href = AppUrl;
                                    }
                                    else {
                                        setTimeout(() => {
                                            $('#statusBox').css('color', 'blue');
                                            $('#statusBox').html('<br>\
                                            ' + username + '，欢迎回来。<br>\
                                            您的邮箱：' + usermail + '<br>\
                                            <br>操作结果：您的账号没有权限进入该应用。');
                                        }, 1000);
                                    }
                                },
                                error: function (data) {
                                    setTimeout(() => {
                                        $('#statusBox').css('color', 'blue');
                                        $('#statusBox').html('<br>\
                                        ' + username + '，欢迎回来。<br>\
                                        您的邮箱：' + usermail + '<br>\
                                        <br>操作结果：您的账号没有权限进入该应用。');
                                    }, 1000);
                                }
                            });
                        }
                        else {
                            $('#statusBox').css('color', 'orangered');
                            $('#statusBox').html('会话超时，请重新登陆。正在为您跳转至统一身份认证平台');
                            setTimeout(() => {
                                location.href = LoginServlet;
                            }, 1000);
                        }
                    },
                    error: function (data) {
                        $('#statusBox').css('color', 'red');
                        $('#statusBox').html('二次身份核验失败，此现象可能是网络不稳定所致，建议刷新重试！如果多次出现，请尝试重新登陆。');
                    }
                });
            }
            else {
                $('#statusBox').css('color', 'red');
                $('#statusBox').html('未登录或由于会话过期，正在为您跳转至统一身份认证平台');
                setTimeout(() => {
                    location.href = LoginServlet;
                }, 1000);
            }
        },
        error: function (data) {
            $('#statusBox').css('color', 'red');
            $('#statusBox').html('无法与统一身份认证服务器正常通信，请联系认证域管理员确认是否正确接入！');
        }
    })
</script>
</body>
</html>