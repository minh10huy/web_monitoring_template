<?php
// Start the session
session_start();
?>
<?php require_once 'model/User.php'; ?>

<?php
$user = new User ();
$userInfo = null;
$userrole = null;
$userchannel = null;
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    ?>
    <script>
        window.location = "login.php";
    </script>
    <?php
} else {
    require_once 'lib/dao/VPBankDAO.php';
//    $vpBank = new VPBankDAO();
//    $userInfo = $user->getRole($_SESSION ['monitoring_username']);
//    $userrole = $userInfo[0];
//    $userchannel = $userInfo[1];
//    $useremail = $userInfo[2];
//    $_SESSION['monitoring_userrole'] = $userrole;
//    $_SESSION['monitoring_userchannel'] = $userchannel;
//    $_SESSION['useremail'] = $useremail;
    $date_range = null;
    if (isset($_GET['txtDate'])) {
        $date_range = $_GET['txtDate'];
    }
    if ($date_range == null) {
        $date_range = date('d/m/Y', strtotime(date("Y-m-d") . ' -1 day')) . " - " . date("d/m/Y");
    }
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>QDE History</title>
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
<!--            <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />-->
            <!-- Theme style -->
            <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
            <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
            <!-- DATA TABLES -->
            <!--<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />-->
<!--            <link href="css/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css" />-->
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

            </style>
        </head>
        <body class="skin-blue" style="min-height:100%;">
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
                                <p>Hello, <?php echo $_SESSION['monitoring_username']; ?></p>

                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>
                        <!-- search form -->
                        <form action="#" method="get" class="sidebar-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                                <span class="input-group-btn">
                                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                        <!-- /.search form -->
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <li class="active">
                                <a href="index.php">
                                    <i class="fa fa-dashboard"></i> <span> Home</span>
                                </a>
                            </li>
                            <li>
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
                            <?php if ($userrole != 'cc') { ?>
                                <li>
                                    <a href="UserSetting/user_setting.php">
                                        <i class="fa fa-dashboard"></i> <span>User Settings</span>
                                    </a>
                                </li>
                               
                            <?php } ?>
							<?php if ($userrole == 'admin') { ?>
                                <li>
                                    <a href="report.php">
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
                                            <input type="text" value="<?php echo $date_range; ?>" id="txtDate" name="txtDate"  style="border:1px solid #CCCCCC;width:16%;height:20px;"/>
                                            <select id="slType" name="slType" style="border:1px solid #CCCCCC;width:10%;height:20px;" disabled='disabled'>
                                                <option value="1">Report TAT</option>
                                                <!--<option value="2">Ticket</option>-->
                                            </select>
                                            <input class="btn btn-success btn-sm" type="button"  value="Load" id="btnFilter" name="btnFilter" 
                                                   onclick="return filter();" style="width:10%;margin-left:10px;margin-top: -3px;height:25px;padding:0;width:100px;"/>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div> <!--/.row-->
                        <!-- Main row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div id="report-content"></div>
                                <!-- Custom Tabs -->
<!--                                <div id="tablescroll" class="nav-tabs-custom">
                                    <ul class="nav nav-tabs" style="background:#DDD;">
                                        <li class="active"><a href="#tab_details" data-toggle="tab">QDE History</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="history-content">
                                        </div> /.tab-pane 
                                        <div class="tab-pane" id="tab_3">
                                                                            </div> /.tab-pane 
                                    </div> /.tab-content 
                                </div> nav-tabs-custom                                 -->
                            </div>
                        </div>
                        <div class="row">
                            <div id='bttop'>BACK TO TOP ^</div>
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

            <script src="js/jquery-1.11.2.min.js"></script>
            <script src="js/bootstrap.min.js"></script>

            <!-- daterangepicker -->
            <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

            <!-- AdminLTE App -->
            <script src="js/AdminLTE/app.js" type="text/javascript"></script>

            <!-- AdminLTE for demo purposes -->
            <script src="js/AdminLTE/demo.js" type="text/javascript"></script>

            <!-- DATA TABES SCRIPT -->
            <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
            <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
            <script type="text/javascript">
                                                       var dateInput = "";
                                                       var typeInput = "";
                                                       var innerHTMLTableContent = "";
                                                       var qde_table, preapprove_table;
                                                       function filter() {
                                                       var username = '<?php echo $_SESSION['monitoring_username']; ?>';
                                                               var date_input = $("#txtDate").val();
                                                               dateInput = date_input;
                                                               
                                                                $('#report-content').html('<table id="table-report" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>No.</th>         <th>Content</th>         <th>PL Normal</th>         <th>PL Mobile</th>         <th>Pre-Approve</th>        <th>QDE Normal</th> <th>QDE Mobile</th>      </tr>   </thead></table>');
                                                                       
                                                                   
                                                               $('#table-report').DataTable({
    

                                                                        "ajax": {
                                                                            "url": "data_report.php",
                                                                            "pagingType": "full_numbers",
                                                                            "data": function(d) {
                                                                                d.date = $('#txtDate').val();
                                                                                d.type = $("#slType").val();
                
                                                                            }},
                                                                        "bSort" : false, 
                                                                        "bFilter" : false,
                                                                        "deferRender": true,        
                                                                        "scrollY": $(window).height() - 200,
                                                                        "scrollX": true,
                                                                        "bAutoWidth": false,
                                                                        "iDisplayLength": 30


                                                                    });      
                                                                     
    }
                            
    // Chương trình sẽ chạy ngay lần đầu vào trang home
    $(document).ready(function() {
       filter();
    });                 
                        

    $(function () {
    $('#txtDate').daterangepicker({format: 'DD/MM/YYYY'});
    //                $('#txtDate').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY H:mm'});
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

    // BACK TO TOP
//    $(function () {
//    $(window).scroll(function () {
//    if ($(this).scrollTop() !== 0) {
//       $('#bttop').fadeIn();
//    } else {
//       $('#bttop').fadeOut();
//    }
//    });
//    $('#bttop').click(function () {
//    $('body,html').animate({scrollTop: 0}, 800);
//    });
//    });

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
            </script>

        </body>
    </html>
    <?php
}
?>