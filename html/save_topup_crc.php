<?php

session_start();
require_once 'lib/define/Conf.php';
require_once 'lib/db/PostgreSQLClass.php';

header('Content-Type: application/json');
$input = filter_input_array(INPUT_POST);

$pgSQL = new PostgreSQLClass();
$conn = $pgSQL->getConDPO_DIGISOFT(true);
if (!$conn) {
    echo 'There is error in connection with database';
    die();
}

$conn->beginTransaction();

$management_id = $_POST['management_id'];
$is_data_change = $_POST['is_data_change'];
$check_present_user = "select present_user from db_p17016_c001_bak_crc_20170606.management where id = $management_id and (present_user != null or present_user != '') ";
$current_user = $_SESSION['monitoring_username'];

$prepare = $conn->prepare($check_present_user);
$prepare->execute();
$numRows = $prepare->rowCount();

if($numRows > 0){
    echo json_encode('Can not update data because this case is processing on F1!');
    die;
}
$tenkhachhang = isset($_POST['tenkhachhang']) ? trim(str_replace("'", "''",$_POST['tenkhachhang'])) : "";
$so_cmnd = isset($_POST['so_cmnd']) ? trim(str_replace("'", "",$_POST['so_cmnd'])) : "";
$ngaycap_cmnd = isset($_POST['ngaycap_cmnd']) ? trim(str_replace("'", "",$_POST['ngaycap_cmnd'])) : "";
$noicap_cmnd = isset($_POST['noicap_cmnd']) ? trim(str_replace("'", "",$_POST['noicap_cmnd'])) : "";
$ten_san_pham = isset($_POST['ten_san_pham']) ? trim(str_replace("'", "",$_POST['ten_san_pham'])) : "";
$ma_san_pham = isset($_POST['ma_san_pham']) ? trim(str_replace("'", "",$_POST['ma_san_pham'])) : "";
$sanpham = trim($_POST['ten_san_pham'] . ' - ' . str_replace("'", "",$_POST['ma_san_pham']));
$branch_code = isset($_POST['branch_code']) ? trim(str_replace("'", "", $_POST['branch_code'])) : "";
$kenh_giai_ngan = isset($_POST['kenh_giai_ngan']) ? trim(str_replace("'", "",$_POST['kenh_giai_ngan'])) : "";
$sotienvay = isset($_POST['sotienvay']) ? trim(str_replace("'", "",$_POST['sotienvay'])) : "";
$thoihanvay = isset($_POST['thoihanvay']) ? trim(str_replace("'", "",$_POST['thoihanvay'])) : "";
$name_dsa = isset($_POST['name_dsa']) ? trim(str_replace("'", "",$_POST['name_dsa'])) : "";
$code_dsa = isset($_POST['code_dsa']) ? trim(str_replace("'", "",$_POST['code_dsa'])) : "";
$name_tsa = isset($_POST['name_tsa']) ? trim(str_replace("'", "",$_POST['name_tsa'])) : "";
$cc_code = isset($_POST['cc_code']) ? trim(str_replace("'", "",$_POST['cc_code'])) : "";
$cc_name = isset($_POST['cc_name']) ? trim(str_replace("'", "",$_POST['cc_name'])) : "";

$sodienthoai_tsa = isset($_POST['sodienthoai_tsa']) ? trim(str_replace("'", "",$_POST['sodienthoai_tsa'])) : "";
$date_of_closure = isset($_POST['date_of_closure']) ? trim(str_replace("'", "",$_POST['date_of_closure'])) : "";
$baohiem_vay = isset($_POST['baohiem_vay']) ? trim(str_replace("'", "",$_POST['baohiem_vay'])) : "";
$insurance_plus = isset($_POST['insurance_plus']) ? trim(str_replace("'", "",$_POST['insurance_plus'])) : "";
$insurance_name = isset($_POST['insurance_name']) ? trim(str_replace("'", "",$_POST['insurance_name'])) : "";
//$so_id_cu = isset($_POST['so_id_cu']) ? trim(str_replace("'", "",$_POST['so_id_cu'])) : "";
$dia_chi_thuong_tru = isset($_POST['dia_chi_thuong_tru']) ? trim(str_replace("'", "",$_POST['dia_chi_thuong_tru'])) : "";

$dia_chi_tam_tru = isset($_POST['dia_chi_tam_tru']) ? trim(str_replace("'", "",$_POST['dia_chi_tam_tru'])) : "";
$sdt_thamchieu1 = isset($_POST['sdt_thamchieu1']) ? trim(str_replace("'", "",$_POST['sdt_thamchieu1'])) : "";
$sdt_thamchieu2 = isset($_POST['sdt_thamchieu2']) ? trim(str_replace("'", "",$_POST['sdt_thamchieu2'])) : "";
$thongtin_vochong = isset($_POST['thongtin_vochong']) ? trim(str_replace("'", "",$_POST['thongtin_vochong'])) : "";
$thunhap_kh_bsung = isset($_POST['thunhap_kh_bsung']) ? trim(str_replace("'", "",$_POST['thunhap_kh_bsung'])) : "";
$chiphi_kh_bsung = isset($_POST['chiphi_kh_bsung']) ? trim(str_replace("'", "",$_POST['chiphi_kh_bsung'])) : "";
$sdt_kh_bsung = isset($_POST['sdt_kh_bsung']) ? trim(str_replace("'", "",$_POST['sdt_kh_bsung'])) : "";

$monthly_income_family = isset($_POST['monthly_income_family']) ? trim(str_replace("'", "",$_POST['monthly_income_family'])) : "";
$monthly_costs_family = isset($_POST['monthly_costs_family']) ? trim(str_replace("'", "",$_POST['monthly_costs_family'])) : "";
$no_modified_fields = isset($_POST['no_modified_fields']) ? trim(str_replace("'", "",$_POST['no_modified_fields'])) : "";
$modified_fields = isset($_POST['modified_fields']) ? trim(str_replace("'", "",$_POST['modified_fields'])) : "";
$description = isset($_POST['description']) ? trim(str_replace("'", "",$_POST['description'])) : "";
$birthday = isset($_POST['birthday']) ? trim(str_replace("'", "", $_POST['birthday'])) : "";


$offered_credit_limit = isset($_POST['offered_credit_limit']) ? trim(str_replace("'", "",$_POST['offered_credit_limit'])) : "";
$embossing_name = isset($_POST['embossing_name']) ? trim(str_replace("'", "",$_POST['embossing_name'])) : "";
$mailing_address = isset($_POST['mailing_address']) ? trim(str_replace("'", "",$_POST['mailing_address'])) : "";
$answer_for_security_question = isset($_POST['answer_for_security_question']) ? trim(str_replace("'", "", $_POST['answer_for_security_question'])) : "";
//==================================================================
$tenkhachhang_org = isset($_POST['tenkhachhang_org']) ? trim(str_replace("'", "''", $_POST['tenkhachhang_org'])) : "";
$i_ngay_thang_nam_sinh = isset($_POST['i_ngay_thang_nam_sinh']) ? trim(str_replace("'", "", $_POST['i_ngay_thang_nam_sinh'])) : "";
$so_cmnd_org = isset($_POST['so_cmnd_org']) ? trim(str_replace("'", "", $_POST['so_cmnd_org'])) : "";
$ngaycap_cmnd_org = isset($_POST['ngaycap_cmnd_org']) ? trim(str_replace("'", "", $_POST['ngaycap_cmnd_org'])) : "";
$noicap_cmnd_org = isset($_POST['noicap_cmnd_org']) ? trim(str_replace("'", "", $_POST['noicap_cmnd_org'])) : "";

$ten_san_pham_org = isset($_POST['ten_san_pham_org']) ? trim(str_replace("'", "", $_POST['ten_san_pham_org'])) : "";
$ma_san_pham_org = isset($_POST['ma_san_pham_org']) ? trim(str_replace("'", "", $_POST['ma_san_pham_org'])) : "";
$sanpham_org = trim($_POST['ten_san_pham_org'] . ' - ' . str_replace("'", "", $_POST['ma_san_pham_org']));
$branch_code_org = isset($_POST['branch_code_org']) ? trim(str_replace("'", "", $_POST['branch_code_org'])) : "";
$kenh_giai_ngan_org = isset($_POST['kenh_giai_ngan_org']) ? trim(str_replace("'", "", $_POST['kenh_giai_ngan_org'])) : "";
$sotienvay_org = isset($_POST['sotienvay_org']) ? trim(str_replace("'", "", $_POST['sotienvay_org'])) : "";
$thoihanvay_org = isset($_POST['thoihanvay_org']) ? trim(str_replace("'", "", $_POST['thoihanvay_org'])) : "";
$name_dsa_org = isset($_POST['name_dsa_org']) ? trim(str_replace("'", "", $_POST['name_dsa_org'])) : "";
$code_dsa_org = isset($_POST['code_dsa_org']) ? trim(str_replace("'", "", $_POST['code_dsa_org'])) : "";
$name_tsa_org = isset($_POST['name_tsa_org']) ? trim(str_replace("'", "", $_POST['name_tsa_org'])) : "";
$cc_code_org = isset($_POST['cc_code_org']) ? trim(str_replace("'", "", $_POST['cc_code_org'])) : "";
$cc_name_org = isset($_POST['cc_name_org']) ? trim(str_replace("'", "", $_POST['cc_name_org'])) : "";

$sodienthoai_tsa_org = isset($_POST['sodienthoai_tsa_org']) ? trim(str_replace("'", "", $_POST['sodienthoai_tsa_org'])) : "";
$date_of_closure_org = isset($_POST['date_of_closure_org']) ? trim(str_replace("'", "", $_POST['date_of_closure_org'])) : "";
$baohiem_vay_org = isset($_POST['baohiem_vay_org']) ? trim(str_replace("'", "", $_POST['baohiem_vay_org'])) : "";
$insurance_plus_org = isset($_POST['insurance_plus_org']) ? trim(str_replace("'", "", $_POST['insurance_plus_org'])) : "";
$insurance_name_org = isset($_POST['insurance_name_org']) ? trim(str_replace("'", "", $_POST['insurance_name_org'])) : "";
//$so_id_cu = isset($_POST['so_id_cu']) ? trim(str_replace("'", "",$_POST['so_id_cu'])) : "";
$dia_chi_thuong_tru_org = isset($_POST['dia_chi_thuong_tru_org']) ? trim(str_replace("'", "", $_POST['dia_chi_thuong_tru_org'])) : "";

$dia_chi_tam_tru_org = isset($_POST['dia_chi_tam_tru_org']) ? trim(str_replace("'", "", $_POST['dia_chi_tam_tru_org'])) : "";
$sdt_thamchieu1_org = isset($_POST['sdt_thamchieu1_org']) ? trim(str_replace("'", "", $_POST['sdt_thamchieu1_org'])) : "";
$sdt_thamchieu2_org = isset($_POST['sdt_thamchieu2_org']) ? trim(str_replace("'", "", $_POST['sdt_thamchieu2_org'])) : "";
$thongtin_vochong_org = isset($_POST['thongtin_vochong_org']) ? trim(str_replace("'", "", $_POST['thongtin_vochong_org'])) : "";
$thunhap_kh_bsung_org = isset($_POST['thunhap_kh_bsung_org']) ? trim(str_replace("'", "", $_POST['thunhap_kh_bsung_org'])) : "";
$chiphi_kh_bsung_org = isset($_POST['chiphi_kh_bsung_org']) ? trim(str_replace("'", "", $_POST['chiphi_kh_bsung_org'])) : "";
$sdt_kh_bsung_org = isset($_POST['sdt_kh_bsung_org']) ? trim(str_replace("'", "", $_POST['sdt_kh_bsung_org'])) : "";

$monthly_income_family_org = isset($_POST['monthly_income_family_org']) ? trim(str_replace("'", "", $_POST['monthly_income_family_org'])) : "";
$monthly_costs_family_org = isset($_POST['monthly_costs_family_org']) ? trim(str_replace("'", "", $_POST['monthly_costs_family_org'])) : "";
$no_modified_fields_org = isset($_POST['no_modified_fields_org']) ? trim(str_replace("'", "", $_POST['no_modified_fields_org'])) : "";
$modified_fields_org = isset($_POST['modified_fields_org']) ? trim(str_replace("'", "", $_POST['modified_fields_org'])) : "";
$description_org = isset($_POST['description_org']) ? trim(str_replace("'", "", $_POST['description_org'])) : "";
$birthday_org = isset($_POST['birthday_org']) ? trim(str_replace("'", "", $_POST['birthday_org'])) : "";

$offered_credit_limit_org = isset($_POST['offered_credit_limit_org']) ? trim(str_replace("'", "", $_POST['offered_credit_limit_org'])) : "";
$embossing_name_org = isset($_POST['embossing_name_org']) ? trim(str_replace("'", "", $_POST['embossing_name_org'])) : "";
$mailing_address_org = isset($_POST['mailing_address_org']) ? trim(str_replace("'", "", $_POST['mailing_address_org'])) : "";
$answer_for_security_question_org = isset($_POST['answer_for_security_question_org']) ? trim(str_replace("'", "", $_POST['answer_for_security_question_org'])) : "";
//==================================================================

// Begin update TOPUP data
$update_topup = "UPDATE db_p17016_c001_bak_crc_20170606.data SET"
//        . " tenkhachhang = '$tenkhachhang',"
        . " so_cmnd = '$so_cmnd',"
        . " ngaycap_cmnd = '$ngaycap_cmnd',"
        . " noicap_cmnd = '$noicap_cmnd',"
//        . " branch_code = '$branch_code',"
        . " kenh_giai_ngan = '$kenh_giai_ngan',"
        . " sotienvay = '$sotienvay',"
        . " thoihanvay = '$thoihanvay',"
        . " name_dsa = '$name_dsa',"
        . " code_dsa = '$code_dsa',"
        . " name_tsa = '$name_tsa',"
//        . " cc_code = '$cc_code',"
//        . " cc_name = '$cc_name',"
        . " sodienthoai_tsa = '$sodienthoai_tsa',"
        . " date_of_closure = '$date_of_closure',"
//        . " baohiem_vay = '$baohiem_vay',"
//        . " insurance_plus = '$insurance_plus',"
//        . " insurance_name = '$insurance_name',"
        . " dia_chi_thuong_tru = '$dia_chi_thuong_tru',"
        . " dia_chi_tam_tru = '$dia_chi_tam_tru',"
        . " sdt_thamchieu1 = '$sdt_thamchieu1',"
        . " sdt_thamchieu2 = '$sdt_thamchieu2',"
        . " thongtin_vochong = '$thongtin_vochong',"
        . " thunhap_kh_bsung = '$thunhap_kh_bsung',"
        . " chiphi_kh_bsung = '$chiphi_kh_bsung',"
        . " sdt_kh_bsung = '$sdt_kh_bsung',"
        . " monthly_income_family = '$monthly_income_family',"
        . " monthly_costs_family = '$monthly_costs_family',"
        . " no_modified_fields = '$no_modified_fields',"
        . " modified_fields = '$modified_fields',"
        . " description = '$description',"
        . " birthday = '$birthday',"
        
        . " offered_credit_limit = '$offered_credit_limit',"
        . " embossing_name = '$embossing_name',"
        . " mailing_address = '$mailing_address',"
        . " answer_for_security_question = '$answer_for_security_question'"        
        
        . " WHERE management_id = $management_id";

	//    tensanpham = '$sanpham',
//echo json_encode($update_topup);die;
//echo $_POST['management_id'];die; so_id_cu = '$so_id_cu',

$prepare = $conn->prepare($update_topup);
$update_topup_result = $prepare->execute();


$data_change_str = '';

//if($tenkhachhang_org !== $tenkhachhang){
//    $data_change_str.='Tên KH:'.'*bf*'.$tenkhachhang_org.'*at*'.$tenkhachhang.'###';
//}
//if($so_cmnd_org !== $so_cmnd){
//    $data_change_str.='Số CMND:'.'*bf*'.$so_cmnd_org.'*at*'.$so_cmnd.'###';
//}
if($ngaycap_cmnd_org !== $ngaycap_cmnd){
    $data_change_str.='Ngày cấp CMND:'.'*bf*'.$ngaycap_cmnd_org.'*at*'.$ngaycap_cmnd.'###';
}
if($noicap_cmnd_org !== $noicap_cmnd){
    $data_change_str.='Nơi cấp CMND:'.'*bf*'.$noicap_cmnd_org.'*at*'.$noicap_cmnd.'###';
}
if($kenh_giai_ngan_org !== $kenh_giai_ngan){
    $data_change_str.='Kênh giải ngân:'.'*bf*'.$kenh_giai_ngan_org.'*at*'.$kenh_giai_ngan.'###';
}
if($sotienvay_org !== $sotienvay){
    $data_change_str.='Số tiền vay:'.'*bf*'.$sotienvay_org.'*at*'.$sotienvay.'###';
}
if($thoihanvay_org !== $thoihanvay){
    $data_change_str.='Thạn vay:'.'*bf*'.$thoihanvay_org.'*at*'.$thoihanvay.'###';
}
if($name_dsa_org !== $name_dsa){
    $data_change_str.='Tên DSA:'.'*bf*'.$name_dsa_org.'*at*'.$name_dsa.'###';
}
if($code_dsa_org !== $code_dsa){
    $data_change_str.='Mã DSA:'.'*bf*'.$code_dsa_org.'*at*'.$code_dsa.'###';
}
if($sodienthoai_tsa_org !== $sodienthoai_tsa){
    $data_change_str.='Số ĐT TSA:'.'*bf*'.$sodienthoai_tsa_org.'*at*'.$sodienthoai_tsa.'###';
}
if($date_of_closure_org !== $date_of_closure){
    $data_change_str.='Date Of Closure:'.'*bf*'.$date_of_closure_org.'*at*'.$date_of_closure.'###';
}
if($dia_chi_thuong_tru_org !== $dia_chi_thuong_tru){
    $data_change_str.='Địa chỉ thường trú:'.'*bf*'.$dia_chi_thuong_tru_org.'*at*'.$dia_chi_thuong_tru.'###';
}
if($dia_chi_tam_tru_org !== $dia_chi_tam_tru){
    $data_change_str.='Địa chỉ tạm trú:'.'*bf*'.$dia_chi_tam_tru_org.'*at*'.$dia_chi_tam_tru.'###';
}
if($sdt_thamchieu1_org !== $sdt_thamchieu1){
    $data_change_str.='SĐT tham chiếu 1:'.'*bf*'.$sdt_thamchieu1_org.'*at*'.$sdt_thamchieu1.'###';
}
if($sdt_thamchieu2_org !== $sdt_thamchieu2){
    $data_change_str.='SĐT tham chiếu 2:'.'*bf*'.$sdt_thamchieu2_org.'*at*'.$sdt_thamchieu2.'###';
}
if($thongtin_vochong_org != $thongtin_vochong){
    $data_change_str.='Thông tin vợ chồng:'.'*bf*'.$thongtin_vochong_org.'*at*'.$thongtin_vochong.'###';
}
if($thunhap_kh_bsung_org !== $thunhap_kh_bsung){
    $data_change_str.='Thu nhập KH bổ sung:'.'*bf*'.$thunhap_kh_bsung_org.'*at*'.$thunhap_kh_bsung.'###';
}
if($chiphi_kh_bsung_org !== $chiphi_kh_bsung){
    $data_change_str.='Chi phí KH bổ sung:'.'*bf*'.$chiphi_kh_bsung_org.'*at*'.$chiphi_kh_bsung.'###';
}
if($sdt_kh_bsung_org !== $sdt_kh_bsung){
    $data_change_str.='SĐT KH bổ sung:'.'*bf*'.$sdt_kh_bsung_org.'*at*'.$sdt_kh_bsung.'###';
}
if($monthly_income_family_org !== $monthly_income_family){
    $data_change_str.='Thu nhập gia đình:'.'*bf*'.$monthly_income_family_org.'*at*'.$monthly_income_family.'###';
}
if($monthly_costs_family_org !== $monthly_costs_family){
    $data_change_str.='Chi phí gia đình:'.'*bf*'.$monthly_costs_family_org.'*at*'.$monthly_costs_family.'###';
}
if($no_modified_fields_org !== $no_modified_fields){
    $data_change_str.='Số trường thay đổi:'.'*bf*'.$no_modified_fields_org.'*at*'.$no_modified_fields.'###';
}
if($modified_fields_org !== $modified_fields){
    $data_change_str.='Trường thay đổi:'.'*bf*'.$modified_fields_org.'*at*'.$modified_fields.'###';
}
if($description_org !== $description){
    $data_change_str.='Mô tả:'.'*bf*'.$description_org.'*at*'.$description.'###';
}
if($birthday_org !== $birthday){
    $data_change_str.='Ngày sinh:'.'*bf*'.$birthday_org.'*at*'.$birthday.'###';
}

if($offered_credit_limit_org !== $offered_credit_limit){
    $data_change_str.='Offered Credit Limit:'.'*bf*'.$offered_credit_limit_org.'*at*'.$offered_credit_limit.'###';
}
if($embossing_name_org !== $embossing_name){
    $data_change_str.='Embossing Name:'.'*bf*'.$embossing_name_org.'*at*'.$embossing_name.'###';
}
if($mailing_address_org !== $mailing_address){
    $data_change_str.='Mailing Address:'.'*bf*'.$mailing_address_org.'*at*'.$mailing_address.'###';
}
if($answer_for_security_question_org !== $answer_for_security_question){
    $data_change_str.='Answer for Security Question:'.'*bf*'.$answer_for_security_question_org.'*at*'.$answer_for_security_question.'###';
}

$insert_change_data = "INSERT INTO db_p17016_c001_bak_crc_20170606.preapprove_data_change_log(
            managementid, ten_khach_hang, cmnd, change_detail, change_by)
    VALUES ($management_id, '$tenkhachhang', '$so_cmnd', '$data_change_str', '$current_user' )";

$prepare = $conn->prepare($insert_change_data);
$insert_change_data_result = $prepare->execute();

// Begin update status data in Management table
$update_management = "UPDATE db_p17016_c001_bak_crc_20170606.management SET "
        . "update_infor_times = update_infor_times + 1, "
        . "bad_status = 0, "
        . "reason_bad = '', "
        . "capture_status = 0 "
        . "WHERE id = $management_id "
        . "and capture_status = 0 and coalesce(present_user,'') = '' ";

if ($is_data_change = 1) {
    $update_management = "UPDATE db_p17016_c001_bak_crc_20170606.management SET "
            . "update_infor_times = update_infor_times + 1, "
            . "bad_status = 0, "
            . "reason_bad = '', "
            . "step1_status = '000', "
            . "capture_status = 0, " 
			. "auto_fill_status = 0 "
            . "WHERE id = $management_id "
            . "and capture_status = 0 and coalesce(present_user,'') = '' ";
}

$prepare = $conn->prepare($update_management);
$update_management_result = $prepare->execute();

// Commnit if there are no errors
if ($update_topup_result && $update_management_result && $insert_change_data_result) {
    $stmt_check = $conn->prepare("select * from db_p17016_c001_bak_crc_20170606.sp_check_and_mark_bad_status_preapprove_crc($management_id);");
    $stmt_check->execute();
    $conn->commit();
    echo json_encode('Update successfully!');
    die;
} else {
    $conn->rollBack();
    echo json_encode('Update fail!');
    die;
}
?>



