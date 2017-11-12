<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Start the session
session_start();

if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: ../login.php");
    exit();
} else {
    $userrole = $_SESSION['monitoring_userrole'];
    $date_range = date('d/m/Y', strtotime(date("Y-m-d") . ' -1 day')) . " - " . date("d/m/Y");
    $current_time = date("H");
    //echo $current_time;die;
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>TAT Report</title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
            <!-- Bootstrap 3.3.6 -->
            <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="../font-awesome-4.6.3/css/font-awesome.min.css">
            <link rel="stylesheet" href="../ionicons-2.0.1/css/ionicons.min.css">
            <!-- daterange picker -->
            <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
            <!-- bootstrap datepicker -->
            <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
            <!-- iCheck for checkboxes and radio inputs -->
            <link rel="stylesheet" href="../plugins/iCheck/all.css">
            <!-- Bootstrap Color Picker -->
            <link rel="stylesheet" href="../plugins/colorpicker/bootstrap-colorpicker.min.css">
            <!-- Bootstrap time Picker -->
            <link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../dist/css/saigonbpo.min.css">
            <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
            <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
            <style>
                .col-lg-3{
                    width:20%;
                }
                .title-progress{
                    font-size:25px !important;
                    margin-bottom: 0 !important;
                    padding-bottom: 0 !important;
                }
                .h3-percen{
                    margin:0 !important;
                }
                .progress.sm{
                    height: 16px;
                }
                .col-lg-7{
                    width: 70%;
                }
                .col-lg-5{
                    width: 30%;
                }
                .col-xs-4{
                    width:20%;
                    margin-bottom: 5px;
                    margin-top: 5px;
                }
                .popbox {
                    display: none;
                    position: absolute;
                    z-index: 99999;
                    width: 165px;
                    padding: 5px;
                    background: #D4D5D1;
                    color: #000000;
                    border: 1px solid #4D4F53;
                    margin: 0px;
                    -webkit-box-shadow: 0px 0px 5px 0px rgba(164, 164, 164, 1);
                    box-shadow: 0px 0px 5px 0px rgba(164, 164, 164, 1);
                    left: -10px;
                    top: 46px;
                }
                .popbox h2
                {
                    background-color: #4D4F53;
                    color:  #E3E5DD;
                    font-size: 14px;
                    display: block;
                    width: 100%;
                    margin: -10px 0px 8px -10px;
                    padding: 5px 10px;
                }
                /*            .box-body{
                                max-height:400px;
                                overflow-y: auto;
                                overflow-x: hidden;
                                padding:1px 10px 10px 10px!important;
                            }*/
                .small-box{
                    margin-bottom:0;
                }
                .small-box h3{
                    font-size: 25px;
                }
                .small-box .icon{
                    font-size: 55px;
                }
                .col-space{
                    padding-left:2px;
                    padding-right:2px;
                }
                .callout{
                    margin:0;
                }
                .callout h4{
                    margin-bottom: 0;
                }
                .bg-success{
                    background-color: #00A65A !important;
                    color:#ffffff;
                }
                .box.box-solid.box-info > .box-header{
                    background-color: #3C8DBC;
                }
                #box_show_result{
                    font-size:20px;font-weight:bold;text-align:center;border:1px solid #CCC;
                }

                /*BACK TO TOP*/
                #bttop{border:1px solid #4adcff;background:#24bde2;text-align:center;padding:5px;position:fixed;bottom:35px;right:10px;cursor:pointer;display:none;color:#fff;font-size:11px;font-weight:900;}
                #bttop:hover{border:1px solid #ffa789;background:#ff6734;}

                /* tables */
                table.tablesorter {
                    font-family:arial;
                    background-color: #CDCDCD;
                    margin:10px 0pt 0px;
                    font-size: 8pt;
                    width: 100%;
                    text-align: left;
                }
                table.tablesorter thead tr th, table.tablesorter tfoot tr th {
                    background-color: #e6EEEE;
                    border: 1px solid #FFF;
                    font-size: 8pt;
                    padding: 4px;
                }
                table.tablesorter thead tr .header {
                    background-image: url(../images/bg.gif);
                    background-repeat: no-repeat;
                    background-position: center right;
                    cursor: pointer;
                }
                .table > thead > tr > th {
                    text-align:center;
                }
                .table > thead > tr > td{
                    line-height:1;
                }
                .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
                    line-height:1;
                    /*width:100%;*/
                }
                table.tablesorter tbody td {
                    color: #3D3D3D;
                    padding: 4px;
                    background-color: #FFF;
                    vertical-align: top;
                    line-height: 0.6px !important;
                }
                table.tablesorter tbody tr.odd td {
                    background-color:#F0F0F6;
                }
                table.tablesorter thead tr .headerSortUp {
                    background-image: url(../images/asc.gif);
                }
                table.tablesorter thead tr .headerSortDown {
                    background-image: url(../images/desc.gif);
                }
                table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
                    background-color: #8dbdd8;
                }

                .col-xs-6{
                    /*float:right;*/
                    /*width:auto;*/
                }
                .daterangepicker.opensright .ranges{
                    /*float:left !important;*/
                }
                .daterangepicker.opensright .calendar.left{
                    float:left;
                }
                .daterangepicker.opensright .calendar.right{
                    float:right;
                }
                .cancelBtn.btn.btn-small{
                    display:none;
                }
                .btn-success.applyBtn.btn.btn-small{
                    width:100%;
                }
                .highlight{
                    background:#EAEAEA;
                }
                .no-print{
                    display:none;
                }

                .hidden {
                    display:none;
                }

                #table-status TD {line-height: 0.05px}
/*                .table-bordered > tbody > thead > tr > td {
                    width: 100%;
                }*/
th, td { white-space: nowrap; overflow: hidden; };
            </style>
        </head>
        <body class="hold-transition skin-yellow-light fixed sidebar-mini">
            <div class="wrapper">
                <header class="main-header">
                    <!-- Logo -->
                    <a href="../index.php" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><img src="../img/logo_mini.png" alt="logo" height="50" width="50"></span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><img src="../img/logo.png" alt="logo" height="50" width="200"></span>
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
                                                                <img src="../dist/img/customer.png" class="img-circle" alt="User Image">
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
                                        <img src="../img/avatar3.png" class="user-image" alt="User Image">
                                        <span class="hidden-xs"><?php echo $_SESSION['monitoring_username']; ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <li class="user-header">
                                            <img src="../img/avatar3.png" class="img-circle" alt="User Image">

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
                                <img src="../img/avatar3.png" class="img-circle" alt="User Image">
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
                                <a href="../uploadNTB.php">
                                    <i class="fa fa-upload"></i> <span>Upload New App</span>
                                </a>
                            </li>
                            <?php if ($userrole != 'cc') { ?>
                                <li>
                                    <a href="../UserSetting/user_setting.php">
                                        <i class="fa fa-edit"></i> <span>User Settings</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($userrole == 'admin' || $userrole == 'subadmin') { ?>
                                <li>
                                    <a href="../report/report_tat.php">
                                        <i class="fa fa-dashboard"></i> <span>Report TAT</span>
                                    </a>
                                </li>                           
                            <?php } ?>                         
                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>                
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Main content -->
                    <section class="content">

                        <!-- Main row -->
                        <div class="row">
                            <!-- Left col -->
                            <section class="col-lg-12">                            
                                <div class="box box-info">
                                    <form action="" method="POST" name="frmFilter" id="frmFilter">
                                        <div class="box-body border-radius-none">
                                            <span style="margin-left:10px;">From - To: </span>
                                            <!--<i class="fa fa-clock-o"></i>-->
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" id="txtDate" name="txtDate"  style="border:1px solid #CCCCCC;width:16%;height:20px;"/>
                                            <select onchange="changeInputType(this)" id="slType" name="slType" style="border:1px solid #CCCCCC;width:10%;height:20px;">
                                                <option value="3">Hourly Report</option>
                                                <!--                                                <option value="4">Average TAT Report</option>
                                                                                                <option value="5">Daily Resource</option>
                                                                                                <option value="6">Hourly Downloaded Amount</option>
                                                                                                <option value="7">Hourly User Amount</option>
                                                                                                <option value="8">Status</option>-->
                                                <!--<option value="2">Ticket</option>-->
                                            </select>
                                            <input class="btn btn-success btn-sm" type="button"  value="Load" id="btnFilter" name="btnFilter" 
                                                   onclick="return filter();" style="width:10%;margin-left:10px;margin-top: -3px;height:25px;padding:0;width:100px;"/>
                                            <input class="btn btn-success btn-sm" type="button"  value="Send Mail" id="btnSendMail" name="btnSendMail" 
                                                   onclick="return sendmail();" style="width:10%;margin-left:10px;margin-top: -3px;height:25px;padding:0;width:100px;"/>                                                                                        
                                        </div>
                                    </form>
                                    <form method="POST" enctype="multipart/form-data" action="../testmail.php" id="myForm">
                                        <input type="hidden" name="img_val_tbl_st" id="img_val_tbl_st" value="" />
                                        <input type="hidden" name="img_val_hourly_amount" id="img_val_hourly_amount" value="" />
                                        <input type="hidden" name="img_val_hourly_user" id="img_val_hourly_user" value="" />
                                    </form>                                     
                                </div>
                            </section>
                        </div> <!--/.row-->
                        <!-- Main row -->

                        <!-- Status report -->
                        <div class="row">

                            <div class="col-md-12">
                                <div id="capture">
                                    <div id="table_pending"></div>
                                    <div id="report-content"> </div>                                
                                </div>
                            </div>  

                        </div>

                        <!-- Table and chart 1 -->
                        <div class="row">
                            <div class="col-md-12">
                                <div id="report-content-1" class="table_chart hidden"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chart_div_1" class="chart_report" style="padding-top:30px;"></div>
                            </div>
                        </div>

                        <!-- Table and chart 2 -->
                        <div class="row">
                            <div class="col-md-12">
                                <div id="report-content-2" class="table_chart hidden"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chart_div_2" class="chart_report" style="padding-top:30px;"></div>
                            </div>
                        </div>

                        <!-- Table and chart 3 -->
                        <div class="row">
                            <div class="col-md-12">
                                <div id="report-content-3" class="table_chart hidden"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chart_div_3" class="chart_report" style="padding-top:30px;"></div>
                            </div>
                        </div> 

                        <!-- Table and chart 4 -->
                        <div class="row">
                            <div id="report-content-4" class="table_chart hidden"></div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chart_div_4" class="chart_report" style="padding-top:30px;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div id='bttop'>BACK TO TOP ^</div>
                        </div>
                    </section><!-- /.content -->

                </div><!-- ./wrapper -->
                <!-- /.content-wrapper -->
                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 1.0
                    </div>
                    <strong>Copyright &copy; 2016 <a href="http://saigonbpo.vn">Saigon BPO</a>.</strong> 
                </footer>
                <!-- /.control-sidebar -->
                <!-- Add the sidebar's background. This div must be placed
                     immediately after the control sidebar -->
                <div class="control-sidebar-bg"></div>
            </div>
            <!-- ./wrapper -->

            <!-- jQuery 2.2.3 -->
            <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
            <!-- Bootstrap 3.3.6 -->
            <script src="../bootstrap/js/bootstrap.min.js"></script>
            <!-- InputMask -->
            <script src="../plugins/input-mask/jquery.inputmask.js"></script>
            <script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
            <script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
            <!-- date-range-picker -->
            <script src="../js/moment.js"></script>
            <script src="../plugins/daterangepicker/daterangepicker.js"></script>
            <!-- bootstrap datepicker -->
            <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
            <!-- bootstrap color picker -->
            <script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
            <!-- bootstrap time picker -->
            <script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
            <!-- SlimScroll 1.3.0 -->
            <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
            <!-- iCheck 1.0.1 -->
            <script src="../plugins/iCheck/icheck.min.js"></script>
            <!-- FastClick -->
            <script src="../plugins/fastclick/fastclick.js"></script>

            <script src="../dist/js/app.min.js"></script>
            <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
            <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>        
    <!--        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>  -->
    <!--        <script type="text/javascript" src="js/init_table.js"></script>-->
            <script src="../js/new_init_table.js"></script>

            <!--            [if lt IE 9]>
                            <script src="js/jquery-1.11.2.min.js"></script>
                                                <![endif]
                        [if gte IE 9]>
                            <script src="js/jquery-1.11.2.min.js"></script>
            <!--<![endif]

            <script src="../js/jquery-1.11.2.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>

             daterangepicker 
            <script src="../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
            <script src="../js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

             AdminLTE App 
            <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

             AdminLTE for demo purposes 
            <script src="../js/AdminLTE/demo.js" type="text/javascript"></script>-->
            <script type="text/javascript" src="http://www.google.com/jsapi?ext.js"></script>
            <script type="text/javascript">

                                                       // Load the Visualization API library and the piechart library.
                                                       //            google.load('visualization', '1', {'packages':['corechart']});
                                                       //            google.setOnLoadCallback(drawChart);
                                                       // ... draw the chart...
            </script>
            <script type="text/javascript" src="../js/html2canvas.js"></script>
            <script type="text/javascript" src="../js/jquery.plugin.html2canvas.js"></script>            
            <!-- DATA TABES SCRIPT -->
            <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
            <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
            <script src="../js/chart_func_helper.js" type="text/javascript"></script>
            <script src="../js/date_util.js"></script>
            <script type="text/javascript">
                                                       img_val_tbl_st = null;
                                                       img_val_hourly_amount = null;
                                                       img_val_hourly_user = null;
                                                       current_time = <?php echo json_encode($current_time); ?>;
                                                       // Load google api
                                                       google.load("visualization", "1.1", {
                                                           packages: ["line", "corechart", 'bar', "table"]
                                                       });

                                                       var waitingDialog = waitingDialog || (function ($) {
                                                           'use strict';
                                                           var $dialog = $(
                                                                   '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
                                                                   '<div class="modal-dialog modal-m">' +
                                                                   '<div class="modal-content">' +
                                                                   '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
                                                                   '<div class="modal-body">' +
                                                                   '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
                                                                   '</div>' +
                                                                   '</div></div></div>');
                                                           return {
                                                               show: function (message, options) {
                                                                   // Assigning defaults
                                                                   if (typeof options === 'undefined') {
                                                                       options = {};
                                                                   }
                                                                   if (typeof message === 'undefined') {
                                                                       message = 'Loading';
                                                                   }
                                                                   var settings = $.extend({
                                                                       dialogSize: 'm',
                                                                       progressType: '',
                                                                       onHide: null // This callback runs after the dialog was hidden
                                                                   }, options);

                                                                   // Configuring dialog
                                                                   $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
                                                                   $dialog.find('.progress-bar').attr('class', 'progress-bar');
                                                                   if (settings.progressType) {
                                                                       $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                                                                   }
                                                                   $dialog.find('h3').text(message);
                                                                   // Adding callbacks
                                                                   if (typeof settings.onHide === 'function') {
                                                                       $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                                                                           settings.onHide.call($dialog);
                                                                       });
                                                                   }
                                                                   // Opening dialog
                                                                   $dialog.modal();
                                                               },
                                                               hide: function () {
                                                                   $dialog.modal('hide');
                                                               }
                                                           };
                                                       })(jQuery);
                                                       function filter() {
    //                                                           $("#slType").val("3");
    //                                                           $('#txtDate').datepicker('update', new Date());
                                                           var type = $("#slType").val();
                                                           $(".table_chart").empty();
                                                           $(".chart_report").empty();
                                                           switch (type) {
                                                               case "1" :
                                                                   drawTableAndChart("1");
                                                                   break;
                                                               case "2" :
                                                                   // Draw table status
                                                                   drawStatusTable();

                                                                   // Draw table daily Amount (Each Product)
                                                                   drawTableAndChart("2");

                                                                   // Draw table Daily Amount (Monthly)
                                                                   drawTableAndChart("3");
    <?php if ($_SESSION['monitoring_userrole'] == "admin") { ?>
                                                                       //Average TAT Report 
                                                                       //                                drawTableAndChart("4");

                                                                       // Daily Resource
                                                                       //drawTableAndChart("5");
    <?php } ?>
                                                                   break;
                                                               case "3" :
                                                                   // Draw table status
                                                                   drawStatusTable();

                                                                   // Draw table Hourly Downloaded Amount (Line Chart)
                                                                   img_val_hourly_amount = drawTableAndChart("6");

                                                                   // Draw table Hourly User Amount (Column Chart)
                                                                   //img_val_hourly_user = drawTableAndChart("7");
                                                                   break;

                                                           }


                                                       }

                                                       function drawTableAndChart(report_type) {

                                                           console.log("draw chart : " + report_type);
                                                           var report_div, table_id;
                                                           var rowData = [];
                                                           var header = [];
                                                           var element_size;
                                                           var table_str;
                                                           var days_header = [];
                                                           switch (report_type) {
                                                               case "1": // TAT Report
                                                                   table_str = '<table id="table-report" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>No.</th>         <th>Content</th>         <th>PL Normal</th>         <th>PL Mobile</th>    <th>PL Pre</th>     <th>CRC Pre</th>        <th>QDE Normal</th> <th>QDE Mobile</th>  <th>QDE PL Pre</th>  <th>QDE CRC Pre</th>   </tr>   </thead></table>';
                                                                   report_div = "report-content";
                                                                   table_id = "table-report";
                                                                   element_size = 30;
                                                                   break;
                                                               case "2": // Daily Amount (Each Product) (Column Chart)
                                                                   header = ['Type', 'Amount'];
                                                                   table_str = '<table id="table-report-1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>Type</th>         <th>Amount</th>      </tr>   </thead></table>';
                                                                   report_div = "report-content-1";
                                                                   table_id = "table-report-1";
                                                                   element_size = 5;
                                                                   break;
                                                               case "3": // Daily Amount (Monthly)    (Line Chart)
                                                                   var header_title = ['Type'];
                                                                   table_str = '<table id="table-report-2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>      <th>Type</th> ';
                                                                   var report_date = new Date($('#txtDate').val());
                                                                   days_header = getDaysInMonth(report_date.getMonth(), report_date.getFullYear());
                                                                   console.log("days_header : " + days_header);
                                                                   for (var i = 0; i < days_header.length; i++) {
                                                                       //                                                                           console.log("date : " + days_header[i]); 
                                                                       table_str += '<th>' + days_header[i] + '</th>';
                                                                       header_title.push(days_header[i]);
                                                                   }
                                                                   table_str += ' </tr>   </thead></table>';

                                                                   // Create header for chart table build
                                                                   header = header_title;
                                                                   report_div = "report-content-2";
                                                                   table_id = "table-report-2";
                                                                   element_size = 3;
                                                                   break;
                                                               case "4": // Average TAT Report  (Combo Chart)
                                                                   var header_title = ['Type', 'Average TAT', 'Standard TAT'];
                                                                   table_str = '<table id="table-report-3" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>Type</th>         <th>Average TAT</th>         <th>Standard TAT</th> </tr>   </thead></table>';
                                                                   report_div = "report-content-3";
                                                                   table_id = "table-report-3";
                                                                   header = header_title;
                                                                   report_div = "report-content-3";
                                                                   table_id = "table-report-3";
                                                                   element_size = 5;
                                                                   break;
                                                               case "5": // Daily Resource  (Line Chart)
                                                                   report_div = "report-content-4";
                                                                   table_id = "table-report-4";
                                                                   break;
                                                               case "6": // Hourly Downloaded Amount (Line Chart)
                                                                   table_str = '<table id="table-report-1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>Time</th>         <th>PL_Normal</th>         <th>PL_Mobile</th>    <th>QDE_Normal</th>   <th>QDE_Mobile</th>         <th>QDE_PL_PreApprove</th>         <th>QDE_CRC_PreApprove</th>    <th>PL Pre-Approve</th>  <th>CRC Pre-Approve</th>  </tr>   </thead></table>';

                                                                   // Create header for chart table build
                                                                   header = ['Time', 'PL_Normal', 'PL_Mobile', 'QDE_Normal', 'QDE_Mobile', 'QDE_PL_PreApprove', 'QDE_Pega', 'PL Pre-Approve', 'PL Pega'];
                                                                   //buildHoursColumn();
                                                                   report_div = "report-content-1";
                                                                   table_id = "table-report-1";
                                                                   break;
                                                               case "7": // Hourly User Amount (Column Chart)
                                                                   table_str = '<table id="table-report-2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>Time</th>         <th>Fixed Users</th>         <th>Support Users</th> </thead></table>';

                                                                   // Create header for chart table build
                                                                   header = ['Time', 'Fixed Users', 'Support Users'];
                                                                   //buildHoursColumn();
                                                                   report_div = "report-content-2";
                                                                   table_id = "table-report-2";
                                                                   break;
                                                                   /*                   case "8": // Status
                                                                    table_str = '<table id="table-report" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>No.</th>         <th>Type</th>         <th>Status</th>         <th>09:00</th>         <th>10:00</th>         <th>11:00</th>         <th>12:00</th>         <th>13:00</th>         <th>14:00</th>         <th>15:00</th>         <th>16:00</th>         <th>17:00</th>         <th>18:00</th>         <th>19:00</th>         <th>20:00</th>         <th>21:00</th>         <th>22:00</th>	  <th>Sum</th>     </tr>   </thead></table>';
                                                                    report_div = "report-content";
                                                                    table_id = "table-report";
                                                                    element_size = 30;
                                                                    break; */


                                                           }
                                                           $('#' + report_div).html(table_str);

                                                           var data_table = $('#' + table_id).DataTable({
                                                               "ajax": {
                                                                   "url": "data_report.php",
                                                                   "type": "POST",
                                                                   "pagingType": "full_numbers",
                                                                   "data": function (d) {
                                                                       d.date = $('#txtDate').val();
                                                                       d.report_type = report_type;
                                                                       d.days_month = days_header;

                                                                   }
                                                               },
                                                               "bSort": false,
                                                               "bFilter": false,
                                                               "deferRender": true,
                                                               "scrollX": true,
                                                               "bAutoWidth": false,
                                                               'paging': false,
                                                               "fnCreatedRow": function (nRow, aData, iDataIndex) {
                                                                   var row = [];
                                                                   var reset_sum = false;
                                                                   $(nRow).find('td').each(function (index) {
                                                                       var $th = $("#table-report thead tr th").eq($(this).index());

                                                                       //                                          //console.log("index : " + index);  
                                                                       //if (report_type == "1" || )
                                                                       //console.log("data : " + !aData[index]);
                                                                       if (isNaN(aData[index])) {
                                                                           //                                                                                    if (aData[index].length > 0 && typeof aData[index] != 'object')
                                                                           row.push(aData[index]);
                                                                           //                                                                                    else
                                                                           //                                                                                        row.push('');
                                                                       } else {
                                                                           //                                                                                    if (report_type == "1" || report_type == "1" || report_type == "1")
                                                                           //                                                                                        row.push(parseInt(aData[index]));
                                                                           //                                                                                    else
                                                                           row.push(parseFloat(aData[index]).round(2));
                                                                       }

                                                                   });
                                                                   rowData.push(row);
                                                                   //                                  
                                                                   //                                                                            console.log("index :" + iDataIndex);

                                                               },
                                                               "fnInitComplete": function (oSettings, json) {

                                                                   switch (report_type) {
                                                                       case "1": // TAT Report

                                                                           break;
                                                                       case "2": // Daily Amount (Each Product) (Column Chart)
                                                                           $('#chart_div_1').empty();
                                                                           if (oSettings.aoData.length > 0)
                                                                               drawColumnChart(header, rowData, "DAILY AMOUNT OF EACH PRODUCT", "chart_div_1");
                                                                           break;
                                                                       case "3": // Daily Amount (Monthly)    (Line Chart)
                                                                           var report_date = new Date($('#txtDate').val());
                                                                           var month = report_date.getMonth() + 1;
                                                                           if (month < 10)
                                                                               month = '0' + month;
                                                                           var time_title = month + "/" + report_date.getFullYear();
                                                                           //console.log("rowdata : " + rowData);
                                                                           //console.log("title : " + time_title);
                                                                           $('#chart_div_2').empty();
                                                                           if (oSettings.aoData.length > 1)
                                                                               drawLineChart(header, rowData, "DAILY AMOUNT OF APPS" + " - " + time_title, "chart_div_2", report_type);
                                                                           break;
                                                                       case "4": // Average TAT Report  (Combo Chart)
                                                                           $('#chart_div_3').empty();
                                                                           if (oSettings.aoData.length > 0)
                                                                               drawComboChart(header, rowData, "AVERAGE TAT", "chart_div_3");
                                                                           break;
                                                                       case "5": // Daily Resource  (Line Chart)
                                                                           $('#chart_div_4').empty();
                                                                           if (oSettings.aoData.length > 0)
                                                                               drawLineChart(header, rowData, "DAILY RESOURCE", "chart_div_4");
                                                                           break;
                                                                       case "6": // Hourly Downloaded Amount (Line Chart)
                                                                           $('#chart_div_2').empty();
                                                                           if (oSettings.aoData.length > 0) {
                                                                               //buildHoursColumn();
                                                                               drawLineChart_test6(header, rowData, "HOURLY AMOUNT", "chart_div_2");
                                                                           }
                                                                           break;
                                                                       case "7": // Hourly User Amount (Column Chart)
                                                                           $('#chart_div_3').empty();
                                                                           if (oSettings.aoData.length > 0) {
                                                                               //buildHoursColumn();
                                                                               drawLineChart_test7(header, rowData, "AMOUNT OF USERS", "chart_div_3");
                                                                           }
                                                                           break;
                                                                   }

                                                               }
                                                           });
                                                       }

                                                       // Chương trình sẽ chạy ngay lần đầu vào trang home
                                                       $(document).ready(function () {
                                                           //filter();
                                                       });

                                                       $(function () {
                                                           $('#txtDate').datepicker({format: 'yyyy-mm-dd', autoclose: true, "setDate": new Date()});
                                                           $('#txtDate').datepicker('update', new Date());
                                                       });


                                                       $(document).ajaxComplete(function (event, request, settings) {
                                                           var SupportDiv = document.getElementById('report-content');
                                                           //Scroll to location of SupportDiv on load
                                                           window.scroll(0, findPos(SupportDiv));
                                                       });

                                                       function findPos(obj) {
                                                           var curtop = 0;
                                                           if (obj.offsetParent) {
                                                               do {
                                                                   curtop += obj.offsetTop;
                                                               } while (obj = obj.offsetParent);
                                                               return [curtop];
                                                           }
                                                       }

                                                       function changeInputType(sel) {
                                                           if (sel.value == "1") {
                                                               console.log("select");
                                                               // remove datepicker
                                                               $('#txtDate').datepicker('remove');
                                                               $('#txtDate').daterangepicker({
                                                                   format: 'DD/MM/YYYY'
                                                               });
                                                               document.getElementById('txtDate').value = '<?php echo $date_range ?>';
                                                           } else {
                                                               if ($('#txtDate').data('daterangepicker')) {
                                                                   $('#txtDate').data('daterangepicker').container.remove();
                                                                   $('#txtDate').data('daterangepicker', null);
                                                               }
                                                               $('#txtDate').datepicker({format: 'yyyy-mm-dd', autoclose: true, "setDate": new Date()});
                                                               $('#txtDate').datepicker('update', new Date());
                                                           }

                                                       }

                                                       function drawStatusTable() {
                                                           newapp_pending = 0;
                                                           qde_newapp_pending = 0;
                                                           new_pre_pending = 0;
                                                           qde_new_pre_pending = 0;
														   pega_pending = 0;
                                                           qde_pega_pending = 0;
                                                           $('#report-content').html('<table id="table-status" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>No.</th>         <th>Type</th>         <th>Status</th>         <th>09:00</th>         <th>10:00</th>         <th>11:00</th>         <th>12:00</th>         <th>13:00</th>         <th>14:00</th>         <th>15:00</th>         <th>16:00</th>         <th>17:00</th>         <th>18:00</th>         <th>19:00</th>         <th>20:00</th>         <th>21:00</th>         <th>22:00</th>	  <th>Sum</th>     </tr>   </thead></table>');
                                                           var table = $('#table-status').DataTable({
                                                               "ajax": {
                                                                   "url": "data_report.php",
                                                                   "type": "POST",
                                                                   "pagingType": "full_numbers",
                                                                   "data": function (d) {
                                                                       d.date = $('#txtDate').val();
                                                                       d.report_type = "8";

                                                                   }
                                                               },
                                                               "bSort": false,
                                                               "bFilter": false,
                                                               "bInfo": false,
                                                               "deferRender": true,
                                                               "scrollX": true,
                                                               "bAutoWidth": true,
                                                               'paging': false,
                                                               "aoColumns": [
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '5%'},
                                                                   {sWidth: '5%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'},
                                                                   {sWidth: '1%'}
                                                               ],
                                                               "columnDefs": [
                                                                   {"width": "20%", "targets": 1}
                                                               ],
                                                               "fnCreatedRow": function (nRow, aData, iDisplayIndex) {
                                                                   var row = [];
                                                                   var reset_sum = false;
                                                                   $(nRow).find('td').each(function (index) {
                                                                       $(this).attr("rowspan", 1);
                                                                       var $th = $("#table-status thead tr th").eq($(this).index());
                                                                       if ($(this).text() == "Min TAT Done" || $(this).text() == "Max TAT Done" || $(this).text() == "AVERAGE TAT")
                                                                           reset_sum = true;
                                                                       if ($th.text() == "Sum" && reset_sum == true)
                                                                           $(this).text("");
                                                                   });
                                                               },
                                                               "drawCallback": function (oSettings) {
                                                                   $('#table-status').each(function () {

                                                                       var dimension_cells = new Array();
                                                                       var dimension_col = null;
                                                                       var columnTitle = "Type";

                                                                       var i = 0;

                                                                       $(this).find('th').each(function () {
                                                                           //console.log("$(this).html().trim() : " + $(this).find(">:first-child").text());
                                                                           if ($(this).find(">:first-child").text().trim() == columnTitle) {
                                                                               dimension_col = i;
                                                                           }
                                                                           i++;
                                                                       });

                                                                       //console.log("dimension_col : " + dimension_col);

                                                                       var first_instance = null;

                                                                       $(this).find('tr').each(function () {

                                                                           var dimension_td = $(this).find('td').eq(dimension_col);

                                                                           if (first_instance == null) {
                                                                               first_instance = dimension_td;
                                                                           } else if (dimension_td.text() == first_instance.text()) {

                                                                               dimension_td.remove();

                                                                               first_instance.attr('rowspan', parseInt(first_instance.attr('rowspan'), 10) + 1);
                                                                           } else {
                                                                               first_instance = dimension_td;
                                                                           }

                                                                       });
                                                                   });
                                                                   var api = this.api();
                                                                   data = api.column(17).data();
                                                                   newapp_pending = parseInt(data[2]) + parseInt(data[8]) + parseInt(data[14]) + parseInt(data[20]);
                                                                   qde_newapp_pending = parseInt(data[38]) + parseInt(data[44]);
                                                                   new_pre_pending = parseInt(data[26]);
                                                                   qde_new_pre_pending = parseInt(data[50]);
																   pega_pending = parseInt(data[32]);
                                                                   qde_pega_pending = parseInt(data[56]);

                                                                   var data = new google.visualization.DataTable();
                                                                   data.addColumn('string', 'Type');
                                                                   data.addColumn('number', 'Pending Total');
                                                                   data.addRows([
                                                                       ['PL', newapp_pending],
                                                                       ['QDE PL', qde_newapp_pending],
                                                                       ['Pre TOPUP', new_pre_pending],
                                                                       ['QDE Pre TOPUP', qde_new_pre_pending],
																	   ['PL PEGA', pega_pending],
                                                                       ['QDE PEGA', qde_pega_pending]  
                                                                   ]);


                                                                   var table = new google.visualization.Table(document.getElementById('table_pending'));

                                                                   table.draw(data, {showRowNumber: true, width: '20%', height: '100%'});

    //                                                                               console.log(newapp_pending);
    //                                                                               console.log(qde_newapp_pending);
    //                                                                               console.log(new_pre_pending);
    //                                                                               console.log(qde_new_pre_pending);

                                                               },
                                                               "fnRowCallback": function (nRow, aData, iDisplayIndex) {

                                                                   var num = Math.ceil(parseInt(aData[0]) / 6);
                                                                   //console.log("id : " + aData[0] + " num : " + num + " division 2 : " + num % 2);

                                                                   $(nRow).find('td').each(function (colIndex) {
                                                                       var $th = $("#table-status thead tr th").eq($(this).index());
                                                                       if ($th.text() == "Sum") {
                                                                           $(this).css({"background-color": "#79C753"});
                                                                       } else {
                                                                           if (num % 2 != 0) {
                                                                               $(this).css({"background-color": "#FFE9E9"});
                                                                           } else {
                                                                               //$(this).css({"background-color": "#F9F9F9"});
                                                                           }
                                                                       }

                                                                   });

                                                               }

                                                           });

                                                           var column_id = table.column(0);
                                                           column_id.visible(false);
                                                           for (var i = parseInt(current_time) - 4; i < 17; i++) {
                                                               var column_id = table.column(i);
                                                               column_id.visible(false);
                                                           }
                                                       }

                                                       if ($(window).width() <= 992) {
                                                           $('.row-offcanvas').toggleClass('active');
                                                           $('.left-side').removeClass("collapse-left");
                                                           $(".right-side").removeClass("strech");
                                                           $('.row-offcanvas').toggleClass("relative");
                                                       } else {
                                                           //Else, enable content streching
                                                           $('.left-side').toggleClass("collapse-left");
                                                           $(".right-side").toggleClass("strech");
                                                       }

                                                       function drawLineChart_test6(header, rowData, title, chart_div, rpt_type) {
    //console.log(rowData);
                                                           var data = new google.visualization.DataTable();
                                                           for (var i = 0; i < header.length; i++) {
                                                               if (i == 0)
                                                                   data.addColumn('string', header[i]);
                                                               else
                                                                   data.addColumn('number', header[i]);
                                                           }
                                                           data.addRows(rowData);
                                                           var options = {
                                                               title: title,
                                                               pointSize: 4,
                                                               height: 400,
                                                               backgroundColor: {'fill': '#f9f9f9'},
                                                               hAxis: {
                                                                   title: ""
                                                               },
    //        lineWidth: 3,
    //          colors: ['#0000CC', '#CC0000', '#CC9900'],        
                                                               tooltip: {textStyle: {color: '#000000'}, showColorCode: true},
                                                               'chartArea': {
                                                                   'backgroundColor': {
                                                                       'fill': '#f9f9f9'
                                                                   },
                                                                   width: "85%"
                                                               },
                                                               theme: 'material'
                                                           };
                                                           var transposedData;
                                                           if (rpt_type == "3" || rpt_type == "5")
                                                               transposedData = transposeDataTable(data);
                                                           else
                                                               transposedData = data;
                                                           var chart = new google.visualization.LineChart(document.getElementById(chart_div));
                                                           google.visualization.events.addListener(chart, 'ready', function () {
                                                               chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                                                               //console.log(chart.getImageURI());
                                                               //img_val_hourly_amount = '<img src="' + chart.getImageURI() + '">';
                                                               $('#img_val_hourly_amount').val('<img src="' + chart.getImageURI() + '">');
    //                //Submit the form manually
    //                document.getElementById("myForm").submit();        

                                                           });
                                                           chart.draw(transposedData, options);
                                                           $(window).smartresize(function () {
                                                               chart.draw(transposedData, options);
                                                           });

                                                       }

                                                       function drawLineChart_test7(header, rowData, title, chart_div, rpt_type) {
                                                           console.log(rowData);
                                                           var data = new google.visualization.DataTable();
                                                           for (var i = 0; i < header.length; i++) {
                                                               if (i == 0)
                                                                   data.addColumn('string', header[i]);
                                                               else
                                                                   data.addColumn('number', header[i]);
                                                           }
                                                           data.addRows(rowData);
                                                           var options = {
                                                               title: title,
                                                               pointSize: 4,
                                                               height: 400,
                                                               backgroundColor: {'fill': '#f9f9f9'},
                                                               hAxis: {
                                                                   title: ""
                                                               },
    //        lineWidth: 3,
    //          colors: ['#0000CC', '#CC0000', '#CC9900'],        
                                                               tooltip: {textStyle: {color: '#000000'}, showColorCode: true},
                                                               'chartArea': {
                                                                   'backgroundColor': {
                                                                       'fill': '#f9f9f9'
                                                                   },
                                                                   width: "85%"
                                                               },
                                                               theme: 'material'
                                                           };
                                                           var transposedData;
                                                           if (rpt_type == "3" || rpt_type == "5")
                                                               transposedData = transposeDataTable(data);
                                                           else
                                                               transposedData = data;
                                                           var chart = new google.visualization.LineChart(document.getElementById(chart_div));
                                                           google.visualization.events.addListener(chart, 'ready', function () {
                                                               chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                                                               //console.log(chart.getImageURI());
                                                               //img_val_hourly_amount = '<img src="' + chart.getImageURI() + '">';
                                                               $('#img_val_hourly_user').val('<img src="' + chart.getImageURI() + '">');
    //                //Submit the form manually
    //                document.getElementById("myForm").submit();        

                                                           });
                                                           chart.draw(transposedData, options);
                                                           $(window).smartresize(function () {
                                                               chart.draw(transposedData, options);
                                                           });

                                                       }

                                                       function sendmail() {
                                                           waitingDialog.show('Đang xử lý...');
                                                           $('#capture').html2canvas({
                                                               useCORS: true,
                                                               onrendered: function (canvas) {
                                                                   //Set hidden field's value to image data (base-64 string)
                                                                   //alert(canvas.toDataURL("image/png"));                
                                                                   $('#img_val_tbl_st').val('<img src="' + canvas.toDataURL("image/jpg") + '" />');
                                                                   //Submit the form manually
                                                                   document.getElementById("myForm").submit();
                                                                   waitingDialog.hide();
                                                               }
                                                           });
                                                           //document.getElementById("myForm").submit();
                                                       }
            </script>

        </body>
    </html>
    <?php
}
?>