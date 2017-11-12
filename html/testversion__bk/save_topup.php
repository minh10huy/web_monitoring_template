<?php

session_start();
require_once 'lib/define/Conf.php';
require_once 'lib/db/PostgreSQLClass.php';

header('Content-Type: application/json');
$input = filter_input_array(INPUT_POST);

$management_id = $_POST['management_id'];

$tenkhachhang = isset($_POST['tenkhachhang']) ? $_POST['tenkhachhang'] : "";
$i_ngay_thang_nam_sinh = isset($_POST['i_ngay_thang_nam_sinh']) ? $_POST['i_ngay_thang_nam_sinh'] : "";
//$i_gender = isset($_POST['i_gender']) ? $_POST['i_gender'] : "";
//$i_international = isset($_POST['i_international']) ? $_POST['i_international'] : "";
$so_cmnd = isset($_POST['so_cmnd']) ? $_POST['so_cmnd'] : "";
$ngaycap_cmnd = isset($_POST['ngaycap_cmnd']) ? $_POST['ngaycap_cmnd'] : "";
$noicap_cmnd = isset($_POST['noicap_cmnd']) ? $_POST['noicap_cmnd'] : "";
//$hocvan = isset($_POST['hocvan']) ? $_POST['hocvan'] : "";
//$honnhan = isset($_POST['honnhan']) ? $_POST['honnhan'] : "";

$ten_san_pham = isset($_POST['ten_san_pham']) ? $_POST['ten_san_pham'] : "";
$ma_san_pham = isset($_POST['ma_san_pham']) ? $_POST['ma_san_pham'] : "";
$sanpham = $_POST['ten_san_pham'] . '-' . $_POST['ma_san_pham'];
$branch_code = isset($_POST['branch_code']) ? $_POST['branch_code'] : "";
$kenh_giai_ngan = isset($_POST['kenh_giai_ngan']) ? $_POST['kenh_giai_ngan'] : "";
$sotienvay = isset($_POST['sotienvay']) ? $_POST['sotienvay'] : "";
$thoihanvay = isset($_POST['thoihanvay']) ? $_POST['thoihanvay'] : "";
$name_dsa = isset($_POST['name_dsa']) ? $_POST['name_dsa'] : "";
$code_dsa = isset($_POST['code_dsa']) ? $_POST['code_dsa'] : "";
$name_tsa = isset($_POST['name_tsa']) ? $_POST['name_tsa'] : "";
$cc_code = isset($_POST['cc_code']) ? $_POST['cc_code'] : "";
$cc_name = isset($_POST['cc_name']) ? $_POST['cc_name'] : "";

$sodienthoai_tsa = isset($_POST['sodienthoai_tsa']) ? $_POST['sodienthoai_tsa'] : "";
$date_of_closure = isset($_POST['date_of_closure']) ? $_POST['date_of_closure'] : "";
$baohiem_vay = isset($_POST['baohiem_vay']) ? $_POST['baohiem_vay'] : "";
$insurance_plus = isset($_POST['insurance_plus']) ? $_POST['insurance_plus'] : "";
$insurance_name = isset($_POST['insurance_name']) ? $_POST['insurance_name'] : "";
$so_id_cu = isset($_POST['so_id_cu']) ? $_POST['so_id_cu'] : "";
$dia_chi_thuong_tru = isset($_POST['dia_chi_thuong_tru']) ? $_POST['dia_chi_thuong_tru'] : "";

$dia_chi_tam_tru = isset($_POST['dia_chi_tam_tru']) ? $_POST['dia_chi_tam_tru'] : "";
$sdt_thamchieu1 = isset($_POST['sdt_thamchieu1']) ? $_POST['sdt_thamchieu1'] : "";
$sdt_thamchieu2 = isset($_POST['sdt_thamchieu2']) ? $_POST['sdt_thamchieu2'] : "";
$thongtin_vochong = isset($_POST['thongtin_vochong']) ? $_POST['thongtin_vochong'] : "";
$thunhap_kh_bsung = isset($_POST['thunhap_kh_bsung']) ? $_POST['thunhap_kh_bsung'] : "";
$chiphi_kh_bsung = isset($_POST['chiphi_kh_bsung']) ? $_POST['chiphi_kh_bsung'] : "";
$sdt_kh_bsung = isset($_POST['sdt_kh_bsung']) ? $_POST['sdt_kh_bsung'] : "";

$monthly_income_family = isset($_POST['monthly_income_family']) ? $_POST['monthly_income_family'] : "";
$monthly_costs_family = isset($_POST['monthly_costs_family']) ? $_POST['monthly_costs_family'] : "";
$no_modified_fields = isset($_POST['no_modified_fields']) ? $_POST['no_modified_fields'] : "";
$modified_fields = isset($_POST['modified_fields']) ? $_POST['modified_fields'] : "";
$description = isset($_POST['description']) ? $_POST['description'] : "";

$pgSQL = new PostgreSQLClass();
$conn = $pgSQL->getConDPO_DIGISOFT();
if (!$conn) {
    echo 'There is error in connection with database';
    die();
}

$conn->beginTransaction();

// Begin update TOPUP data
$update_topup = "UPDATE db_16001_0001_bak_20160525.data SET 
    tenkhachhang = '$tenkhachhang', 
    i_ngay_thang_nam_sinh = '$i_ngay_thang_nam_sinh',
    so_cmnd = '$so_cmnd',
    ngaycap_cmnd = '$ngaycap_cmnd',                                     
    noicap_cmnd = '$noicap_cmnd',   
    tensanpham = '$sanpham', 
    branch_code = '$branch_code',  
    kenh_giai_ngan = '$kenh_giai_ngan',  
    sotienvay = '$sotienvay',     
    thoihanvay = '$thoihanvay',   
    name_dsa = '$name_dsa',                                   
    code_dsa = '$code_dsa',     
    name_tsa = '$name_tsa',  
    cc_code = '$cc_code',  
    cc_name = '$cc_name',                                      
    sodienthoai_tsa = '$sodienthoai_tsa',      
    date_of_closure = '$date_of_closure',     
    baohiem_vay = '$baohiem_vay',  
    insurance_plus = '$insurance_plus',
    insurance_name = '$insurance_name',
    so_id_cu = '$so_id_cu',  
    dia_chi_thuong_tru = '$dia_chi_thuong_tru',     
    dia_chi_tam_tru = '$dia_chi_tam_tru',     
    sdt_thamchieu1 = '$sdt_thamchieu1',                                     
    sdt_thamchieu2 = '$sdt_thamchieu2',  
    thongtin_vochong = '$thongtin_vochong',                                     
    thunhap_kh_bsung = '$thunhap_kh_bsung',      
    chiphi_kh_bsung = '$chiphi_kh_bsung',  
    sdt_kh_bsung = '$sdt_kh_bsung',     
    monthly_income_family = '$monthly_income_family',  
    monthly_costs_family = '$monthly_costs_family',                                      
    no_modified_fields = '$no_modified_fields',      
    modified_fields = '$modified_fields',   
    description = '$description' WHERE management_id = $management_id";

//echo json_encode($update_topup);die;
//echo $_POST['management_id'];die;
$prepare = $conn->prepare($update_topup);
$update_topup_result = $prepare->execute();

// Begin update status data in Management table
$update_management = "UPDATE db_16001_0001_bak_20160525.management SET "
        . "update_infor_times = update_infor_times + 1, "
        . "bad_status = 0, "
        . "reason_bad = '', "
        . "capture_status = 0 "
        . "WHERE id = $management_id";
$prepare = $conn->prepare($update_management);
$update_management_result = $prepare->execute();

// Commnit if there are no errors
if ($update_topup_result && $update_management_result) {
    $conn->commit();
    echo json_encode('Update successfully!');
    die;
} else {
    $conn->rollBack();
    echo json_encode('Update fail!');
    die;
    //echo 'Something wrong in database update';
}
?>



