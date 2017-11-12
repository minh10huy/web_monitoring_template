<?php
// Start the session
session_start();

        if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
            ?>
            <script>
                window.location = "login.php";
            </script>
        <?php  }          
require_once ('model/User.php');
$user = new User();
$userInfo = $user->getRole($_SESSION['monitoring_username']);
    $userrole = $userInfo[1];
    $userchannel = $userInfo[2];
    $useremail = $userInfo[3];
    $usercompany = $userInfo[4];
    $_SESSION['monitoring_userrole'] = $userrole;
    $_SESSION['monitoring_userchannel'] = $userchannel;
    $_SESSION['useremail'] = $useremail;
    $_SESSION['usercompany'] = $usercompany;
    $_SESSION['userid'] = $userInfo[0];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SAIGON BPO’s Monitoring System | Profile</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="css/monitoring_vpb.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue" onload="StartTimers();" onmousemove="ResetTimers();">

        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <!--Monitoring System-->
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $_SESSION['monitoring_username']; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-green">
                                    <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $_SESSION['monitoring_username'] ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                            <li>
                                <a href="index.php">
                                    <i class="fa fa-dashboard"></i> <span> Home</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="profile.php">
                                    <i class="fa fa-dashboard"></i> <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="listqde.php">
                                    <i class="fa fa-dashboard"></i> <span>QDE History</span>
                                </a>
                            </li>     
                            <li>
                                <a href="listticket.php">
                                    <i class="fa fa-dashboard"></i> <span>My Ticket</span>
                                </a>
                            </li>
                            <li>
                                <a href="upload_newapp.php">
                                    <i class="fa fa-dashboard"></i> <span>Upload New App</span>
                                </a>
                            </li> 
                            <?php if ($userrole != 'cc') { ?>
                                <li>
                                    <a href="UserSetting/user_setting.php">
                                        <i class="fa fa-dashboard"></i> <span>User Settings</span>
                                    </a>
                                </li>
                               
                            <?php } ?>
							<?php if ($userrole == 'admin' || $userrole == 'subadmin') { ?>
                                <li>
                                    <a href="report/report_tat.php">
                                        <i class="fa fa-dashboard"></i> <span>Report TAT</span>
                                    </a>
                                </li>                           
                            <?php } ?> 
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        SAIGON BPO’s Monitoring System - Profile
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Profile</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Change password</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <style>
                                        .left{
                                            float:left;
                                            margin-right:10px;
                                        }
                                        .left div{
                                            height:20px;
                                            margin-bottom: 5px;
                                        }
                                        .right div{
                                            height:20px;
                                            line-height: 10px;
                                            margin-bottom: 5px;
                                        }
                                    </style>
                                    <div class="left">
                                        <div>Username:</div>
                                        <div>Old password: </div>
                                        <div>New password: </div>
                                        <div>Retype new password: </div>
                                        <div>Email: </div>
                                    </div>
                                    <div class="right">
                                        <div><label><?php echo $_SESSION['monitoring_username']; ?></label></div>
                                        <div><input type="password" value="" id="oldPass" name="oldPass" /></div>
                                        <div><input type="password" value="" id="newPass" name="newPass" /></div>
                                        <div><input type="password" value="" id="retypeNewPass" name="retypeNewPass" /></div>
                                        <div><input type="text" value="<?php echo $useremail;?>" id="email" name="email" /></div>
                                    </div>
                                    <div>
                                        <br class="clearfix" />
                                        <input type="button" value="Apply" id="btnApply" name="btnApply" />
                                        <input type="button" value="Reset" id="btnReset" name="btnReset" />
                                        <label id="status"></label>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!--[if lt IE 9]>
            <script src="js/jquery-1.11.2.min.js"></script>
        <![endif]-->
        <!--[if gte IE 9]>
            <script src="js/jquery-1.11.2.min.js"></script>
        <!--<![endif]-->
        <script src="js/jquery.min.js"></script>

        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/noty/packaged/jquery.noty.packaged.min.js"></script>            
        <script src="js/timeout.js" type="text/javascript"></script>
        <script>
            var username = '<?php echo $_SESSION['monitoring_username']; ?>'
            $(document).ready(function() {
                                setInterval(function() {
                    // Update active time every 5 minutes
                    $.ajax({
                                 type: "POST",
                                 url: "updateActiveTime.php",
                                 async: true,
                                 data: {
                                   username : username  
                                 },
                                 cache: false,
                                 success: function(result) {

                                },
                                error: function(xhr, status, error) {

                                    console.log("Error");
                                    console.log(error);

                                }
                }); //ajax
                  }, 1000 * 60 * 5); // where X is your every 5 minutes
                <?php if($_SESSION['insecure_pass'] == "true" ) {?>
                //console.log(insecure_pass);
                    var n = noty({

                                     theme: 'relax', // or 'relax'
                                     type: 'error',
                                     text: 'Please change your password for safety.',
                                     animation: {
                                        open: {
                                            height: 'toggle'
                                        }, // jQuery animate function property object
                                        close: {
                                            height: 'toggle'
                                         }, // jQuery animate function property object
                                        easing: 'swing', // easing
                                        speed: 500, // opening & closing animation speed
                                        timeout: '2000',
                                        buttons: false
                                     }
                                });

                                        setTimeout(function() {
                                            $.noty.closeAll();
                                        }, 2000);
                <?php } ?>
            });
                                                   
            function CheckPassword(strPassword)
            {
                var decimal = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
                if (strPassword.match(decimal))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }

            function validateEmail(email) {
                var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                return re.test(email);
            }

            $('#btnApply').click(function () {
                var username = '<?php echo $_SESSION['monitoring_username']; ?>';
                var oldPass = $("#oldPass").val();
                var newPass = $("#newPass").val();
                var retypeNewPass = $("#retypeNewPass").val();
                var email = $("#email").val();

                if (newPass === "") {
                    alert("New password does not empty!");
                    return false;
                }
                if (newPass !== retypeNewPass) {
                    alert("Password does not match!");
                    return false;
                }

                if (!CheckPassword(newPass)) {
                    alert("Password must be between 8 to 15 characters \n\
                            \nwhich contain at least one lowercase letter, \n\
                            \none uppercase letter, \n\
                            \none numeric digit, \n\
                            \nand one special character");
                    return false;
                }

//                if (!validateEmail(email)) {
//                    alert("You have entered an invalid email address!");
//                }

                $.ajax({
                    url: 'ajax/change_password.php',
                    type: 'POST',
                    cache: false,
                    data: 'username=' + username + "&oldPass=" + oldPass + "&newPass=" + newPass + "&email=" + email,
                    success: function (string) {
                        alert(string);
                        if (string === "success") {
                            $("#status").removeClass("error");
                            $("#status").addClass("success");
                            $("#status").html("Change password successfully!");
                        } else {
                            if (string !== "error") {
                                $("#status").removeClass("success");
                                $("#status").addClass("error");
                                $("#status").html("Password must be between 8 to 15 characters \n\
                            \nwhich contain at least one lowercase letter, \n\
                            \none uppercase letter, \n\
                            \none numeric digit, \n\
                            \nand one special character");
                            } else {
                                $("#status").removeClass("success");
                                $("#status").addClass("error");
                                $("#status").html("Old password error!");
                            }
                        }
                    },
                    error: function () {
                        $("#status").removeClass("success");
                        $("#status").addClass("error");
                        $("#status").html("Change password error!");
                    }

                });
            });
            
            $('#btnReset').click(function () {
                var username = '<?php echo $_SESSION['monitoring_username']; ?>';
 
                $.ajax({
                    url: 'ajax/reset_password.php',
                    type: 'POST',
                    cache: false,
                    data: 'username=' + username,
                    success: function (string) {
                        //alert(string);
                        if (string === "success") {
                             $("#status").removeClass("error");
                            $("#status").addClass("success");
                            $("#status").html("Reset password successful!");
                        } else {
                             $("#status").removeClass("success");
                            $("#status").addClass("error");
                            $("#status").html("There is error occured!");
                        }
                    },
                    error: function () {
                        $("#status").removeClass("success");
                        $("#status").addClass("error");
                        $("#status").html("Reset password error!");
                    }

                });
            });
        </script>
    </body>
</html>
