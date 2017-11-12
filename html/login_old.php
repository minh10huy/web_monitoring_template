<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>LOGIN - FECREDIT MONITORING</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="bg-black">
        <?php
        if (isset($_SESSION['monitoring_username']) && $_SESSION['monitoring_username'] != null) {
            ?>
            <script>
                window.location = "index.php";
            </script>
            <?php
        }
        ?>
        <div class="form-box" id="login-box">
            <div class="header"></div>
            <form id="HiddenLoginForm" action="login.php" method="post">
                <input type="hidden" name="username" id="hidden_username" />
                <input type="hidden" name="password" id="hidden_password" />
            </form>
                <div class="body bg-gray">
                    <div class="form-group">
                        <div class="error" id="error_msg"></div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" id="username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password"/>
                    </div>
                    
<!--                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>-->
                </div>
                <div class="footer">                                                               
<!--                    <button type="submit" class="btn bg-olive btn-block">Login</button>-->
                    <input type="button" value="LOGIN" class="btn bg-saigonbpo btn-block" onClick="return validateLogin();"  />
                </div>
        </div>
            <script>
                document.onkeydown=function(event){
                    if(event.keyCode=='13'){
                        checkAndSubmit(event);
                    }
                }
                function validateLogin(){
                    var username = document.getElementById("username");
                    var password = document.getElementById("password");

                    if(username  && username.value == ''){
                      alert("Please enter username!");
                      return false;
                    }

                    if(password && password.value == ''){
                      alert("Please enter password!");
                      return false;
                    }

                    document.getElementById("hidden_username").value = username.value;
                    document.getElementById("hidden_password").value = password.value;
                    document.getElementById("HiddenLoginForm").submit();
                  }

                  //For enter event
                  function checkAndSubmit(e) {
                   if (e.keyCode == 13) {
                        validateLogin();
                   }
                  }
            </script>   
        <?php
        require_once 'model/User.php';
        require_once 'lib/define/constants.php';
        ?>
        <?php
// Check if this is new comer on your web page.
        $_SESSION['monitoring_username'] = null;
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        $user = new User();
        if ($username != null) {
            $isVPBank = $user->isVPBankUser($username);			
            if (!$user->checkValidUser($username)){

            ?>
                <script>
                    document.getElementById("error_msg").innerHTML = "Invalid Username !";
                </script>
                <?php
            }
            else if($isVPBank && $user->checkIsBlocked($username)){

            ?>
                <script>
                    document.getElementById("error_msg").innerHTML = "Access denied for this user";
                </script>
                <?php
            } else { 
                   if ($isVPBank && $user->checkDuplicateLogin($username)) {
                    ?>
                    <script>
                        document.getElementById('error_msg').innerHTML = "This user already logged in";
                    </script>
                    <?php
                    
                } 
                else if ($user->checkLogin($username, $password)) {
          
                    ?>
                    <script>
                        document.getElementById('error_msg').innerHTML = "";
                    </script>
                    <?php
                    $_SESSION['monitoring_username'] = $username;
                    
                } else {
                    if ($isVPBank)
                        $attempts = $user->addLoginAttempt($username);
                    else
                        $attempts = 0;
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
            if ($_SESSION['monitoring_username'] != null) {
                $user->clearLoginAttempts($username);
                if ($user->checkInsecurePass($username)) {
                    $_SESSION['insecure_pass'] = "true";
                ?>
               
                <script>
                    window.location = "profile.php";
                </script>
                <?php } else {
                     ?>
               
                <script>
                    window.location = "index.php";
                </script>
                <?php
                }
            }
        }
        ?>
    </body>
</html>