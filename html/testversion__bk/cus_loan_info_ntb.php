<?php
header("Content-Type: text/html;charset=UTF-8");
session_start();
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
}
require_once 'lib/dao/VPBankDAO.php';
$vpBank = new VPBankDAO();
$mana_id = $_SESSION['mana_id'];
unset($_SESSION['mana_id']); // keep things clean.
if (isset($mana_id)) {
    $cus_data = $vpBank->getCusDataNTB($mana_id, $type);
    $cc_code = 'CC104247';
    $warning_data = $vpBank->getWarningData($_SESSION ['monitoring_username']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Saigon BPO | Thông tin chi tiết</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="ionicons-2.0.1/css/ionicons.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="plugins/iCheck/all.css">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/saigonbpo.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]--> 
        <style>
            .skin-yellow-light .main-header .logo {
                background-color: #ffffff;
                border-bottom: 0 solid transparent;
                color: #fff;
            }
        </style>        
    </head>

    <body class="hold-transition skin-yellow-light fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><img src="img/logo_mini.png" alt="logo" height="50" width="50"></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="img/logo.png" alt="logo" height="50" width="200"></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success"><?php echo count($warning_data); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have <?php echo count($warning_data); ?> messages</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php foreach ($warning_data as $cus) { ?>
                                                <li><!-- start message -->
                                                    <a onclick="detailinfo(<?php echo $cus['management_id']; ?>);">
                                                        <div class="pull-left">
                                                            <img src="dist/img/customer.png" class="img-circle" alt="User Image">
                                                        </div>
                                                        <h4>
                                                            <?php echo $cus['folder_customer_name'] ?>
                                                            <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                                        </h4>
                                                        <p><?php echo $cus['message'] ?></p>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <!-- end message -->
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="img/avatar3.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION['monitoring_username']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="img/avatar3.png" class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo $_SESSION['monitoring_username']; ?>
                                        </p>
                                    </li>
                                    <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

            </aside>
            <div class="content-wrapper" style="min-height: 556px;">
                <section class="content">
                    <div class="row">
                        <div class="alert alert-info alert-dismissible">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <h4><i class="icon fa fa-info"></i> Chú ý:</h4>
                            <?php echo $cus_data[0]['reason_bad'] . '   ' . $cus_data[0]['notes']; ?>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="management_id" name="management_id" value="<?php echo $mana_id; ?>" class="hidden" >
                            <form role="form" id="customerForm">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>1. Thông tin khách hàng </strong></h3>
                                    </div>                                  
                                    <div class="box-body" style="display: ">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tên khách hàng:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <input type="text" id="folder_customer_name" value="<?php echo $cus_data[0]['folder_customer_name']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ngày tháng năm sinh:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" id="i_ngay_thang_nam_sinh" value="<?php echo $cus_data[0]['i_ngay_thang_nam_sinh']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>                                        
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Giới tính:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-genderless"></i>
                                                    </div>
                                                    <input type="text" id="i_gender" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>   
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Quốc tịch:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-heart"></i>
                                                    </div>
                                                    <input type="text" id="i_international" value="Việt Nam" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số CMND:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-child"></i>
                                                    </div>
                                                    <input type="text" id="folder_customer_cmnd" value="<?php echo $cus_data[0]['folder_customer_cmnd']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>    
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ngày cấp:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" id="i_ngay_cap" value="<?php echo $cus_data[0]['i_ngay_cap']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nơi cấp:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                    <input type="text" id="i_noi_cap" value="<?php echo $cus_data[0]['i_noi_cap']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Trình độ học vấn:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="hocvan" value="<?php echo $cus_data[0]['hocvan']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nghề nghiệp:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="folder_customer_cmnd" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tình trạng hôn nhân:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="honnhan" value="<?php echo $cus_data[0]['honnhan']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                    </div>                                    
                                </div><!-- /.box-body -->
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>2. Thông tin thu nhập / chi phí</strong></h3>
                                    </div>
                                    <div class="box-body" style="display: ">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Thu nhập cá nhân:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="i_6_thu_nhap_cn" value="<?php echo $cus_data[0]['i_6_thu_nhap_cn']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>   
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Thu nhập gia đình:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="i_6_thu_nhap_gd" value="<?php echo $cus_data[0]['i_6_thu_nhap_gd']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chi phí cá nhân:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="i_6_chi_phi_cn" value="<?php echo $cus_data[0]['i_6_chi_phi_cn']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chi phí gia đình:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="i_6_chi_phi_gd" value="<?php echo $cus_data[0]['i_6_chi_phi_gd']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>

                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>3. Thông tin đề nghị vay vốn</strong></h3>
                                    </div>
                                    <div class="box-body" style="display: ">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sản phẩm:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="san_pham" value="<?php echo $cus_data[0]['san_pham']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>   
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mã sản phẩm:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="tensanpham" value="<?php echo $cus_data[0]['tensanpham']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Branch code:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="branch_code" value="<?php echo $cus_data[0]['branch_code']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kênh giải ngân:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="kenh_giai_ngan" value="<?php echo $cus_data[0]['kenh_giai_ngan']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tên DSA:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="name_tsa" value="<?php echo $cus_data[0]['name_dsa']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mã DSA:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="code_dsa" value="<?php echo $cus_data[0]['code_dsa']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tên TSA:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="name_tsa" value="<?php echo $cus_data[0]['name_tsa']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                    
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mã TSA:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="code_tsa" value="<?php echo $cus_data[0]['code_tsa']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>      
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số ĐT TSA:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="sodienthoai_tsa" value="<?php echo $cus_data[0]['sodienthoai_tsa']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số tiền vay:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="sotienvay" value="<?php echo $cus_data[0]['sotienvay']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kỳ hạn vay:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="thoihanvay" value="<?php echo $cus_data[0]['thoihanvay']; ?>" class="form-control">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>   
                                    </div>
                                </div>                                                      
                            </form>
                        </div>

                        <div class="col-md-4">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab_1"><strong> Mở rộng </strong></a></li>
                                    <?php if ($cus_data[0]['inputype'] == 'NTB') { ?>
                                        <li><a data-toggle="tab" href="#tab_2"><strong> File Upload </strong></a></li>
                                    <?php } ?>
                                    <li><a data-toggle="tab" href="#tab_3"><strong> QDE </strong></a></li>                                    
                                    <li class="pull-right header"><i class="fa fa-commenting-o"></i></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab_1" class="tab-pane active">
                                        <!-- sidebar: style can be found in sidebar.less -->
                                        <ul class="sidebar-menu">
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>Kiểu hồ sơ: <strong> <?php echo $cus_data[0]['inputype']; ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>IDF1: <strong><?php echo $cus_data[0]['id_f1']; ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>DE: <strong><?php echo 'Đang cập nhật'// echo $cus_data[0]['user_input'];     ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>Thời gian Upload: <strong><?php echo $cus_data[0]['upload_time']; ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>Thời gian xử lý: <strong><?php echo $cus_data[0]['capture_date_time']; ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>Trạng thái F1: <strong><?php echo $cus_data[0]['ntb_status']; ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>Lý do F1: <strong><?php echo $cus_data[0]['ntb_reason']; ?></strong></span></a></li>
                                        </ul>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <?php if ($cus_data[0]['inputype'] == 'NTB') { ?>
                                        <div id="tab_2" class="tab-pane">
                                            <div id="file_catgory"></div>
                                        </div>
                                    <?php } ?>
                                    <!-- /.tab-pane -->
                                    <?php // if ($cus_data[0]['id_f1'] != null && $cus_data[0]['id_f1'] != '') { ?>
                                    <div id="tab_3" class="tab-pane">
                                        <div id="qdetab">
                                            <div class="box box-primary">
                                                <!-- /.box-header -->
                                                <!-- form start -->
                                                <form role="form">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label>Kiểu QDE</label>
                                                            <select name="QDETypeCode" id="ErrorCode">
                                                                <option value="QDE01">QDE Cứng</option>
                                                                <option value="QDE02">QDE Mềm</option>
                                                                <option value="QDE03">Cancel ID cũ lên ID mới</option>
                                                            </select>                                                                              
                                                        </div>                                                            
                                                        <div class="form-group">
                                                            <label>Chọn mã lỗi</label>
                                                            <select name="ErrorCode" id="ErrorCode">
                                                                <option value="QDE01">[QDE01] LỖI DO NHÂN VIÊN SALE</option>
                                                                <option value="QDE02">[QDE02] LỖI DO BÊN SAIGON BPO</option>
                                                                <option value="QDE03">[QDE03] LỖI DO NHÂN VIÊN SCAN</option>
                                                                <option value="QDE04">[QDE04] YÊU CẦU CỦA KH VÀ UW</option>
                                                            </select>                                                                              

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Nội dung QDE</label>
                                                            <textarea placeholder="Enter ..." rows="3" class="form-control"></textarea>
                                                        </div>
                                                        <?php if ($cus_data[0]['inputype'] == 'NTB') { ?>
                                                            <div class="form-group">
                                                                <label for="exampleInputFile">File input</label>
                                                                <input type="file" id="exampleInputFile">
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <!-- /.box-body -->

                                                    <div class="box-footer">
                                                        <button class="btn btn-primary" type="submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>                                                
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->                                        
                                    <?php // } ?>
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->
                        </div>                       
                    </div>
                </section>
            </div>
        </div>
        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- InputMask -->
        <script src="plugins/input-mask/jquery.inputmask.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- date-range-picker -->
        <script src="js/moment.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- bootstrap color picker -->
        <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
        <!-- bootstrap time picker -->
        <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.js"></script>

        <script src="dist/js/app.min.js"></script>
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>  
        <script src="js/ntb.js"></script>
        <!-- Page script -->

        <script type="text/javascript">

        </script>        
    </body>
</html>