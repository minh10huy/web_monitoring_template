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
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Saigon BPO | Trang chủ</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="ionicons-2.0.1/css/ionicons.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="plugins/iCheck/all.css">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/saigonbpo.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!--<link href="css/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css" />-->        
<!--        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="plugins/datatables/jquery.dataTables.css">-->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .skin-yellow-light .main-header .logo {
                background-color: #ffffff;
                border-bottom: 0 solid transparent;
                color: #fff;
            }
        </style>
    </head>
   <body class="hold-transition skin-yellow-light fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><img src="img/logo_mini.png" alt="logo" height="50" width="50"></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="img/logo.png" alt="logo" height="50" width="200"></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success"><?php echo count($warning_data); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have <?php echo count($warning_data); ?> messages</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php foreach ($warning_data as $cus) { ?>
                                                <li><!-- start message -->
                                                    <a onclick="detailinfo(<?php echo $cus['management_id']; ?>);">
                                                        <div class="pull-left">
                                                            <img src="dist/img/customer.png" class="img-circle" alt="User Image">
                                                        </div>
                                                        <h4>
                                                            <?php echo $cus['folder_customer_name'] ?>
                                                            <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                                        </h4>
                                                        <p><?php echo $cus['message'] ?></p>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <!-- end message -->
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            
                            <!-- Tasks: style can be found in dropdown.less -->

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="img/avatar3.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION['monitoring_username']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="img/avatar3.png" class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo $_SESSION['monitoring_username']; ?>
                                        </p>
                                    </li>
                                    <!-- /.row -->
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
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/avatar3.png" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $_SESSION['monitoring_username']; ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="uploadNTB.php">
                                <i class="fa fa-upload"></i> <span>Upload New App</span>
                            </a>
                        </li>
                        <?php if ($userrole != 'cc') { ?>
                            <li>
                                <a href="UserSetting/user_setting.php">
                                    <i class="fa fa-edit"></i> <span>User Settings</span>
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

            <div class="content-wrapper">
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
        </div><!-- ./wrapper -->
        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- InputMask -->
        <script src="plugins/input-mask/jquery.inputmask.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- date-range-picker -->
        <script src="js/moment.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- bootstrap color picker -->
        <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
        <!-- bootstrap time picker -->
        <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.js"></script>

        <script src="dist/js/app.min.js"></script>
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>        
<!--        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>  -->
<!--        <script type="text/javascript" src="js/init_table.js"></script>-->
        <script src="js/new_init_table.js"></script>
        <!-- Page script -->

        <script>
            var username = '<?php echo $_SESSION['monitoring_username']; ?>'
            $(document).ready(function() {

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
