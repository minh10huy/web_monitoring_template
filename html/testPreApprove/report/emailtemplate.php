<?php

    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        </head>
        <body class="skin-blue" style="min-height:100%;">
            <!-- header logo: style can be found in header.less -->
            <div id="content" style="position: relative; margin-top: 50px;">
            <div class="wrapper row-offcanvas row-offcanvas-left">
                    <!-- Main content -->
                    <section class="content">
                        <!-- Main row -->
                        <div id="maincontent">                                           
                        <!-- Table and chart 1 -->
                        <div class="row">
                                <div id="report-content-1" class="table_chart hidden"></div>

                        </div>
                        
                          <!-- Table and chart 2 -->
                        <div class="row">
                                <div id="report-content-2" class="table_chart hidden"></div>

                        </div>
                        <div class="row">
                                <div id="chart_div_2" class="chart_report" style="width: 1700px; height: 500px; padding-top:30px;"></div>

                        </div>
                          
                        </div>
                    </section><!-- /.content -->
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

            <script type="text/javascript" src="http://www.google.com/jsapi?ext.js"></script>
<!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<script type="text/javascript" src="../js/html2canvas.js"></script>
<script type="text/javascript" src="../js/jquery.plugin.html2canvas.js"></script>
            <!-- DATA TABES SCRIPT -->
            <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
            <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
            <script src="../js/chart_func_helper.js" type="text/javascript"></script>
            <script src="../js/date_util.js"> </script>
            <script src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                      
                      // Load google api
          google.load("visualization", "1.1", {
              packages: ["line", "corechart", 'bar']
          });



          function filter() {
              
              var type = "3";
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
                    //drawStatusTable();

                    // Draw table Hourly Downloaded Amount (Line Chart)
                    drawTableAndChart("6"); 

                    // Draw table Hourly User Amount (Column Chart)
                    //drawTableAndChart("7"); 
                      break;
                      
              }
              

          }
    //google.charts.load("current", {packages:['corechart']});
    //google.charts.setOnLoadCallback(drawTableAndChart);
          function drawTableAndChart(report_type) {
              
              console.log("draw chart : " + report_type);
              var report_div, table_id;
              var rowData = [];
              var header = [];
              var element_size;
              var table_str;
              var days_header = [];
              switch (report_type) {
                  case "6": // Hourly Downloaded Amount (Line Chart)
                      table_str = '<table id="table-report-1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>Time</th>         <th>PL</th>         <th>QDE</th>    <th>CRC Pre-Approve</th></tr>   </thead></table>';

                      // Create header for chart table build
                      header = ['Time', 'PL', 'QDE', 'CRC Pre-approve'];
                      //buildHoursColumn();
                      report_div = "report-content-1";
                      table_id = "table-report-1";
                      break;
              }
              $('#' + report_div).html(table_str);

             var data_table = $('#' + table_id).DataTable({


                  "ajax": {
                      "url": "data_report.php",
                      "type": "POST",
                      "pagingType": "full_numbers",
                      "data": function(d) {
                          d.date = "2016-07-07"
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
                          case "6": // Hourly Downloaded Amount (Line Chart)
                              $('#chart_div_1').empty();
                              if (oSettings.aoData.length > 0) {
                                  //buildHoursColumn();
                                  drawLineChart(header, rowData, "HOURLY AMOUNT", "chart_div_2");
                              }
                              break;
                      }

                  }
              });
          }
 
	function drawStatusTable() {
		$('#report-content').html('<table id="table-status" class="table table-bordered table-striped" width="100%">   <thead>      <tr>         <th>No.</th>         <th>Type</th>         <th>Status</th>         <th>09:00</th>         <th>10:00</th>         <th>11:00</th>         <th>12:00</th>         <th>13:00</th>         <th>14:00</th>         <th>15:00</th>         <th>16:00</th>         <th>17:00</th>         <th>18:00</th>         <th>19:00</th>         <th>20:00</th>         <th>21:00</th>         <th>22:00</th>	  <th>Sum</th>     </tr>   </thead></table>');
		var table = $('#table-status').DataTable({


                  "ajax": {
                      "url": "data_report.php",
                      "type": "POST",
                      "pagingType": "full_numbers",
                      "data": function(d) {
                          d.date = "2016-07-07";
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
    
    $( document ).ready(function() {
//    $("#btnFilter").trigger("click");
    filter();
});
function sendmail() {
//        $('#frmFilter').html2canvas({
//            onrendered: function (canvas) {
//                    $.ajax({
//                        url: '../testmail.php',
//                        type: 'POST',
//                        cache: false,
//                        data: "imagebase64=" + canvas.toDataURL("image/png"),
//                        success: function (string) {
//                            alert("string");
//                        }});
//                    //alert(canvas.toDataURL("image/png"));
//                  }                
//                
//            });

        $('#maincontent').html2canvas({
            onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
                //alert(canvas.toDataURL("image/png"));
                $('#img_val').val(canvas.toDataURL("image/png"));
                //Submit the form manually
                document.getElementById("myForm").submit();
            }
        });
        }
            </script>

        </body>
    </html>
