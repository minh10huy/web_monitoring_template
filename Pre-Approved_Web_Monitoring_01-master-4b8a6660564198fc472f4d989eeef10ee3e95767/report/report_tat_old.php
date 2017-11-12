<?php
// Start the session
session_start();

if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: ../login.php");
    exit();
} else {
    $userrole = $_SESSION['monitoring_userrole'];
    $date_range = date('d/m/Y', strtotime(date("Y-m-d") . ' -1 day')) . " - " . date("d/m/Y");

    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>TAT Report</title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
            <!--<link href="..///maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
            <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <!--<link href="..///cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
            <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <!-- Ionicons -->
            <!--<link href="..///code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
            <!--<link href="../css/ionic.min.css" rel="stylesheet" type="text/css" />-->
            <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
            <!-- Morris chart -->
            <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />
            <!-- jvectormap -->
            <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
            <!-- Date Picker -->
            <link href="../css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
            <!-- Daterange picker -->
            <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
            <!-- bootstrap wysihtml5 - text editor -->
<!--            <link href="../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />-->
            <!-- Theme style -->
            <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
            <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
            <!-- DATA TABLES -->
            <!--<link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />-->
<!--            <link href="../css/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css" />-->
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

            </style>
        </head>
        <body class="skin-blue" style="min-height:100%;">
            <!-- header logo: style can be found in header.less -->
            <header class="header">
                <a href="../index.php" class="logo">
                    <!-- Add the class icon to your logo image or logo icon to add the margining -->
                    <!--Monitoring System-->
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <div class="navbar-center">
                        <ul>
                            <li>
                                <a href="../index.php">
                                    <i class="fa fa-dashboard"></i> <span> Home</span>
                                </a>
                            </li>
<!--                            <li>
                                <a href="../profile.php">
                                    <i class="fa fa-dashboard"></i> <span>Profile</span>
                                </a>
                            </li>-->
                            <li>
                                <a href="../listqde.php">
                                    <i class="fa fa-dashboard"></i> <span>QDE History</span>
                                </a>
                            </li>    
                            <li>
                                <a href="../listticket.php">
                                    <i class="fa fa-dashboard"></i> <span>My Ticket</span>
                                </a>
                            </li>                               
                            <?php if ($userrole != 'cc') { ?>
                                <li>
                                    <a href="../UserSetting/user_setting.php">
                                        <i class="fa fa-dashboard"></i> <span>User Settings</span>
                                    </a>
                                </li>
                               
                            <?php } ?>
							<?php if ($userrole == 'admin') { ?>
                                <li class="active">
                                    <a href="../report/report_tat.php">
                                        <i class="fa fa-dashboard"></i> <span>TAT Report</span>
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
                                        <img src="../img/avatar3.png" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo $_SESSION['monitoring_username']; ?>
                                            <small></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="../profile.php" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
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
                                    <form action="" method="POST" name="frmFilter" id="frmFilter">
                                        <div class="box-body border-radius-none">
                                            <span style="margin-left:10px;">From - To: </span>
                                            <!--<i class="fa fa-clock-o"></i>-->
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" id="txtDate" name="txtDate"  style="border:1px solid #CCCCCC;width:16%;height:20px;"/>
                                            <select onchange="changeInputType(this)" id="slType" name="slType" style="border:1px solid #CCCCCC;width:10%;height:20px;">
                                                <option value="1">TAT Report</option>
                                                <option value="2" selected>Daily Report</option>
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
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div> <!--/.row-->
                        <!-- Main row -->
                        
                        <!-- Status report -->
                        <div class="row">
                            <div class="col-md-12">
                                <div id="report-content"></div>
   
                            </div>
                        </div>
                        
                        
                        <!-- Table and chart 1 -->
                        <div class="row">
                                <div id="report-content-1" class="table_chart hidden"></div>

                        </div>
                        <div class="row">
                                <div id="chart_div_1" class="chart_report" style="padding-top:30px;"></div>

                        </div>
                        
                          <!-- Table and chart 2 -->
                        <div class="row">
                                <div id="report-content-2" class="table_chart hidden"></div>

                        </div>
                        <div class="row">
                                <div id="chart_div_2" class="chart_report" style="width: 1700px; height: 500px; padding-top:30px;"></div>

                        </div>
                          
                        <!-- Table and chart 3 -->
                        <div class="row">
                                <div id="report-content-3" class="table_chart hidden"></div>
              
                        </div>
                        <div class="row">
                                <div id="chart_div_3" class="chart_report" style="width: 900px; height: 500px; padding-top:30px;"></div>
                   
                        </div> 
                        
                        <!-- Table and chart 4 -->
                        <div class="row">
                                <div id="report-content-4" class="table_chart hidden"></div>
              
                        </div>
                        <div class="row">
                                <div id="chart_div_4" class="chart_report" style="padding-top:30px;"></div>
                   
                        </div>
                        <div class="row">
                            <div id='bttop'>BACK TO TOP ^</div>
                        </div>
                    </section><!-- /.content -->
                </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->
            </div>

            <!--[if lt IE 9]>
                <script src="js/jquery-1.11.2.min.js"></script>
                                    <![endif]-->
            <!--[if gte IE 9]>
                <script src="js/jquery-1.11.2.min.js"></script>
            <!--<![endif]-->

            <script src="../js/jquery-1.11.2.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>

            <!-- daterangepicker -->
            <script src="../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
            <script src="../js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

            <!-- AdminLTE App -->
            <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

            <!-- AdminLTE for demo purposes -->
            <script src="../js/AdminLTE/demo.js" type="text/javascript"></script>
            <script type="text/javascript" src="http://www.google.com/jsapi?ext.js"></script>
            <script type="text/javascript">

            // Load the Visualization API library and the piechart library.
//            google.load('visualization', '1', {'packages':['corechart']});
//            google.setOnLoadCallback(drawChart);
               // ... draw the chart...
          </script>
            <!-- DATA TABES SCRIPT -->
            <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
            <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
            <script src="../js/chart_func_helper.js" type="text/javascript"></script>
            <script src="../js/date_util.js"> </script>
            <script type="text/javascript">
                      
                      // Load google api
          google.load("visualization", "1.1", {
              packages: ["line", "corechart", 'bar']
          });



          function filter() {
              
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
                    <?php if ($_SESSION['monitoring_userrole'] == "admin") {?>
                         //Average TAT Report 
                        drawTableAndChart("4");

                        // Daily Resource
                        //drawTableAndChart("5");
                    <?php }?>
                      break;
                  case "3" :
                        // Draw table status
                    drawStatusTable();

                    // Draw table Hourly Downloaded Amount (Line Chart)
                    drawTableAndChart("6"); 

                    // Draw table Hourly User Amount (Column Chart)
                    //drawTableAndChart("7"); 
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
                      table_str = '<table id="table-report" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>No.</th>         <th>Content</th>         <th>PL Normal</th>         <th>PL Mobile</th>         <th>CRC Pre-Approve</th>        <th>QDE Normal</th> <th>QDE Mobile</th>   <th>QDE CRC Pre-Approve</th>   </tr>   </thead></table>';
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
                      table_str = '<table id="table-report-1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>Time</th>         <th>PL</th>         <th>QDE</th>    <th>CRC Pre-Approve</th></tr>   </thead></table>';

                      // Create header for chart table build
                      header = ['Time', 'PL', 'QDE', 'CRC Pre-approve'];
                      //buildHoursColumn();
                      report_div = "report-content-1";
                      table_id = "table-report-1";
                      break;
                  case "7": // Hourly User Amount (Column Chart)
                      table_str = '<table id="table-report-2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>Time</th>         <th>Fixed Users</th>         <th>Support Users</th>    <th>OT Users</th></tr>   </thead></table>';

                      // Create header for chart table build
                      header = ['Time', 'Fixed Users', 'Support Users', 'OT Users'];
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
                      "data": function(d) {
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
				  'paging' : false,
                  "fnCreatedRow": function(nRow, aData, iDataIndex) {
                      var row = [];
					  var reset_sum = false;
                      $(nRow).find('td').each(function(index) {
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
                  "fnInitComplete": function(oSettings, json) {

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
                              if (month < 10) month = '0' + month;
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
                              $('#chart_div_1').empty();
                              if (oSettings.aoData.length > 0) {
                                  //buildHoursColumn();
                                  drawLineChart(header, rowData, "HOURLY AMOUNT", "chart_div_2");
                              }
                              break;
                          case "7": // Hourly User Amount (Column Chart)
                              $('#chart_div_2').empty();
                              if (oSettings.aoData.length > 0) {
                                  //buildHoursColumn();
                                  drawColumnChart(header, rowData, "AMOUNT OF USERS", "chart_div_2");
                              }
                              break;
                      }

                  }
              });
          }
                            
    // Chương trình sẽ chạy ngay lần đầu vào trang home
    $(document).ready(function() {
       //filter();
    });                 
                        

    $(function () {
        $('#txtDate').datepicker({format : 'yyyy-mm-dd', autoclose: true,"setDate": new Date()});
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
            $('#txtDate').datepicker({format : 'yyyy-mm-dd', autoclose: true,"setDate": new Date()});
            $('#txtDate').datepicker('update', new Date());
        }
        
    }
	
	function drawStatusTable() {
		$('#report-content').html('<table id="table-status" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>No.</th>         <th>Type</th>         <th>Status</th>         <th>09:00</th>         <th>10:00</th>         <th>11:00</th>         <th>12:00</th>         <th>13:00</th>         <th>14:00</th>         <th>15:00</th>         <th>16:00</th>         <th>17:00</th>         <th>18:00</th>         <th>19:00</th>         <th>20:00</th>         <th>21:00</th>         <th>22:00</th>	  <th>Sum</th>     </tr>   </thead></table>');
		var table = $('#table-status').DataTable({


                  "ajax": {
                      "url": "data_report.php",
                      "type": "POST",
                      "pagingType": "full_numbers",
                      "data": function(d) {
                          d.date = $('#txtDate').val();
                          d.report_type = "8";

                      }
                  },
                  "bSort": false,
                  "bFilter": false,
                  "deferRender": true,
                  "scrollX": true,
                  "bAutoWidth": false,
				  'paging' : false,
				  "aoColumns": [
					{ sWidth: '1%' },
					{ sWidth: '5%' },
					{ sWidth: '5%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%'},
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' },
					{ sWidth: '1%' } 
				],
                  "fnCreatedRow": function(nRow, aData, iDataIndex) {
                      var row = [];
					  var reset_sum = false;
                      $(nRow).find('td').each(function(index) {
							$(this).attr("rowspan", 1);
							var $th = $("#table-status thead tr th").eq($(this).index());
							if ($(this).text() == "Min TAT Done" || $(this).text() == "Max TAT Done" || $(this).text() == "AVERAGE TAT")
								reset_sum = true;
							if ($th.text() == "Sum" && reset_sum == true)
								$(this).text("");
						})
                          

                  },
					"drawCallback": function( oSettings ) {
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

                                        var dimension_td = $(this).find('td').eq( dimension_col ) ;

                                        if (first_instance == null) {
                                            first_instance = dimension_td;
                                        } else if (dimension_td.text() == first_instance.text()) {

                                            dimension_td.remove();

                                            first_instance.attr('rowspan', parseInt(first_instance.attr('rowspan'),10) + 1);
                                        } else {
                                            first_instance = dimension_td;
                                        }

                                    });
                                });
                        
                    } ,
					"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
						   var num =  Math.ceil(parseInt(aData[0])/9);
						   //console.log("id : " + aData[0] + " num : " + num + " division 2 : " + num % 2);
						   
							   $(nRow).find('td').each(function(colIndex) {
								   var $th = $("#table-status thead tr th").eq($(this).index());
								   if ($th.text() == "Sum")
										$(this).css({"background-color":"#DCEEFF"});
									else {
										if (num % 2 != 0) {
											$(this).css({"background-color":"#FFE9E9"});
										}
									}
										
								});

                    }

              });
			  
			  var column_id = table.column(0);
			 column_id.visible(false);
	
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