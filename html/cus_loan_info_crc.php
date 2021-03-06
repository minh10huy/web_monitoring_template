<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
header("Content-Type: text/html;charset=UTF-8");
session_start();
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
}
require_once 'lib/dao/CRCDAO.php';
$crcDao = new CRCDAO();
$mana_id = $_SESSION['mana_id'];
//unset($_SESSION['mana_id']); // keep things clean.
if (isset($mana_id)) {
    $cus_data = $crcDao->getCusDataCRC($mana_id);
//    echo json_encode($cus_data[0]);die;
    if (isset($cus_data[0]['id_f1']) && $cus_data[0]['id_f1'] !== '') {
        $qde_history = $crcDao->getQDEHistoryCRC($cus_data[0]['id_f1']);
    }
    if ($cus_data[0]['qde_managementid'] !== '' && $cus_data[0]['qde_managementid'] != NULL) {
        $is_work = $crcDao->check_mana_id_work_CRC($cus_data[0]['qde_managementid']);
        $qde_data = $crcDao->getCusDataQDECRC($cus_data[0]['qde_managementid']);
    }
    if ($_SESSION['monitoring_userrole'] === "admin" || $_SESSION['monitoring_userrole'] === "subadmin") {
        $data_update_history = $crcDao->getHistoryUpdateDataCRC($mana_id);
    }
    //print_r($cus_data[0]);die;
    //$products_name_code = explode('-', $cus_data[0]['tensanpham']);
//    $warning_data = $crcDao->getWarningData($_SESSION ['monitoring_username']);
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
                                    <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
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
                            <form id="customerForm" role="form" >
                                <input type="text" id="management_id" name="management_id" value="<?php echo $mana_id; ?>" class="hidden" >
                                <input type="text" id="is_data_change" name="is_data_change" value="0" class="hidden" >
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>1. Thông tin khách hàng </strong> </h3>
                                    </div>                                  
                                    <div class="box-body" style="display: ">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Tên khách hàng:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <input type="text" id="tenkhachhang" name="tenkhachhang" value="<?php echo $cus_data[0]['tenkhachhang']; ?>" class="form-control">
                                                    <input type="text" id="tenkhachhang_org" name="tenkhachhang_org" value="<?php echo $cus_data[0]['tenkhachhang']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ngày tháng năm sinh: (dd/mm/yyyy)</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" id="birthday" name="birthday" value="<?php echo $cus_data[0]['birthday']; ?>" class="form-control" readonly="readonly">
                                                    <input type="text" id="birthday_org" name="birthday_org" value="<?php echo $cus_data[0]['birthday']; ?>" class="hidden">
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số CMND:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-child"></i>
                                                    </div>
                                                    <input type="text" id="so_cmnd" name="so_cmnd" value="<?php echo $cus_data[0]['so_cmnd']; ?>" class="form-control">
                                                    <input type="text" id="so_cmnd_org" name="so_cmnd_org" value="<?php echo $cus_data[0]['so_cmnd']; ?>" class="hidden">
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
                                                    <input type="text" id="ngaycap_cmnd" name="ngaycap_cmnd" value="<?php echo $cus_data[0]['ngaycap_cmnd']; ?>" class="form-control">
                                                    <input type="text" id="ngaycap_cmnd_org" name="ngaycap_cmnd_org" value="<?php echo $cus_data[0]['ngaycap_cmnd']; ?>" class="hidden">
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
                                                    <input type="text" id="noicap_cmnd" name="noicap_cmnd" value="<?php echo $cus_data[0]['noicap_cmnd']; ?>" class="form-control">
                                                    <input type="text" id="noicap_cmnd_org" name="noicap_cmnd_org" value="<?php echo $cus_data[0]['noicap_cmnd']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <!--                                        <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label>Trình độ học vấn:</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-addon">
                                                                                                <i class="fa fa-info"></i>
                                                                                            </div>
                                                                                            <input type="text" id="hocvan" name="hocvan" value="<?php // echo $cus_data[0]['hocvan'];        ?>" class="form-control">
                                                                                        </div>
                                                                                         /.input group 
                                                                                    </div>
                                                                                </div>-->
                                        <!--                                        <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label>Nghề nghiệp:</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-addon">
                                                                                                <i class="fa fa-info"></i>
                                                                                            </div>
                                                                                            <input type="text" id="folder_customer_cmnd" name="folder_customer_cmnd" class="form-control">
                                                                                        </div>
                                                                                         /.input group 
                                                                                    </div>
                                                                                </div>-->
                                        <!--                                        <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label>Tình trạng hôn nhân:</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-addon">
                                                                                                <i class="fa fa-info"></i>
                                                                                            </div>
                                                                                            <input type="text" id="honnhan" name="honnhan" value="<?php // echo $cus_data[0]['honnhan'];        ?>" class="form-control">
                                                                                        </div>
                                                                                         /.input group 
                                                                                    </div>
                                                                                </div>-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Thường trú:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="dia_chi_thuong_tru" name="dia_chi_thuong_tru" value="<?php echo $cus_data[0]['dia_chi_thuong_tru']; ?>" class="form-control">
                                                    <input type="text" id="dia_chi_thuong_tru_org" name="dia_chi_thuong_tru_org" value="<?php echo $cus_data[0]['dia_chi_thuong_tru']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                         
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tạm trú:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="dia_chi_tam_tru" name="dia_chi_tam_tru" value="<?php echo $cus_data[0]['dia_chi_tam_tru']; ?>" class="form-control">
                                                    <input type="text" id="dia_chi_tam_tru_org" name="dia_chi_tam_tru_org" value="<?php echo $cus_data[0]['dia_chi_tam_tru']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SĐT tham chiếu 1:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="sdt_thamchieu1" name="sdt_thamchieu1" value="<?php echo $cus_data[0]['sdt_thamchieu1']; ?>" class="form-control">
                                                    <input type="text" id="sdt_thamchieu1_org" name="sdt_thamchieu1_org" value="<?php echo $cus_data[0]['sdt_thamchieu1']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SĐT tham chiếu 2:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="sdt_thamchieu2" name="sdt_thamchieu2" value="<?php echo $cus_data[0]['sdt_thamchieu2']; ?>" class="form-control">
                                                    <input type="text" id="sdt_thamchieu2_org" name="sdt_thamchieu2_org" value="<?php echo $cus_data[0]['sdt_thamchieu2']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Thông tin Vợ/Chồng:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="thongtin_vochong" name="thongtin_vochong" value="<?php echo $cus_data[0]['thongtin_vochong']; ?>" class="form-control">
                                                    <input type="text" id="thongtin_vochong_org" name="thongtin_vochong_org" value="<?php echo $cus_data[0]['thongtin_vochong']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ĐThoại KH bổ sung:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="sdt_kh_bsung" name="sdt_kh_bsung" value="<?php echo $cus_data[0]['sdt_kh_bsung']; ?>" class="form-control">
                                                    <input type="text" id="sdt_kh_bsung_org" name="sdt_kh_bsung_org" value="<?php echo $cus_data[0]['sdt_kh_bsung']; ?>" class="hidden">
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
                                                <label>Thu nhập khách hàng:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="thunhap_kh_bsung" name="thunhap_kh_bsung" value="<?php echo $cus_data[0]['thunhap_kh_bsung']; ?>" class="form-control">
                                                    <input type="text" id="thunhap_kh_bsung_org" name="thunhap_kh_bsung_org" value="<?php echo $cus_data[0]['thunhap_kh_bsung']; ?>" class="hidden">
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
                                                    <input type="text" id="monthly_income_family" name="monthly_income_family" value="<?php echo $cus_data[0]['monthly_income_family']; ?>" class="form-control">
                                                    <input type="text" id="monthly_income_family_org" name="monthly_income_family_org" value="<?php echo $cus_data[0]['monthly_income_family']; ?>" class="hidden">
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
                                                    <input type="text" id="chiphi_kh_bsung" name="chiphi_kh_bsung" value="<?php echo $cus_data[0]['chiphi_kh_bsung']; ?>" class="form-control">
                                                    <input type="text" id="chiphi_kh_bsung_org" name="chiphi_kh_bsung_org" value="<?php echo $cus_data[0]['chiphi_kh_bsung']; ?>" class="hidden">
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
                                                    <input type="text" id="monthly_costs_family" name="monthly_costs_family" value="<?php echo $cus_data[0]['monthly_costs_family']; ?>" class="form-control">
                                                    <input type="text" id="monthly_costs_family_org" name="monthly_costs_family_org" value="<?php echo $cus_data[0]['monthly_costs_family']; ?>" class="hidden">
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
                                                <label>Tên sản phẩm:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="ten_san_pham" name="ten_san_pham" value="<?php echo $cus_data[0]['ten_san_pham']; ?>" class="form-control">
                                                    <input type="text" id="ten_san_pham_org" name="ten_san_pham_org" value="<?php echo $cus_data[0]['ten_san_pham']; ?>" class="hidden">
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
                                                    <input type="text" id="ma_san_pham" name="ma_san_pham" value="<?php echo $cus_data[0]['ma_san_pham']; ?>" class="form-control">
                                                    <input type="text" id="ma_san_pham_org" name="ma_san_pham_org" value="<?php echo $cus_data[0]['ma_san_pham']; ?>" class="hidden">
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
                                                    <input type="text" id="branch_code" name="branch_code" value="<?php echo $cus_data[0]['branch_code']; ?>" class="form-control">
                                                    <input type="text" id="branch_code_org" name="branch_code_org" value="<?php echo $cus_data[0]['branch_code']; ?>" class="hidden">
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
                                                    <input type="text" id="kenh_giai_ngan" name="kenh_giai_ngan" value="<?php echo $cus_data[0]['kenh_giai_ngan']; ?>" class="form-control">
                                                    <input type="text" id="kenh_giai_ngan_org" name="kenh_giai_ngan_org" value="<?php echo $cus_data[0]['kenh_giai_ngan']; ?>" class="hidden">
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
                                                    <input type="text" id="sotienvay" name="sotienvay" value="<?php echo $cus_data[0]['sotienvay']; ?>" class="form-control">
                                                    <input type="text" id="sotienvay_org" name="sotienvay_org" value="<?php echo $cus_data[0]['sotienvay']; ?>" class="hidden">
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
                                                    <input type="text" id="thoihanvay" name="thoihanvay" value="<?php echo $cus_data[0]['thoihanvay']; ?>" class="form-control">
                                                    <input type="text" id="thoihanvay_org" name="thoihanvay_org" value="<?php echo $cus_data[0]['thoihanvay']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ngày đóng HĐ / Date of Closure</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="date_of_closure" name="date_of_closure" value="<?php echo $cus_data[0]['date_of_closure']; ?>" class="form-control">
                                                    <input type="text" id="date_of_closure_org" name="date_of_closure_org" value="<?php echo $cus_data[0]['date_of_closure']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                         
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bảo hiểm vay:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="baohiem_vay" name="baohiem_vay" value="<?php echo $cus_data[0]['baohiem_vay']; ?>" class="form-control">
                                                    <input type="text" id="baohiem_vay_org" name="baohiem_vay_org" value="<?php echo $cus_data[0]['baohiem_vay']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                          
                                    </div>
                                </div>
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>4. Thông tin card</strong></h3>
                                    </div>
                                    <div class="box-body" style="display: ">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Offered Credit Limit:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="offered_credit_limit" name="offered_credit_limit" value="<?php echo $cus_data[0]['offered_credit_limit']; ?>" class="form-control">
                                                    <input type="text" id="offered_credit_limit_org" name="offered_credit_limit_org" value="<?php echo $cus_data[0]['offered_credit_limit']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>   
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Embossing Name:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="embossing_name" name="embossing_name" value="<?php echo $cus_data[0]['embossing_name']; ?>" class="form-control">
                                                    <input type="text" id="embossing_name_org" name="embossing_name_org" value="<?php echo $cus_data[0]['embossing_name']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mailing Address:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="mailing_address" name="mailing_address" value="<?php echo $cus_data[0]['mailing_address']; ?>" class="form-control">
                                                    <input type="text" id="mailing_address_org" name="mailing_address_org" value="<?php echo $cus_data[0]['mailing_address']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Answer for Security Question:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="answer_for_security_question" name="answer_for_security_question" value="<?php echo $cus_data[0]['answer_for_security_question']; ?>" class="form-control">
                                                    <input type="text" id="answer_for_security_question_org" name="answer_for_security_question_org" value="<?php echo $cus_data[0]['answer_for_security_question']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Card Insurance Type:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="card_insurance_type" name="card_insurance_type" value="<?php echo $cus_data[0]['card_insurance_type']; ?>" class="form-control">
                                                    <input type="text" id="card_insurance_type_org" name="card_insurance_type_org" value="<?php echo $cus_data[0]['card_insurance_type']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>5. Thông tin mở rộng</strong></h3>
                                    </div>
                                    <div class="box-body" style="display: ">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tên DSA:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="name_dsa" name="name_dsa" value="<?php echo $cus_data[0]['name_dsa']; ?>" class="form-control">
                                                    <input type="text" id="name_dsa_org" name="name_dsa_org" value="<?php echo $cus_data[0]['name_dsa']; ?>" class="hidden">
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
                                                    <input type="text" id="code_dsa" name="code_dsa" value="<?php echo $cus_data[0]['code_dsa']; ?>" class="form-control">
                                                    <input type="text" id="code_dsa_org" name="code_dsa_org" value="<?php echo $cus_data[0]['code_dsa']; ?>" class="hidden">
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
                                                    <input type="text" id="name_tsa" name="name_tsa" value="<?php echo $cus_data[0]['name_tsa']; ?>" class="form-control">
                                                    <input type="text" id="name_tsa_org" name="name_tsa_org" value="<?php echo $cus_data[0]['name_tsa']; ?>" class="hidden">
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
                                                    <input type="text" id="code_tsa" name="code_tsa" value="<?php echo $cus_data[0]['code_tsa']; ?>" class="form-control" disabled="true">
                                                    <input type="text" id="code_tsa_org" name="code_tsa_org" value="<?php echo $cus_data[0]['code_tsa']; ?>" class="hidden" disabled="true">
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
                                                    <input type="text" id="sodienthoai_tsa" name="sodienthoai_tsa" value="<?php echo $cus_data[0]['sodienthoai_tsa']; ?>" class="form-control">
                                                    <input type="text" id="sodienthoai_tsa_org" name="sodienthoai_tsa_org" value="<?php echo $cus_data[0]['sodienthoai_tsa']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>CC Code</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="cc_code" name="cc_code" value="<?php echo $cus_data[0]['cc_code']; ?>" class="form-control">
                                                    <input type="text" id="cc_code_org" name="cc_code_org" value="<?php echo $cus_data[0]['cc_code']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                         
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>CC Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="cc_name" name="cc_name" value="<?php echo $cus_data[0]['cc_name']; ?>" class="form-control">
                                                    <input type="text" id="cc_name_org" name="cc_name_org" value="<?php echo $cus_data[0]['cc_name']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                                                              
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>IDF1 cũ:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="so_id_cu" name="so_id_cu" value="<?php echo $cus_data[0]['so_id_cu']; ?>" class="form-control" disabled="true">
                                                    <input type="text" id="so_id_cu_org" name="so_id_cu_org" value="<?php echo $cus_data[0]['so_id_cu']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div> 
                                        <!--                                        <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Số điện thoại sale:</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-addon">
                                                                                                <i class="fa fa-info"></i>
                                                                                            </div>
                                                                                            <input type="text" id="sodienthoai_sale" name="sodienthoai_sale" value="<?php // echo $cus_data[0]['sodienthoai_sale'];        ?>" class="form-control">
                                                                                        </div>
                                                                                         /.input group 
                                                                                    </div>
                                                                                </div>                                         -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số trường thay đổi</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                    <input type="text" id="no_modified_fields" name="no_modified_fields" value="<?php echo $cus_data[0]['no_modified_fields']; ?>" class="form-control">
                                                    <input type="text" id="no_modified_fields_org" name="no_modified_fields_org" value="<?php echo $cus_data[0]['no_modified_fields']; ?>" class="hidden">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Các trường thay đổi:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">                                                                                                            
                                                        <textarea class="form-control"id="modified_fields" name="modified_fields" rows="3"><?php echo $cus_data[0]['modified_fields']; ?></textarea>
                                                        <textarea class="hidden"id="modified_fields_org" name="modified_fields_org" rows="3"><?php echo $cus_data[0]['modified_fields']; ?></textarea>
                                                    </div>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                                                                                                                                               
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Mô tả:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">                                                                                                            
                                                        <textarea class="form-control"id="description" name="description" rows="3"><?php echo $cus_data[0]['description']; ?></textarea>
                                                        <textarea class="hidden"id="description_org" name="description_org" rows="3"><?php echo $cus_data[0]['description']; ?></textarea>
                                                    </div>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>                                         
                                    </div>
                                </div>
                            </form>
                            <?php if (($cus_data[0]['bad_status'] == 2 && $cus_data[0]['reason_bad'] != 'D19-Duplication' && $cus_data[0]['reason_bad'] != 'D31-Đang có hồ sơ process trên F1') || ($cus_data[0]['capture_status'] == 0 && $cus_data[0]['bad_status'] != 2)) { ?>
                                <div class="box-footer">
                                    <div class="col-md-2 pull-right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" id="edit_topup">Chỉnh sửa</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 pull-right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" id="save_topup">Lưu lại</button>
                                        </div>
                                    </div>                                
                                </div>    
                            <?php } ?>
                        </div>

                        <div class="col-md-4">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab_1"><strong> Mở rộng </strong></a></li>
                                    <?php if ($cus_data[0]['inputype'] == 'NTB') { ?>
                                        <li><a data-toggle="tab" href="#tab_2"><strong> File Upload </strong></a></li>
                                    <?php } ?>
                                    <?php if (($cus_data[0]['id_f1'] != null && $cus_data[0]['id_f1'] != '' && !$cus_data[0]['is_have_qde']) || (($cus_data[0]['capture_status'] == 5 && $cus_data[0]['bad_status'] == 0) && ($qde_data[0]['capture_status'] === 5 || $qde_data[0]['bad_status'] === 2))) { ?>
                                        <li><a data-toggle="tab" href="#tab_3"><strong> QDE </strong></a></li> 
                                    <?php } else if ($qde_data[0]['capture_status'] === 0 && $qde_data[0]['bad_status'] != 2 && count($is_work) === 0) { ?>
                                        <li><a data-toggle="tab" href="#tab_4"><strong>Hủy QDE </strong></a></li>
                                    <?php } ?>    
                                    <li class="pull-right header"><i class="fa fa-commenting-o"></i></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab_1" class="tab-pane active">
                                        <!-- sidebar: style can be found in sidebar.less -->
                                        <ul class="sidebar-menu">
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>Kiểu hồ sơ: <strong> <?php echo $cus_data[0]['inputype']; ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>IDF1: <strong><?php echo $cus_data[0]['id_f1']; ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>DE: <strong><?php echo 'Đang cập nhật'// echo $cus_data[0]['user_input'];                           ?></strong></span></a></li>
                                            <li><a><i class="fa fa-circle-o text-green"></i> <span>Thời gian gởi: <strong><?php echo $cus_data[0]['create_time']; ?></strong></span></a></li>
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
                                    <?php if (($cus_data[0]['id_f1'] != null && $cus_data[0]['id_f1'] != '' && !$cus_data[0]['is_have_qde']) || (($cus_data[0]['capture_status'] == 5 && $cus_data[0]['bad_status'] == 0) && ($qde_data[0]['capture_status'] === 5 || $qde_data[0]['bad_status'] === 2))) { ?>
                                        <div id="tab_3" class="tab-pane">
                                            <div id="qdetab">
                                                <div class="box box-primary">
                                                    <!-- /.box-header -->
                                                    <!-- form start -->
                                                    <div class="box-body">
                                                        <form role="form" id="qdeForm">
                                                            <input type="text" id="qdetenkhachhang" name="qdetenkhachhang" value="<?php echo $cus_data[0]['tenkhachhang']; ?>" class="hidden">                                                            
                                                            <input type="text" id="qdeIdf1" name="qdeIdf1" value="<?php echo $cus_data[0]['id_f1']; ?>" class="hidden">
                                                            <input type="text" id="qde_so_cmnd" name="qde_so_cmnd" value="<?php echo $cus_data[0]['so_cmnd']; ?>" class="hidden">
                                                            <div class="form-group">
                                                                <label><strong>IDF1: <?php echo $cus_data[0]['id_f1']; ?></strong></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kiểu QDE</label>
                                                                <select name="QDETypeCode" id="QDETypeCode">
                                                                    <?php if ($cus_data[0]['inputype'] == 'NTB') { ?>
                                                                        <option value="QT01">QDE Cứng</option>
                                                                    <?php } ?>
                                                                    <option value="QT02">QDE Mềm</option>
                                                                    <option value="QT03">Cancel ID cũ lên ID mới</option>
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
                                                                <label>Nội dung QDE</label>
                                                                <textarea name="qde_content" id="qde_content" rows="3" class="form-control"></textarea>
                                                            </div>
                                                            <?php if ($cus_data[0]['inputype'] == 'NTB') { ?>
                                                                <div class="form-group">
                                                                    <label for="exampleInputFile">File input</label>
                                                                    <input type="file" id="qdeInputFile" name="qdeInputFile">
                                                                </div>
                                                            <?php } ?>

                                                            <div class="box-footer">
                                                                <button class="btn btn-primary" id="save_qde">Gởi QDE</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>                                                
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->                                        
                                    <?php } else if ($qde_data[0]['capture_status'] === 0 && $qde_data[0]['bad_status'] != 2 && count($is_work) === 0) { ?>
                                        <div id="tab_4" class="tab-pane">
                                            <div id="qdetab">
                                                <div class="box box-primary">
                                                    <!-- /.box-header -->
                                                    <!-- form start -->
                                                    <div class="box-body">
                                                        <input type="text" id="qde_managementid" name="qde_managementid" value="<?php echo $cus_data[0]['qde_managementid']; ?>" class="hidden">
                                                        <div class="form-group">
                                                            <label><strong>IDF1: <?php echo $cus_data[0]['id_f1']; ?></strong></label>
                                                        </div>

                                                        <div class="box-footer">
                                                            <button class="btn btn-primary" id="cancel_qde">Hủy QDE</button>
                                                        </div>

                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>                                                
                                            </div>
                                        </div>                                            
                                    <?php } ?>
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->
                            <?php if ($_SESSION['monitoring_userrole'] === "admin" || $_SESSION['monitoring_userrole'] === "subadmin") { ?>
                                <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab_update_history"><strong> Lịch sử cập nhật </strong></a></li>
                                        <li><a data-toggle="tab" href="#tab_qde_history"><strong> Lịch sử QDE </strong></a></li>
                                        <li class="pull-right header"><i class="fa fa-history"></i></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab_update_history" class="tab-pane active">
                                            <!-- sidebar: style can be found in sidebar.less -->
                                            <?php if (count($data_update_history) > 0) { ?>
                                                <div class="box box-primary">
                                                    <div class="box-body">
                                                        <?php for ($i = 0; $i < count($data_update_history); $i++) { ?>
                                                            <label>Cập nhật lần: <?php echo $i + 1; ?>:</label>
                                                            <ul class="sidebar-menu">
                                                                <li><a><i class="fa fa-circle-o text-green"></i> <span>Ngày cập nhật: <strong><?php echo $data_update_history[$i]['change_date']; ?></strong></span></a></li>
                                                                <li><a><i class="fa fa-circle-o text-green"></i> <span>Thời gian cập nhật: <strong><?php echo $data_update_history[$i]['change_time']; ?></strong></span></a></li>                                                            
                                                                <li><a><i class="fa fa-circle-o text-green"></i> <span>Cập nhật bởi: <strong><?php echo $data_update_history[$i]['change_by']; ?></strong></span></a></li>
                                                                <li><a><i class="fa fa-circle-o text-green"></i> <span>Nội dung cập nhật:</span></a></li>                                                                                                                        
                                                                <textarea readonly class="form-control"rows="5"><?php
                                                                    $temp = str_replace("*bf:*", " ban đầu: ", str_replace("*bf*", " ban đầu: ", str_replace("*at*", " --> thay đổi thành: ", str_replace("###", "\n", $data_update_history[$i]['change_detail']))));
                                                                    echo $temp;
                                                                    ?>
                                                                </textarea>                                                            
                                                            </ul>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div> 
                                        <div id="tab_qde_history" class="tab-pane">
                                            <!-- sidebar: style can be found in sidebar.less -->
                                            <?php if (count($qde_history) > 1) { ?>
                                                <div class="box box-primary">
                                                    <label>Lịch sử QDE:</label>
                                                    <div class="box-body">
                                                        <?php for ($i = 1; $i < count($qde_history); $i++) { ?>
                                                            <label>QDE lần <?php echo $i; ?>:</label>
                                                            <ul class="sidebar-menu">
                                                                <li><a><i class="fa fa-circle-o text-green"></i> <span>Thời gian gởi: <strong><?php echo $qde_history[$i]['create_time']; ?></strong></span></a></li>
                                                                <li><a><i class="fa fa-circle-o text-green"></i> <span>Thời gian xử lý: <strong><?php echo $qde_history[$i]['capture_date_time']; ?></strong></span></a></li>
                                                            </ul>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>                                     
                                    </div>
                                </div>                            
                            <?php } ?>														
                        </div>                       
                    </div>
                </section>
            </div>
        </div>
        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="plugins/jQuery/jquery.price_format.2.0.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Select2 -->
        <script src="plugins/select2/select2.full.min.js"></script>
        <!-- InputMask -->
        <script src="plugins/input-mask/jquery.inputmask.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>        
        <!-- date-range-picker -->
        <script src="js/moment.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="plugins/datepicker/bootstrap-datepicker.js" charset="UTF-8"></script>
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
        <script src="js/pre-approvecrc.js"></script>
        <!-- Page script -->
    </body>
</html>