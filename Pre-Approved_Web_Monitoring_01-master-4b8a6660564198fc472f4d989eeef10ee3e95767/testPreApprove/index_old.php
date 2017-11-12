<?php
// Start the session
session_start();
require_once 'model/User.php';

$user = new User ();
$userInfo = null;
$userrole = null;
$userchannel = null;
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
} else {
    if ($_SESSION['monitoring_username'] != "admin" && $_SESSION['insecure_pass'] == "true") {
        header("Location: profile.php");
        exit();
    }
    require_once 'lib/dao/VPBankDAO.php';
    $vpBank = new VPBankDAO();
    $userInfo = $user->getRole($_SESSION ['monitoring_username']);
    $userrole = $userInfo[1];
    $userchannel = $userInfo[2];
    $useremail = $userInfo[3];
    $usercompany = $userInfo[4];
    $_SESSION['monitoring_userrole'] = $userrole;
    $_SESSION['monitoring_userchannel'] = $userchannel;
    $_SESSION['useremail'] = $useremail;
    $_SESSION['usercompany'] = $usercompany;
    $_SESSION['userid'] = $userInfo[0];

    $date_range = null;
    if (isset($_GET['txtDate'])) {
        $date_range = $_GET['txtDate'];
    }
    if ($date_range == null) {
        $date_range = date('d/m/Y', strtotime(date("Y-m-d") . ' -1 day')) . " - " . date("d/m/Y");
    }
}
?>
<!DOCTYPE html">
<html>    
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />         
        <title>SAIGON BPO's Monitoring System | HOME</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!--<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <!--<link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
        <!--<link href="css/ionic.min.css" rel="stylesheet" type="text/css" />-->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- DATA TABLES -->
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!--<link href="css/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css" />-->
        <link href="css/monitoring_vpb.css" rel="stylesheet" type="text/css" />

        <script src="js/timeout.js" type="text/javascript"></script>


    </head>
    <body class="skin-blue" style="min-height:100%;" onload="StartTimers();" onmousemove="ResetTimers();">
        <!-- header logo: style can be found in header.less -->
        <!--<div id="top-header">-->
        <header class="header">
            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <!--Monitoring System-->
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->

                <div class="navbar-center">
                    <ul class="">
                        <li class="active">
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span> Home</span>
                            </a>
                        </li>
                        <!--                            <li>
                                                        <a href="profile.php">
                                                            <i class="fa fa-dashboard"></i> <span>Profile</span>
                                                        </a>
                                                    </li>-->
                        <li>
                            <a href="listqde.php">
                                <i class="fa fa-dashboard"></i> <span>QDE History</span>
                            </a>
                        </li>     
                        <!--                            <li>
                                                        <a href="listticket.php">
                                                            <i class="fa fa-dashboard"></i> <span>My Ticket</span>
                                                        </a>
                                                    </li>-->
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
                </div>                    

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
                                    <p>
                                        <?php echo $_SESSION['monitoring_username']; ?>
                                        <small></small>
                                    </p>
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
        <!--</div>-->
        <div id="content" style="position: relative; margin-top: 50px;">
            <div class="wrapper row-offcanvas row-offcanvas-left">
                <!-- Left side column. contains the logo and sidebar -->

                <!-- Right side column. Contains the navbar and content of the page -->
                <aside class="right-side">

                    <!-- Main content -->
                    <section class="content">

                        <!-- Main row -->
                        <div class="row">
                            <!-- Left col -->
                            <section class="col-lg-12">                            
                                <div class="box box-info">
                                    <form action="exportexcel/export_performance.php" method="POST" name="frmFilter" id="frmFilter">
                                        <!--<form action="exportexcel/export.php" method="POST" name="frmFilter" id="frmFilter">-->    
                                        <div class="box-body border-radius-none">
                                            <span style="margin-left:10px;">From - To: </span>
                                            <!--<i class="fa fa-clock-o"></i>-->
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" value="<?php echo $date_range; ?>" id="txtDate" name="txtDate"  style="border:1px solid #CCCCCC;width:16%;height:20px;"/>
                                            <select onchange="" id="slType" name="slType" style="border:1px solid #CCCCCC;width:10%;height:20px;">
                                                <option value="1">New App</option>
                                                <option value="2">QDE</option>
                                                <option value="3">PL PreApprove</option>
                                                <option value="6">CRC PreApprove</option>
                                                <option value="5">Mobile-NewApp</option>
                                                <option value="4">Mobile-QDE</option>
                                            </select>
                                            <input class="btn bg-green btn-sm" type="button"  value="Load" id="btnFilter" name="btnFilter" 
                                                   onclick="return filter();" style="width:10%;margin-left:10px;margin-top: -3px;height:25px;padding:0;width:100px;"/>
                                                   <?php if ($userrole != 'cc') : ?>  
                                                <input class="btn bg-saigonbpo btn-sm" type="submit"  value="Export to Excel" id="btnExport" name="btnExport" 
                                                       style="width:10%;margin-left:10px;margin-top: -3px;height:25px;padding:0;width:100px;"/>                                        
                                                   <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div> <!--/.row-->
                        <!-- Main row -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <div id="tablescroll" class="nav-tabs-custom">
                                    <ul id="tab-display" class="nav nav-tabs" style="background:#e4ffde;">
                                        <li><a id="general" href="#tab_general" data-toggle="tab">General</a></li>
                                        <li class="active"><a id="details" href="#tab_details" data-toggle="tab">Details</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="tab_general">
                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane active" id="tab_details">
                                        </div><!-- /.tab-pane -->
                                        <!--<div class="tab-pane" id="tab_3">-->
                                        <!--                                    </div> /.tab-pane -->
                                    </div><!-- /.tab-content -->
                                </div><!-- nav-tabs-custom -->
                            </div><!-- /.col -->
                        </div>

<!--                        <div class="row">
                            <div id='bttop'>BACK TO TOP ^</div>
                        </div>-->
                    </section><!-- /.content -->
                </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->
        </div>
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE for demo purposes -->
        <!--<script src="js/AdminLTE/demo.js" type="text/javascript"></script>-->

        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/noty/packaged/jquery.noty.packaged.min.js"></script>            

        <script type="text/javascript" src="js/init_table.js"></script>
        <script type="text/javascript" src="js/monitoring_vpb.js"></script>
        <!--Multipe thread-->
        <!--<script src="js/multi-main.js"></script>-->

        <script src="js/table2CSV.js"></script>
        <!--<script src="js/jquery.min.js"></script>-->
        <script src="js/jquery.tabledit.js"></script>
        <script type="text/javascript">
                                                       var data_export_gereral = "";
                                                       var data_export_details = "";
                                                       var excelTableExport = "";
                                                       var dateInput = "";
                                                       var typeInput = "";
                                                       var innerHTMLTableExportGeneral = "";
                                                       var innerHTMLTableExportDetails = "";
                                                       var tableData2;
                                                       var user_role = '<?php echo $userrole; ?>';
                                                       var table2;
                                                       var username = '<?php echo $_SESSION ['monitoring_username']; ?>';


                                                       function filter() {


                                                           //        var currentTabId = $('div[id="tablescroll"] ul .active').children("a").attr("id");
                                                           //        //console.log("filter :" + currentTabId);
                                                           var date_input = $("#txtDate").val();
                                                           dateInput = date_input;
                                                           var type_input = $("#slType").val();


                                                           var activeTab = $('ul#tab-display').find('li.active').children();
                                                           if (activeTab.attr('id') === "details") {
                                                               initializeDetailsTable(type_input);
                                                           } else {
                                                               initializeGeneralTable(type_input);
                                                           }


                                                       }
        </script>

        <script>
            $(document).ready(function () {
                //If window is small enough, enable sidebar push menu
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

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("id"); // activated tab
                    if (target === "general") {
                        //console.log("toggle event");
                        if (typeof table1 === "undefined") {
                            filter();
                        } else {
                            table1.columns.adjust();
                        }
                    }
                });


                setInterval(function () {
                    // Update active time every 5 minutes
                    $.ajax({
                        type: "POST",
                        url: "updateActiveTime.php",
                        async: true,
                        data: {
                            username: username
                        },
                        cache: false,
                        success: function (result) {

                        },
                        error: function (xhr, status, error) {

                            console.log("Error");
                            console.log(error);

                        }
                    }); //ajax
                }, 1000 * 60 * 5); // where X is your every 5 minutes
            });
        </script>
    </body>
</html>