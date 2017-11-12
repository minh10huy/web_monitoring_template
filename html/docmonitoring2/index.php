<?php
require_once 'lib/dao/VPBankDAO.php';
$vpBank = new VPBankDAO();

$results = $vpBank->getPendingFile();
$crc_results = $vpBank->getPendingFileCRC();

//$speedNTB = $vpBank->getSpeedNTB();
//$speedPre = $vpBank->getSpeedPre();
//echo json_encode($speedNTB[0]);die;

$NTB = $results[0]['NTB'];
$QDE_NTB = $results[0]['QDE-NTB'];
$Pre_Approved = $results[0]['Pre-Approved'];
$QDE_Pre = $results[0]['QDE-Pre'];
$CRC = $crc_results[0]['CRC'];
$QDE_CRC = $crc_results[0]['QDE-CRC'];
//echo json_encode($QDE_CRC);die;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
        <meta http-equiv="refresh" content="30" />        
        <title>BAK Monitoring</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="font-awesome-4.6.3/css/font-awesome.css" />        
        <!-- Ionicons -->
        <link rel="stylesheet" type="text/css" href="ionicons-2.0.1/css/ionicons.min.css" />  
        <!-- jvectormap -->
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="css/AdminLTE.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="css/skins/_all-skins.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            .circle {
                border-radius:50%;
                color: black;
                display:table;
                /*min-width: 500px;*/
                height: 500px;
                font-weight: bold;
                font-size: 11.2em;
                width: 500px;
                margin:0 auto;                
            }

            .circle .ntbinfo {
                color: rgba(255, 255, 255, 0.9);
                font-size: 40px;
                left: 0;
                position: absolute;
                text-align: center;
                top: 90px;
                width: 100%;
                color: blue;
            }     
            .circle .preinfo {
                color: rgba(255, 255, 255, 0.9);
                font-size: 40px;
                left: 0;
                position: absolute;
                text-align: center;
                top: 90px;
                width: 100%;
                color: yellow;
            }
            .circle .crcinfo {
                color: rgba(255, 255, 255, 0.9);
                font-size: 40px;
                left: 0;
                position: absolute;
                text-align: center;
                top: 90px;
                width: 100%;
                color: chocolate;
            }            
            .ntb{
                background-color: #00BFFF;
            }
            .pre{
                background-color: #00BFFF;
            }
            .crc{
                background-color: #00BFFF;
            }            
            .qdentb{
                background-color: #FFF68F;
            }
            .qdepre{
                background-color: #FFF68F;
            }
            .qdecrc{
                background-color: #FFF68F;
            } 
            .circle span {
                display:table-cell;
                vertical-align:middle;                
                width: 420px;
                height: 420px;
                text-align:center;
                padding: 0 15px;
                color: #ffffff;
            }  
            .userfont{
                font-size: 2.5em;
            }
            .guidefont{
                font-size: 2.15em;
            }   
            .bg-cuong {
                background-color: #70AD47 !important;
            }            
        </style>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <!--<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>-->
                                <!--<div class="info-box-content">-->
                                <!--<span class="info-box-text" style="position: absolute">New To Bank</span>-->                      
                                <!--<span class="info-box-number"><p class="circle bg-yellow"><span class="ntbinfo">NTB</span><span>1563</span></p></span>-->
                                <span class="info-box-number"><p class="circle bg-yellow"><span class="ntbinfo">NTB</span><span><?php echo $NTB; ?></span></p></span>
                                <!--</div>-->
                                <!--/.info-box-content--> 
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <!--<span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>-->

                                <!--<div class="info-box-content">-->
                                    <!--<span class="info-box-text">QDE New To Bank</span>-->
                                <span class="info-box-number"><p class="circle bg-yellow"><span class="ntbinfo">QDE NTB</span><span><?php echo $QDE_NTB; ?></span></p></span>
                                <!--</div>-->
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>                                                  

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>                        
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <!--<span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>-->

                                <!--<div class="info-box-content">-->
                                    <!--<span class="info-box-text">Pre Approve</span>-->
                                <span class="info-box-number"><p class="circle bg-blue"><span class="preinfo">Topup</span><span><?php echo $Pre_Approved; ?></span></p></span>
                                <!--</div>-->
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>                      

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <!--<span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>-->

                                <!--<div class="info-box-content">-->
                                    <!--<span class="info-box-text">QDE Pre Approve</span>-->
                                <span class="info-box-number"><p class="circle bg-blue"><span class="preinfo">QDE Topup</span><span><?php echo $QDE_Pre; ?></span></p></span>
                                <!--</div>-->
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <!--<span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>-->

                                <!--<div class="info-box-content">-->
                                    <!--<span class="info-box-text">QDE New To Bank</span>-->
                                <span class="info-box-number"><p class="circle bg-cuong"><span class="crcinfo">CRC</span><span><?php echo $CRC; ?></span></p></span>
                                <!--</div>-->
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>                          

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <!--<span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>-->

                                <!--<div class="info-box-content">-->
                                    <!--<span class="info-box-text">QDE Pre Approve</span>-->
                                <span class="info-box-number"><p class="circle bg-cuong"><span class="crcinfo">QDE CRC</span><span><?php echo $QDE_CRC; ?></span></p></span>
                                <!--</div>-->
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>                        

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>
                        <!-- /.col -->   
                    </div>
                    <!--                    <div class="row">
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-yellow"></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text guidefont">New To Bank</span>
                                                    </div>
                                                     /.info-box-content 
                                                </div>
                                                 /.info-box 
                                            </div>
                                             /.col 
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-olive-active"></i></span>
                    
                                                    <div class="info-box-content">
                                                        <span class="info-box-text guidefont">QDE New To Bank</span>
                                                    </div>
                                                     /.info-box-content 
                                                </div>
                                                 /.info-box 
                                            </div>
                                             /.col 
                    
                                             fix for small devices only 
                                            <div class="clearfix visible-sm-block"></div>
                    
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-blue"></span>
                    
                                                    <div class="info-box-content">
                                                        <span class="info-box-text guidefont">Pre Approve</span>
                                                    </div>
                                                     /.info-box-content 
                                                </div>
                                                 /.info-box 
                                            </div>
                                             /.col 
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-aqua-active"></i></span>
                    
                                                    <div class="info-box-content">
                                                        <span class="info-box-text guidefont">QDE Pre Approve</span>
                                                    </div>
                                                     /.info-box-content 
                                                </div>
                                                 /.info-box 
                                            </div>
                                             /.col 
                                        </div>-->
                </section>
                <!-- /.content -->
            </div>

        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="js/app.min.js"></script>
        <!-- Sparkline -->
        <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="plugins/chartjs/Chart.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/pages/dashboard2.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="js/demo.js"></script>
    </body>
</html>
