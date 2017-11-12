<?php
// Start the session
session_start();
if (isset($_SESSION['monitoring_username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>FECREDIT MONITORING - LOGIN</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="ionicons-2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/saigonbpo.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="index.php"> <img src="img/logo.png" alt="logo" height="80" width="360"> </a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form enctype = "multipart/form-data"  action="login.php" method="POST" onsubmit="return validateLogin();">
                    <div class="form-group">
                        <div class="error" id="error_msg"></div>
                    </div>                    
                    <div class="form-group has-feedback">
                        <input type="text" name="username" class="form-control" placeholder="Username" id="username">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" name="loginForm" id="loginForm">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <script>
                    document.onkeydown = function (event) {
                        if (event.keyCode === '13') {
                            checkAndSubmit(event);
                        }
                    }

                    function validateLogin() {
                        console.log('test');
                        var username = document.getElementById("username");
                        var password = document.getElementById("password");

                        if (username && username.value === '') {
                            document.getElementById("error_msg").innerHTML = "Please enter username!";
                            return false;
                        }

                        if (password && password.value === '') {
                            document.getElementById("error_msg").innerHTML = "Please enter password!";
                            return false;
                        }
                        console.log('before');
                        document.getElementById("loginForm").submit();
                        console.log('after');

                    }


                    //For enter event
                    function checkAndSubmit(e) {
                        if (e.keyCode === 13) {
                            validateLogin();
                        }
                    }

                </script>  
                <!-- jQuery 2.2.3 -->
                <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
                <!-- Bootstrap 3.3.6 -->
                <script src="bootstrap/js/bootstrap.min.js"></script>
                <!-- iCheck -->
                <script src="plugins/iCheck/icheck.min.js"></script>
                <script>
                    $(function () {
                        $('input').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-blue',
                            increaseArea: '20%' // optional
                        });
                    });
                </script>                
            </div>
            <!-- /.login-box-body -->
        </div>           
        <!-- /.login-box -->
        <?php
        if (isset($_POST["loginForm"])) {
            require_once 'model/User.php';
            require_once 'lib/define/constants.php';
// Check if this is new comer on your web page.

            $_SESSION['monitoring_username'] = null;
            /* @var $username type */
            $username = isset($_POST['username']) ? $_POST['username'] : null;
            $password = isset($_POST['password']) ? $_POST['password'] : null;

            $user = new User();

            if ($username != null) {
                $isVPBank = $user->isVPBankUser($username);
                if ($user->checkLogin($username, $password)) {
                    
                        $_SESSION['monitoring_username'] = $username;
                        ?>
                        <script>
                            window.location = "index.php";
                        </script>
                        <?php
                    
                } else {
                    $attempts = 0;
                    if ($isVPBank) {
                        $attempts = $user->addLoginAttempt($username);
                    } else {
                        $attempts = 0;
                    }
                    if ($attempts == 3) {
                        ?>
                        <script>
                            document.getElementById("error_msg").innerHTML = "Access denied for this user";
                        </script>
                        <?php
                    } else {
                        ?>
                        <script>
                            document.getElementById("error_msg").innerHTML = "Invalid username or password";
                        </script>
                        <?php
                    }
                }
            }
        }
        ?>        
    </body>
</html>

