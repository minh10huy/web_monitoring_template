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
        <meta http-equiv="refresh" content="10" />
        <title>SAIGON BPO's Monitoring System | HOME</title>
        <!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <style type="text/css">  
            .center-block {  
                width:1000px;  
                padding:10px;  
                background-color:#eceadc;  
                color:#ec8007  
            }  
        </style>  
    </head>
    <body class="skin-blue" style="min-height:100%">
        <!-- header logo: style can be found in header.less -->
        <!--<div id="top-header">-->     
        <!--</div>-->
        <audio id="soundHandle" style="display: none;"></audio>
        <div id="content" style="position: relative; margin-top: 50px;">
            <div class="wrapper row-offcanvas row-offcanvas-left">
                <div class="center-block">
                    <div id="warninglist">
                        <table id="example" class="display" width="100%"></table>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

        <!-- AdminLTE for demo purposes -->
        <!--<script src="js/AdminLTE/demo.js" type="text/javascript"></script>-->

        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <!--<script src="js/plugins/datatables/jquery.dataTables_2.js" type="text/javascript"></script>-->
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


        <script>
            var dataSet = <?php echo json_encode($results) ?>;
            $(document).ready(function () {
                $('#example').DataTable({
                    data: dataSet,
                    columns: [
                        {title: "#"},
                        {title: "File Name"},
                    ],
                    columnDefs: [
                        {width: 200, targets: 0},
                        {width: 500, targets: 1}
                    ]
                });
            });
            if(dataSet.length>0){
                soundHandle = document.getElementById('soundHandle');
                soundHandle.src = 'sound/alarm.mp3';
                soundHandle.play();     
            }
        </script>
    </body>
</html>