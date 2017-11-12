<?php
header("Content-Type: text/html;charset=UTF-8");
// Start the session
session_start();
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
}
?>
<?php
require_once 'lib/dao/VPBankDAO.php';
$vpBank = new VPBankDAO();
$ccChannel = $_SESSION['monitoring_userchannel'];
$ccCode = $_SESSION['monitoring_username'];
$userrole = $_SESSION['monitoring_userrole'];
$date = date("Y-m-d") . " " . "00:00:00";
$uploadPerDay = $vpBank->countUploadPerDay($ccCode, $date, "newapp");
$uploadPerDay = (int) $uploadPerDay[0] + 1;

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Saigon BPO | Upload hồ sơ NTB</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="ionicons-2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="plugins/iCheck/all.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/saigonbpo.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
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
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
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
                        <div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <form role="form" id="adeForm">
                                        <input type="text" id="cc_code" name="cc_code" value="<?php echo $ccCode; ?>" class="hidden" >
                                        <input type="text" id="cc_channel" name="cc_channel" value="<?php echo $ccChannel; ?>" class="hidden" >
                                        <input type="text" id="upload_per_day" name="upload_per_day" value="<?php echo $uploadPerDay; ?>" class="hidden" >
                                        <div class="box-body">
                                            <div class="form-group" id="step1">                                              
                                                <label><strong style="color: #00C0EF;"> 1. Chọn hồ sơ tải:</strong></label>
                                                <!--<input type="file" id="exampleInputFile">-->
                                                <input name="uploadFile" id="uploadFile" type="file" accept=".zip"/>  
                                                <div id="error_block" class="alert alert-danger hidden">
                                                    You will need a recent browser to use this function :(
                                                </div>
                                                <div id="result_block" class="hidden">
                                                    <div id="result"></div>
                                                </div>                                     
                                            </div>
                                            <div class="form-group" id="step2" hidden="true">
                                                <label><strong style="color: #00C0EF;"> 2. Tải hồ sơ:</strong></label>
                                                <input id="uploadNewApp" class="btn btn-info" name="uploadNewApp" value="Tải hồ sơ"/> 

                                            </div>                                            
                                        </div>
                                        <!-- /.box-body -->
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-group">
                                    <img src="img/Naming11.png" alt="naming11">
                                    <img src="img/Naming22.png" alt="naming22">
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>

                    <!--                    <form id="adeForm" enctype = "multipart/form-data" action = "upload_newapp.php" method = "POST"> onsubmit = "return validateNewApp()"
                                            <div id="step1">
                                                <div class="section"><span>1</span>Choose File</div>
                                                <div class="inner-wrap">                                                                                                                                                      
                                                    <input name="uploadFile" id="uploadFile" type="file" accept=".zip"/>   
                                                    <div id="error_block" class="alert alert-danger hidden">
                                                        You will need a recent browser to use this function :(
                                                    </div>
                    
                                                    <div id="result_block" class="hidden">
                                                        <div id="result"></div>
                                                    </div>                                                                           
                                                </div>                                                                        
                                            </div>
                                            <div id="step2" hidden="true">
                                                <div class="section" ><span>2</span>Upload</div>
                                                <div class="inner-wrap">  
                                                    <div class="button-section">
                                                        <input type="submit" id="uploadNewApp" class="bg-saigonbpo" name="uploadNewApp" value="Upload New App"/> 
                                                    </div>                                                                            
                                                </div>
                                            </div>
                                        </form> -->
                </section>                
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; 2016 <a href="http://saigonbpo.vn">Saigon BPO</a>.</strong> 
            </footer>    

        </div>
        <!-- ./wrapper -->
        <script type="text/javascript" src="ziplib/dist/jszip.js"></script>
        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="js/moment.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>        
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="js/uploadNTB.js"></script>

        <script>
        </script>
    </body>
</html>
