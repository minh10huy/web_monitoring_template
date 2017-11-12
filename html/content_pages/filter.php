<?php
$date_range = null;
if (isset($_GET['txtDate'])) {
    $date_range = $_GET['txtDate'];
}
if ($date_range == null) {
    $date_range = date('d/m/Y', strtotime(date("Y-m-d") . ' -1 day')) . " - " . date("d/m/Y");
}
?>

<div id="content">
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
        //console.log("Tab Log :" + activeTab.attr('id'));

        if (activeTab.attr('id') === "details") {
            initializeDetailsTable(type_input);
        } else {
            initializeGeneralTable(type_input);
        }
    }
</script>