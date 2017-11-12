<?php
header("Content-Type: text/html;charset=UTF-8");
session_start();
?>

<?php
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
}
require_once 'lib/dao/VPBankDAO.php';
$vpBank = new VPBankDAO();

$mana_id = isset($_GET['mana_id']) ? $_GET['mana_id'] : null;
$type_input = isset($_GET['type_input']) ? $_GET['type_input'] : null;
$cus_data = $vpBank->getCusDataTOPUP($mana_id);

//echo json_encode($cus_data);die;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <!--    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
            <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
            <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script> -->

        <link href="sglib/bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="sglib/jquery-2.2.4.min.js"></script> 
        <script src="sglib/bootstrap-3.3.6/js/bootstrap.min.js"></script> 

        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>        

        <!-- x-editable (bootstrap version) -->
        <link href="sglib/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
        <link href="sglib/inputs-ext/typeaheadjs/lib/typeahead.js-bootstrap.css" rel="stylesheet"/>
        <link href="sglib/inputs-ext/address/address.css" rel="stylesheet"/>
        <script src="sglib/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
        <script src="sglib/mockjax/jquery.mockjax.js"></script>
        <script src="sglib/inputs-ext/typeaheadjs/lib/typeahead.js"></script>
        <script src="sglib/inputs-ext/typeaheadjs/typeaheadjs.js"></script>
        <script src="sglib/inputs-ext/address/address.js"></script>

        <script src="js/pre-approvetopup.js"></script>
        <link href="css/monitoring_vpb.css" rel="stylesheet" type="text/css" />
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="skin-blue" style="min-height:100%;">
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
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div id="tablescroll" class="nav-tabs-custom">
                    <ul id="tab-display" class="nav nav-tabs" style="background:#e4ffde;">
                        <li class="active"><a id="cus_info" href="#tab_cus_info" data-toggle="tab">Customer Info</a></li>
                        <li><a id="qde" href="#tab_qde" data-toggle="tab">QDE</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_cus_info">
                            <div class="container">
                                <button class="btn btn-default" id="enable">Edit</button>
                                <button class="btn btn-default" id="save_data">Save</button>
                                <table style="clear: both" class="table table-bordered table-striped" id="customers_info">
                                    <tbody> 
                                        <tr>
                                            <td> <strong> Customer Info: </strong> </td>
                                        </tr>
                                        <tr>         
                                            <td width="30%">TSA Code F1</td>
                                            <td width="70%"><a data-title="TSA Code F1" data-pk="1" data-type="text" id="code_tsa" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['code_tsa']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>TSA Name</td>
                                            <td><a data-title="TSA Name" data-placeholder="Required" data-pk="1" data-type="text" id="name_tsa" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['name_tsa']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>TSA Phone Number</td>
                                            <td><a data-title="TSA Phone Number" data-placeholder="Required" data-pk="1" data-type="text" id="sodienthoai_tsa" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['sodienthoai_tsa']; ?></a></td>
                                        </tr>

                                        <tr>         
                                            <td width="30%">Product Name 1</td>
                                            <td width="70%"><a data-title="Product Name 1" data-placeholder="Required" data-pk="1" data-type="text" id="product_name_1" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['product_name_1']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Product Code 1</td>
                                            <td><a data-title="Product Code 1"  data-placeholder="Required" data-pk="1" data-type="text" id="product_code_1" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['product_code_1']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>Loan Amount Request</td>
                                            <td><a data-title="Loan Amount Request" data-placeholder="Required" data-pk="1" data-type="text" id="sotienvay" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['sotienvay']; ?></a></td>
                                        </tr>    


                                        <tr>         
                                            <td width="30%">Loan Term Request</td>
                                            <td width="70%"><a data-title="Loan Term Request" data-pk="1" data-type="text" id="thoihanvay" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['thoihanvay']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Insurance</td>
                                            <td><a data-title="Insurance" data-placeholder="Required" data-pk="1" data-type="text" id="baohiem_vay" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['baohiem_vay']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>Date of Closure</td>
                                            <td><a data-title="Date of Closure" data-placeholder="Required" data-pk="1" data-type="text" id="date_of_closure" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['date_of_closure']; ?></a></td>
                                        </tr>

                                        <tr>         
                                            <td width="30%">Disb Channel</td>
                                            <td width="70%"><a data-title="Disb Channel" data-placeholder="Required" data-pk="1" data-type="text" id="kenh_giai_ngan" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['kenh_giai_ngan']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Branch Code</td>
                                            <td><a data-title="Branch Code"  data-placeholder="Required" data-pk="1" data-type="text" id="branch_code" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['branch_code']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>Description</td>
                                            <td><a data-title="Description" data-placeholder="Required" data-pk="1" data-type="text" id="description" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['description']; ?></a></td>
                                        </tr> 

                                        <tr>         
                                            <td width="30%">Referee 1</td>
                                            <td width="70%"><a data-title="Referee 1" data-pk="1" data-type="text" id="sdt_thamchieu1" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['sdt_thamchieu1']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Referee 2</td>
                                            <td><a data-title="Referee 2" data-placeholder="Required" data-pk="1" data-type="text" id="sdt_thamchieu2" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['sdt_thamchieu2']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>Spouse Name</td>
                                            <td><a data-title="Spouse Name" data-placeholder="Required" data-pk="1" data-type="text" id="thongtin_vochong" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['thongtin_vochong']; ?></a></td>
                                        </tr>

                                        <tr>         
                                            <td width="30%">CC Code</td>
                                            <td width="70%"><a data-title="CC Code" data-placeholder="Required" data-pk="1" data-type="text" id="cc_code" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['cc_code']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>CC Name</td>
                                            <td><a data-title="CC Name"  data-placeholder="Required" data-pk="1" data-type="text" id="cc_name" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['cc_name']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>DSA Code</td>
                                            <td><a data-title="DSA Code" data-placeholder="Required" data-pk="1" data-type="text" id="code_dsa" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['code_dsa']; ?></a></td>
                                        </tr> 

                                        <tr>         
                                            <td width="30%">DSA Name</td>
                                            <td width="70%"><a data-title="DSA Name" data-pk="1" data-type="text" id="name_dsa" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['name_dsa']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Opportunity Name</td>
                                            <td><a data-title="Opportunity Name" data-placeholder="Required" data-pk="1" data-type="text" id="tenkhachhang" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['tenkhachhang']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>No. Agreement ID</td>
                                            <td><a data-title="No. Agreement ID" data-placeholder="Required" data-pk="1" data-type="text" id="so_id_cu" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['so_id_cu']; ?></a></td>
                                        </tr>

                                        <tr>         
                                            <td width="30%">New ID Card Number</td>
                                            <td width="70%"><a data-title="New ID Card Number" data-placeholder="Required" data-pk="1" data-type="text" id="so_cmnd" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['so_cmnd']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Date of Issue</td>
                                            <td><a data-title="Date of Issue"  data-placeholder="Required" data-pk="1" data-type="text" id="ngaycap_cmnd" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['ngaycap_cmnd']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>Place of Issue</td>
                                            <td><a data-title="Place of Issue" data-placeholder="Required" data-pk="1" data-type="text" id="noicap_cmnd" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['noicap_cmnd']; ?></a></td>
                                        </tr>

                                        <tr>         
                                            <td width="30%">New Phone</td>
                                            <td width="70%"><a data-title="New Phone" data-pk="1" data-type="text" id="sdt_kh_bsung" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['sdt_kh_bsung']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Address</td>
                                            <td><a data-title="Address" data-placeholder="Required" data-pk="1" data-type="text" id="dia_chi_thuong_tru" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['dia_chi_thuong_tru']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>Actual Address</td>
                                            <td><a data-title="Actual Address" data-placeholder="Required" data-pk="1" data-type="text" id="dia_chi_tam_tru" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['dia_chi_tam_tru']; ?></a></td>
                                        </tr>

                                        <tr>         
                                            <td width="30%">Monthly Income</td>
                                            <td width="70%"><a data-title="Monthly Income" data-placeholder="Required" data-pk="1" data-type="text" id="thunhap_kh_bsung" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['thunhap_kh_bsung']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Monthly Costs</td>
                                            <td><a data-title="Date of Issue"  data-placeholder="Required" data-pk="1" data-type="text" id="chiphi_kh_bsung" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['chiphi_kh_bsung']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>Monthly Income Family</td>
                                            <td><a data-title="Monthly Income Family" data-placeholder="Required" data-pk="1" data-type="text" id="monthly_income_family" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['monthly_income_family']; ?></a></td>
                                        </tr>  

                                        <tr>         
                                            <td width="30%">Monthly Costs Family</td>
                                            <td width="70%"><a data-title="Monthly Costs Family" data-placeholder="Required" data-pk="1" data-type="text" id="monthly_costs_family" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['monthly_costs_family']; ?></a></td>
                                        </tr>
                                        <tr>         
                                            <td>Number of Modified Fields</td>
                                            <td><a data-title="Number of Modified Fields"  data-placeholder="Required" data-pk="1" data-type="text" id="no_modified_fields" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['no_modified_fields']; ?></a></td>
                                        </tr> 
                                        <tr>         
                                            <td>Modified Fields</td>
                                            <td><a data-title="Modified Fields" data-placeholder="Required" data-pk="1" data-type="text" id="modified_fields" href="#" class="topupEditable editable editable-click"><?php echo $cus_data[0]['modified_fields']; ?></a></td>
                                        </tr>                     
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_qde">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-10">
                                        <form action="" id="loginForm">
                                            <div class="form-group input-group">
                                                <div class="section">1.Error Code</div>
                                                <div >                                                                          
                                                    <select name="ErrorCode" id="ErrorCode" class="form-control">
                                                        <option value="errorcode" selected>Chọn mã lỗi</option>
                                                        <option value="QDE01">LỖI DO NHÂN VIÊN SALE</option>
                                                        <option value="QDE02">LỖI DO BÊN SAIGON BPO</option>
                                                        <option value="QDE03">LỖI DO NHÂN VIÊN SCAN</option>
                                                        <option value="QDE04">YÊU CẦU CỦA KH VÀ UW</option>
                                                    </select>                                                                              
                                                </div>           
                                            </div>
                                            <div class="form-group input-group">
                                                <div class="section">2.Reason</div>
                                                <div class="">                                                                          
                                                    <textarea name="reason" id="reason" required="true" class="form-control" rows="5"></textarea>
                                                </div>
                                                <?php if ($product_type == 1) { ?>																	
                                                    <div class="section">3.File &amp; Upload</div>
                                                    <div class="form-control">
                                                        <label>Choose a file to upload: <input name="uploadFile" id="uploadFile" type="file" accept=".zip,.rar"/></label>
                                                    </div>
                                                <?php } ?>
                                                <div class="button-section">
                                                    <input type="submit" id="uploadQDE" name="uploadQDE" value="Upload QDE"/> 
                                                </div>  
                                            </div>
                                        </form>        
                                    </div>  
                                </div>
                            </div>
                        </div><!-- /.tab-pane -->
                        <!--<div class="tab-pane" id="tab_3">-->
                        <!--                                    </div> /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->
        </div>        

    </body>
</html>  