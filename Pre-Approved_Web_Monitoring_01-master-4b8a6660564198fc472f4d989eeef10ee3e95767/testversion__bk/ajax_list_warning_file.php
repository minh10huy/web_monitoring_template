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
    if ($_SESSION['monitoring_username'] != "admin") {
        header("Location: index.php");
        exit();
    }
    require_once 'lib/dao/VPBankDAO.php';
    $vpBank = new VPBankDAO();
    $results = $vpBank->getWarningFile();
//    $userInfo = $user->getRole($_SESSION ['monitoring_username']);
//    $userrole = $userInfo[1];
//    $userchannel = $userInfo[2];
//    $useremail = $userInfo[3];
//    $usercompany = $userInfo[4];
//    $_SESSION['monitoring_userrole'] = $userrole;
//    $_SESSION['monitoring_userchannel'] = $userchannel;
//    $_SESSION['useremail'] = $useremail;
//    $_SESSION['usercompany'] = $usercompany;
//    $_SESSION['userid'] = $userInfo[0];
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
        <!--</div>-->
        <div id="content" style="position: relative; margin-top: 50px;">
            <div class="wrapper row-offcanvas row-offcanvas-left">
                <div id="warninglist">
                    <table id="example" class="display" width="100%"></table>
                </div>
            </div>
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
        <!--<script src="js/plugins/datatables/jquery.dataTables_2.js" type="text/javascript"></script>-->
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/noty/packaged/jquery.noty.packaged.min.js"></script>            

        <script type="text/javascript" src="js/init_table.js"></script>
        <script type="text/javascript" src="js/monitoring_vpb.js"></script>
        <!--Multipe thread-->
        <!--<script src="js/multi-main.js"></script>-->

        <script src="js/table2CSV.js"></script>
        <!--<script src="js/jquery.min.js"></script>-->
        <script src="js/jquery.tabledit.js"></script>


        <script>
        var dataSet = <?php echo json_encode($results) ?>;
        $(document).ready(function () {
            $('#example').DataTable({
                data: dataSet,
                columns: [
                    {title: "#"},
                    {title: "Event"},
                ]
            });
        });
        </script>
    </body>
</html>