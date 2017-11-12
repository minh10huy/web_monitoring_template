<?php

require_once 'lib/define/Conf.php';
require_once 'lib/db/PostgreSQLClass.php';

header('Content-Type: application/json');

$input = filter_input_array(INPUT_POST);

//$update_id_f1 = isset($_POST['ID F1']) ? $_POST['ID F1'] : "";
$update_tsa_code_f1 = isset($_POST['TSA_Code_F1']) ? $_POST['TSA_Code_F1'] : "";
$update_tsa_name = isset($_POST['TSA_Name']) ? $_POST['TSA_Name'] : "";
$update_tsa_phone_number = isset($_POST['TSA_Phone_Number']) ? $_POST['TSA_Phone_Number'] : "";
$update_product_name = isset($_POST['Product_Name_1']) ? $_POST['Product_Name_1'] : "";
$update_product_code = isset($_POST['Product_Code_1']) ? $_POST['Product_Code_1'] : "";
//$update_product_code = isset($_POST['Product Code 1']) ? $_POST['Product Code 1'] : "";
$update_loan_amount_request = isset($_POST['Loan_Amount_Request']) ? $_POST['Loan_Amount_Request'] : "";
$update_loan_term_request = isset($_POST['Loan_Term_Request']) ? $_POST['Loan_Term_Request'] : "";
$update_insurance = isset($_POST['Insurance']) ? $_POST['Insurance'] : "";

$update_date_of_closure = isset($_POST['Date_of_Closure']) ? $_POST['Date_of_Closure'] : "";
$update_disb_channel = isset($_POST['Disb_Channel']) ? $_POST['Disb_Channel'] : "";
$update_branch_code = isset($_POST['Branch_Code']) ? $_POST['Branch_Code'] : "";
$update_description = isset($_POST['Description']) ? $_POST['Description'] : "";
$update_ref1 = isset($_POST['Referee_1']) ? $_POST['Referee_1'] : "";
$update_ref2 = isset($_POST['Referee_2']) ? $_POST['Referee_2'] : "";
$update_spouse = isset($_POST['Spouse_Name']) ? $_POST['Spouse_Name'] : "";
$update_cc_code = isset($_POST['CC_Code']) ? $_POST['CC_Code'] : "";
$update_cc_name = isset($_POST['CC_Code']) ? $_POST['CC_Code'] : "";
$update_dsa_code = isset($_POST['DSA_Code']) ? $_POST['DSA_Code'] : "";//Tran changed
$update_dsa_name = isset($_POST['DSA_Name']) ? $_POST['DSA_Name'] : "";//Tran changed
$update_opportunity_name = isset($_POST['Opportunity_Name']) ? $_POST['Opportunity_Name'] : ""; 
$update_no_agreement_id = isset($_POST['No__Agreement_ID']) ? $_POST['No__Agreement_ID'] : "";
$update_id_card_no = isset($_POST['New_ID_Card_Number']) ? $_POST['New_ID_Card_Number'] : "";
$update_date_of_issue = isset($_POST['Date_of_Issue']) ? $_POST['Date_of_Issue'] : "";
$update_place_of_issue = isset($_POST['Place_of_Issue']) ? $_POST['Place_of_Issue'] : "";
$update_phone_no = isset($_POST['New_Phone']) ? $_POST['New_Phone'] : "";
$update_address = isset($_POST['Address']) ? $_POST['Address'] : "";
$update_actual_address = isset($_POST['Actual_Address']) ? $_POST['Actual_Address'] : "";
$update_monthly_income = isset($_POST['Monthly_Income']) ? $_POST['Monthly_Income'] : "";
$update_monthly_costs = isset($_POST['Monthly_Costs']) ? $_POST['Monthly_Costs'] : "";
$update_monthly_income_family = isset($_POST['Monthly_Income_Family']) ? $_POST['Monthly_Income_Family'] : "";
$update_monthly_costs_family = isset($_POST['Monthly_Costs_Family']) ? $_POST['Monthly_Costs_Family'] : "";

$update_product_name_crc = isset($_POST['Product_Name']) ? $_POST['Product_Name'] : "";
$update_product_code_crc = isset($_POST['Product_Code']) ? $_POST['Product_Code'] : "";
$update_offered_credit_limit = isset($_POST['Offered_Credit_Limit']) ? $_POST['Offered_Credit_Limit'] : "";
$update_embossing_name = isset($_POST['Embossing_Name']) ? $_POST['Embossing_Name'] : "";
$update_mailing_address = isset($_POST['Mailing_Address']) ? $_POST['Mailing_Address'] : "";
$update_answer_for_security_question = isset($_POST['Answer_for_Security_Question']) ? $_POST['Answer_for_Security_Question'] : "";

$update_no_modified_fields = isset($_POST['Number_of_Modified_Fields']) ? $_POST['Number_of_Modified_Fields'] : "";
$update_modified_fields = isset($_POST['Modified_Fields']) ? $_POST['Modified_Fields'] : "";
$update_management_id = isset($_POST['management_id']) ? $_POST['management_id'] : "";

$pgSQL = new PostgreSQLClass();
$conn = $pgSQL->getConDPO_DIGISOFT();
if (!$conn) {
    echo 'There is error in connection with database';
    die();
}

$conn->beginTransaction();

// Begin update TOPUP data
$update_crc = "UPDATE db_p17016_c001_bak_crc_20170606.pre_approve_crc SET sodienthoai_tsa =:update_tsa_phone_number, product_name_1 =:update_product_name, product_code_1 =:update_product_code_1, sotienvay =:update_loan_amount_request, 
                                    thoihanvay =:update_loan_term_request, code_tsa =:update_tsa_code_f1, name_tsa =:update_tsa_name, cc_code =:update_cc_code, cc_name =:update_cc_name, code_dsa =:update_dsa_code, name_dsa =:update_dsa_name,
                                    baohiem_vay =:update_insurance, tenkhachhang =:update_opportunity_name, so_id_cu =:update_no_agreement_id, so_cmnd =:update_id_card_no, description =:update_description,
                                        ngaycap_cmnd =:update_date_of_issue, noicap_cmnd =:update_place_of_issue, date_of_closure =:update_date_of_closure, kenh_giai_ngan =:update_disb_channel, branch_code =:update_branch_code, 
                                            dia_chi_thuong_tru =:update_address, dia_chi_tam_tru =:update_actual_address, sdt_thamchieu1 =:update_ref1, sdt_thamchieu2 =:update_ref2, thongtin_vochong =:update_spouse, 
                                    thunhap_kh_bsung =:update_monthly_income, chiphi_kh_bsung =:update_monthly_costs, sdt_kh_bsung =:update_phone_no, no_modified_fields =:update_no_modified_fields, monthly_income_family =:update_monthly_income_family, 
                                        monthly_costs_family =:update_monthly_costs_family, product_name =:update_product_name_crc, product_code =:update_product_code_crc, offered_credit_limit =:update_offered_credit_limit, embossing_name =:update_embossing_name, mailing_address=:update_mailing_address, answer_for_security_question =:update_answer_for_security_question, modified_fields =:update_modified_fields WHERE management_id = $update_management_id";
//, insurance_plus =:update_insurance_plus, insurance_name =:update_insurance_name    
$prepare = $conn->prepare($update_crc);
$update_crc_result = $prepare->execute(array(':update_tsa_phone_number' => $update_tsa_phone_number, ':update_product_name'=> $update_product_name, ':update_product_code'=> $update_product_code, ':update_loan_amount_request'=> $update_loan_amount_request, 
                                    ':update_loan_term_request'=> $update_loan_term_request, ':update_tsa_code_f1'=> $update_tsa_code_f1, ':update_tsa_name'=> $update_tsa_name, ':update_cc_code'=> $update_cc_code, ':update_cc_name'=> $update_cc_name,  ':update_dsa_code'=> $update_dsa_code, ':update_dsa_name'=> $update_dsa_name,
                                    ':update_insurance'=> $update_insurance, ':update_opportunity_name'=> $update_opportunity_name, ':update_no_agreement_id'=> $update_no_agreement_id, ':update_id_card_no'=> $update_id_card_no, ':update_description'=> $update_description,
                                        ':update_date_of_issue'=> $update_date_of_issue, ':update_place_of_issue'=> $update_place_of_issue, ':update_date_of_closure'=> $update_date_of_closure, ':update_disb_channel'=> $update_disb_channel, ':update_branch_code'=> $update_branch_code, 
                                            ':update_address'=> $update_address, ':update_actual_address'=> $update_actual_address, ':update_ref1'=> $update_ref1, ':update_ref2'=> $update_ref2, ':update_spouse'=> $update_spouse, 
                                    ':update_monthly_income'=> $update_monthly_income, ':update_monthly_costs'=> $update_monthly_costs, ':update_phone_no'=> $update_phone_no, ':update_no_modified_fields'=> $update_no_modified_fields, ':update_monthly_income_family'=> $update_monthly_income_family, 
                                        ':update_monthly_costs_family'=> $update_monthly_costs_family, ':update_product_name_crc'=> $update_product_name_crc, ':update_product_code_crc'=> $update_product_code_crc, ':update_offered_credit_limit'=> $update_offered_credit_limit, ':update_embossing_name'=> $update_embossing_name, ':update_mailing_address'=> $update_mailing_address, ':update_answer_for_security_question'=> $update_answer_for_security_question, ':update_modified_fields' => $update_modified_fields));
//, ':update_insurance_plus'=> $update_insurance_plus, ':update_insurance_name'=> $update_insurance_name

// Begin update status data in Management table
$update_management = "UPDATE db_p17016_c001_bak_crc_20170606.management SET update_infor_times = update_infor_times + 1 WHERE id = $update_management_id";
$prepare = $conn->prepare($update_management);
$update_management_result = $prepare->execute();

date_default_timezone_set("Asia/Ho_Chi_Minh");
$current_time = date('Y-m-d H:i:s.u');

// Begin update download time
$update_download_time = "UPDATE db_p17016_c001_bak_crc_20170606.pre_approve_crc SET updated_time = '$current_time' WHERE management_id = $update_management_id";
$prepare = $conn->prepare($update_download_time);
$update_download_result = $prepare->execute();

// Begin update table Data
$update_data = "SELECT * FROM db_p17016_c001_bak_crc_20170606.sp_savejob_bad_image_verify($update_management_id, 4, 0, NULL, 'update from not ok', NULL);";
    
$prepare = $conn->prepare($update_data);
$update_data_result = $prepare->execute();

// Commnit if there are no errors
if ($update_topup_result && $update_management_result && $update_data_result && $update_download_result) {
    $conn->commit();
    //echo 'Update data successfully';
} else {
    $conn->rollBack();
    //echo 'Something wrong in database update';
}

$check_valid = 'SELECT * FROM db_p17016_c001_bak_crc_20170606.sp_check_and_mark_bad_status_preapprove_crc(' . $update_management_id. ')';
$prepare = $conn->prepare($check_valid);
$valid_result = $prepare->execute();
$result_data = $prepare->fetchAll();

if (strlen($result_data[0]['sp_check_and_mark_bad_status_preapprove_crc']) > 0) {
    echo json_encode(array('result' => 'Invalid', 'reason' => $result_data[0]['sp_check_and_mark_bad_status_preapprove_crc']));
    die();
}

?>
