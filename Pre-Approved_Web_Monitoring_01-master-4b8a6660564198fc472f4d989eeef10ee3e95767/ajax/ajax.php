<?php

// Start the session
session_start();
?>
<?php

if (isset($_POST['date_input']) && isset($_POST['type_input'])) {
//echo "abc";die();
    set_include_path(implode(PATH_SEPARATOR, array(
        realpath(__DIR__ . '/..'),
        get_include_path()
    )));
    require_once ('../lib/dao/VPBankDAO.php');
    require_once ('../lib/utils/Util.php');
    require_once ('../lib/dto/GetDataReportFunctionName.php');

    $date_input = $_POST['date_input'];
    $type_input = $_POST['type_input'];

    $vpBank = new VPBankDAO();
    $getDataReportFunctionName = new GetDataReportFunctionName();

    switch ($type_input) {
        case 1:
            $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general, $date_input, $_SESSION['monitoring_userrole']);
            $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details, $date_input, $_SESSION['monitoring_userrole']);
            break;
        case 2:
            $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general_form3, $date_input, $_SESSION['monitoring_userrole']);
            $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_form3, $date_input, $_SESSION['monitoring_userrole']);
            break;
        case 3:
            $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general_preapprove, $date_input, $_SESSION['monitoring_userrole']);
            $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_preapprove, $date_input, $_SESSION['monitoring_userrole']);
            break;
    }
//    if ($type_input == 1) {
//        $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general, $date_input, $_SESSION['monitoring_userrole']);
//        $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details, $date_input, $_SESSION['monitoring_userrole']);
////    $dataReportDetailsSpeed = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_with_speed, $date_input);
//    } else {
//        $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general_form3, $date_input, $_SESSION['monitoring_userrole']);
//        $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_form3, $date_input, $_SESSION['monitoring_userrole']);
////    $dataReportDetailsSpeed = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_with_speed_form3, $date_input);
//    }

    $util = new Util();
    //$resultDataReportGeneral = $util->analysisData($dataReportGeneral, 1);
    //$resultDataReportDetails = $util->analysisData($dataReportDetails, 2);
    $resultDataReportGeneral = $util->analysisData($dataReportGeneral, 1, intval($type_input));
    $resultDataReportDetails = $util->analysisData($dataReportDetails, 2, intval($type_input));	
    
//$resultDataReportDetailsSpeed = $util->analysisData($dataReportDetailsSpeed, 3);

    $result_monitoring = array(
        'resultDataReportGeneral' => $resultDataReportGeneral,
        'resultDataReportDetails' => $resultDataReportDetails,
//    , 'resultDataReportDetailsSpeed' => $resultDataReportDetailsSpeed
    );    
//dung ham json_encode de chuyen mang $warning thanh chuoi JSON
    echo json_encode($result_monitoring);

//ket thuc tra ve du lieu va stop khong cho chay tiep
    die;
}
?>