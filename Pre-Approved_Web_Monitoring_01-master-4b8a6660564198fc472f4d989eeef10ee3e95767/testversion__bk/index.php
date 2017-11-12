<?php include_once './templates/header.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-filter"></i>
                <h6 class="box-title">Chọn lọc kết quả</h6>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-arrows-alt"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Từ ngày:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" id="txtFromDate" class="form-control pull-right" value="<?php echo date("d/m/Y") ?>">
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Đến ngày:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" id="txtToDate" class="form-control pull-right" value="<?php echo date("d/m/Y") ?>">
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Loại hồ sơ:</label>
                            <select onchange="" id="slType" name="slType" class="form-control">
                                <option value="1">New App</option>
                                <option value="2">QDE</option>
                                <option value="3">PL PreApprove</option>
                                <option value="6">CRC PreApprove</option>
                                <option value="5">Mobile-NewApp</option>
                                <option value="4">Mobile-QDE</option>
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <button class="btn btn-block btn-primary fa fa-search" type="button" id="filter-btn"> Tìm kiếm</button>
                        </div>
                    </div>      
                    <?php if ($_SESSION['monitoring_userrole'] == 'admin' || $_SESSION['monitoring_userrole'] == 'subadmin') { ?>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <button class="btn btn-block btn-primary fa fa-file-excel-o" type="button" id="btnExport" name="btnExport"> Export to Excel</button>
                            </div>
                        </div>   
                    <?php } ?>
                </div>

                <!-- /.row -->
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div id="maincontent" class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <div id="tablescroll">
                                    <ul id="tab-display" class="nav nav-tabs">
                                        <li><a id="general" href="#tab_general" data-toggle="tab">General</a></li>
                                        <li class="active"><a id="details" href="#tab_details" data-toggle="tab">Details</a></li>
                                        <li class="pull-right">
                                            <select id="dropdown_status">
                                                <option value="">Clear ...</option>
                                                <option value="Duplicate">Duplicate</option>
                                                <option value="Entered">Entered</option>
                                                <option value="Meeting">Meeting</option>
                                                <option value="Done - Meeting">Done - Meeting</option>
                                                <option value="Pending - Updated">Pending - Updated</option>
                                                <option value="Done - Pending">Done - Pending</option>                                                
                                            </select>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="tab_general">
                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane active" id="tab_details">
                                        </div><!-- /.tab-pane -->
                                    </div><!-- /.tab-content -->

                                </div><!-- nav-tabs-custom -->
                            </div><!-- /.col -->
                        </div>
                    </div>
                </div>                            
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php include_once './templates/footer.php'; ?>