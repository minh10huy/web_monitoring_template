<?php
session_start();
ini_set('memory_limit', '2048M');
set_time_limit(1800000);
// Start the session
session_start();
?>
<?php

$dataReportGeneral = array();
$dataReportDetails = array();
//if (isset($_POST['txtDate']) && isset($_POST['slType'])) {
    set_include_path(implode(PATH_SEPARATOR, array(
        realpath(__DIR__ . '/..'),
        get_include_path()
    )));
    require_once ('../lib/dao/VPBankDAO.php');
    require_once ('../lib/utils/Util.php');
    require_once ('../lib/dto/GetDataReportFunctionName.php');

//=========================================
//$_SESSION['monitoring_username'] = 'subadmin';
//$_SESSION['monitoring_userrole'] = 'subadmin';
//$date_input = '05/11/2015 - 06/11/2015';
//$type_input = 1;

    $date_input = $_SESSION['FromDate'].'-'.$_SESSION['ToDate'];
    $type_input = $_SESSION['type_input'];
//=========================================
    $vpBank = new VPBankDAO();
    $getDataReportFunctionName = new GetDataReportFunctionName();
    $file_name = "";
    $today = date("Ymd");

    switch ($type_input) {
        case 1 :
            $file_name = "VPB_Report_NewApp_" . $today . ".xls";
            $dataReportGeneral = $vpBank->getDataReportTest($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general, $date_input, $_SESSION['monitoring_userrole']);
            $dataReportDetails = $vpBank->getDataReportTest($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details, $date_input, $_SESSION['monitoring_userrole']);

            $header_general = array(
                '#' => 'string',
                'User' => 'string',
                'CC Name' => 'string',
                'Channel' => 'string',
                'Province' => 'string',
                'From' => 'string',
                'To' => 'string',
                'Finished' => 'string',
                'Canceled' => 'string',
                'Duplication' => 'string',
                'Pending' => 'string',
            );
            if ($_SESSION['monitoring_userrole'] === 'admin') {
                $header_details = array(
                    '#' => 'string',
                    'Upload Date' => 'string',
                    'Upload Time' => 'string',
                    'Download Date' => 'string',
                    'Download Time' => 'string',
                    'Folder' => 'string',
                    'CC Code' => 'string',
                    'CC Name' => 'string',
                    'Province' => 'string',
                    'Customer Name' => 'string',
                    'ID number' => 'string',
                    'Channel' => 'string',
                    'Cancel' => 'string',
                    'Reason' => 'string',
                    'Size' => 'string',
                    'Filename' => 'string',
                    'Check' => 'string',
                    'Classify Speed' => 'string',
                    'ID F1' => 'string',
                    'User F1' => 'string',
                    'DE Date' => 'string',
                    'DE time' => 'string',
                    'Note' => 'string',
                    'Turn Around Time (h)' => 'string',
                    'Duplication' => 'string',
                    'Duplication Date' => 'string',
                    'CC Code Dup' => 'string',
                );
            } else {
                $header_details = array(
                    '#' => 'string',
                    'Upload Date' => 'string',
                    'Upload Time' => 'string',
                    'Download Date' => 'string',
                    'Download Time' => 'string',
                    'Folder' => 'string',
                    'CC Code' => 'string',
                    'CC Name' => 'string',
                    'Province' => 'string',
                    'Customer Name' => 'string',
                    'ID number' => 'string',
                    'Channel' => 'string',
                    'Cancel' => 'string',
                    'Reason' => 'string',
                    'Size' => 'string',
                    'Filename' => 'string',
                    'Check' => 'string',
                    'ID F1' => 'string',
                    'User F1' => 'string',
                    'DE Date' => 'string',
                    'DE time' => 'string',
                    'Note' => 'string',
                    'Duplication' => 'string',
                    'Duplication Date' => 'string',
                    'CC Code Dup' => 'string',
                );
            }
            break;
        case 2 :
            $file_name = "VPB_Report_QDE_" . $today . ".xls";
            $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general_form3, $date_input, $_SESSION['monitoring_userrole']);
            $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_form3, $date_input, $_SESSION['monitoring_userrole']);

            $header_general = array(
                '#' => 'string',
                'Date' => 'string',
                'User' => 'string',
                'CC Name' => 'string',
                'Channel' => 'string',
                'Province' => 'string',
                'Hard' => 'string',
                'Soft' => 'string',
                'Canceled' => 'string',
                'Pending' => 'string',
            );

            if ($_SESSION['monitoring_userrole'] === 'admin') {
                $header_details = array(
                    '#' => 'string',
                    'Download Date' => 'string',
                    'Download Time' => 'string',
                    'Folder' => 'string',
                    'CC Code' => 'string',
                    'CC Name' => 'string',
                    'Province' => 'string',
                    'Kind' => 'string',
                    'Name' => 'string',
                    'ID Number' => 'string',
                    'Channel' => 'string',
                    'Cancel' => 'string',
                    'Cancel Reason' => 'string',
                    'ID F1' => 'string',
                    'User F1' => 'string',
                    'Reason' => 'string',
                    'Date' => 'string',
                    'Time' => 'string',
                    'Turn Around Time (h)' => 'string',
                    'From VPBank' => 'string',
                    'From SAIGON BPO' => 'string',					
                );
            } else {
                $header_details = array(
                    '#' => 'string',
                    'Download Date' => 'string',
                    'Download Time' => 'string',
                    'Folder' => 'string',
                    'CC Code' => 'string',
                    'CC Name' => 'string',
                    'Province' => 'string',
                    'Kind' => 'string',
                    'Name' => 'string',
                    'ID Number' => 'string',
                    'Channel' => 'string',
                    'Cancel' => 'string',
                    'Cancel Reason' => 'string',
                    'ID F1' => 'string',
                    'User F1' => 'string',
                    'Reason' => 'string',
                    'Date' => 'string',
                    'Time' => 'string',
                    'From VPBank' => 'string',
                    'From SAIGON BPO' => 'string',					
                );
            }

            break;
        case 3 :
            $file_name = "VPB_Report_PreApprove_" . $today . ".xls";
            $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general_preapprove, $date_input, $_SESSION['monitoring_userrole']);
            $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_preapprove, $date_input, $_SESSION['monitoring_userrole']);

            $header_general = array(
                'Day' => 'string',
                'Done - Meeting' => 'string',
                'Done Pending' => 'string',
                'Duplicate' => 'string',
                'Meeting' => 'string',
                'Pending' => 'string',
                'Pending - Updated' => 'string',
                'QDE - Cancel' => 'string',
                'QDE - Done' => 'string',
                'QDE - Others' => 'string',
                'QDE _ Updated' => 'string',
            );

            $header_details = array(
                '#' => 'string',
                'Code Number' => 'string',
                'Download Time' => 'string',
                'TSA Code F1' => 'string',
                'TSA Name' => 'string',
                'TSA Phone Number' => 'string',
                'Product Name 1' => 'string',
                'Product Code 1' => 'string',
                'Loan Amount Request' => 'string',
                'Loan Term Request' => 'string',
                'Insurance' => 'string',
                'Insurance Plus' => 'string',
                'Insurance Name' => 'string',
                'Date of Closure' => 'string',
                'Disb Channel' => 'string',
                'Branch Code' => 'string',
                'Description' => 'string',
                'Referee 1' => 'string',
                'Referee 2' => 'string',
                'Spouse Name' => 'string',
                'CC Code' => 'string',
                'CC Name' => 'string',
                'DSA Code' => 'string',
                'DSA Name' => 'string',
                'Opportunity Name' => 'string',
                'No. Agreement ID' => 'string',
                'New ID Card Number' => 'string',
                'Date of Issue' => 'string',
                'Place of Issue' => 'string',
                'New Phone' => 'string',
                'Address' => 'string',
                'Actual Address' => 'string',
                'Monthly Income' => 'string',
                'Monthly Costs' => 'string',
                'Monthly Income Family' => 'string',
                'Monthly Costs Family' => 'string',
                'Number of Modified Fields' => 'string',
                'Modified Fields' => 'string',
                'ID F1' => 'string',
                'Status SAIGONBPO' => 'string',
                'Reason NOT OK' => 'string',
                'Status F1' => 'string',
            );
            break;
        case 4 :
            $file_name = "VPB_Report_Mobile_QDE_" . $today . ".xls";
            $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general_mobile_qde, $date_input, $_SESSION['monitoring_userrole'], 1);
            $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_mobile_qde, $date_input, $_SESSION['monitoring_userrole'], 1);
            
            $header_general = array(
                'Date' => 'string',
                'User' => 'string',
                'CC Name' => 'string',
                'Channel' => 'string',
                'Province' => 'string',
                'Hard' => 'string',
                'Soft' => 'string',
                'Canceled' => 'string',
                'Pending' => 'string',
            );
            if ($_SESSION['monitoring_userrole'] === 'admin') {
                $header_details = array(
                    'Download Date' => 'string',
                    'Download Time' => 'string',
                    'Folder' => 'string',
                    'CC Code' => 'string',
                    'CC Name' => 'string',
                    'Province' => 'string',
                    'Kind' => 'string',
                    'Name' => 'string',
                    'ID Number' => 'string',
                    'Channel' => 'string',
                    'Cancel' => 'string',
                    'Cancel Reason' => 'string',
                    'ID F1' => 'string',
                    'User F1' => 'string',
                    'Reason' => 'string',
                    'Date' => 'string',
                    'Time' => 'string',
                    'Turn Around Time (h)' => 'string',
                );
            } else {
                $header_details = array(
                    'Download Date' => 'string',
                    'Download Time' => 'string',
                    'Folder' => 'string',
                    'CC Code' => 'string',
                    'CC Name' => 'string',
                    'Province' => 'string',
                    'Kind' => 'string',
                    'Name' => 'string',
                    'ID Number' => 'string',
                    'Channel' => 'string',
                    'Cancel' => 'string',
                    'Cancel Reason' => 'string',
                    'ID F1' => 'string',
                    'User F1' => 'string',
                    'Reason' => 'string',
                    'Date' => 'string',
                    'Time' => 'string',
                );
            }           
            
            break;
        case 5 :
            $file_name = "VPB_Report_Mobile_NewApp_" . $today . ".xls";
            $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general_mobile_newapp, $date_input, $_SESSION['monitoring_userrole'], 1);
            $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_mobile_newapp, $date_input, $_SESSION['monitoring_userrole'], 1);
            
            $header_general = array(
                'User' => 'string',
                'CC Name' => 'string',
                'Channel' => 'string',
                'Province' => 'string',
                'From' => 'string',
                'To' => 'string',
                'Finished' => 'string',
                'Canceled' => 'string',
                'Duplication' => 'string',
                'Pending' => 'string',
            );
            if ($_SESSION['monitoring_userrole'] === 'admin') {
                $header_details = array(
                    'Upload Date' => 'string',
                    'Upload Time' => 'string',
                    'Download Date' => 'string',
                    'Download Time' => 'string',
                    'Folder' => 'string',
                    'CC Code' => 'string',
                    'CC Name' => 'string',
                    'Province' => 'string',
                    'Customer Name' => 'string',
                    'ID number' => 'string',
                    'Channel' => 'string',
                    'Cancel' => 'string',
                    'Reason' => 'string',
                    'Size' => 'string',
                    'Filename' => 'string',
                    'Check' => 'string',
                    'Classify Speed' => 'string',
                    'ID F1' => 'string',
                    'User F1' => 'string',
                    'DE Date' => 'string',
                    'DE time' => 'string',
                    'Note' => 'string',
                    'Turn Around Time (h)' => 'string',
                    'Duplication' => 'string',
                    'Duplication Date' => 'string',
                    'CC Code Dup' => 'string',
                );
            } else {
                $header_details = array(
                    'Upload Date' => 'string',
                    'Upload Time' => 'string',
                    'Download Date' => 'string',
                    'Download Time' => 'string',
                    'Folder' => 'string',
                    'CC Code' => 'string',
                    'CC Name' => 'string',
                    'Province' => 'string',
                    'Customer Name' => 'string',
                    'ID number' => 'string',
                    'Channel' => 'string',
                    'Cancel' => 'string',
                    'Reason' => 'string',
                    'Size' => 'string',
                    'Filename' => 'string',
                    'Check' => 'string',
                    'ID F1' => 'string',
                    'User F1' => 'string',
                    'DE Date' => 'string',
                    'DE time' => 'string',
                    'Note' => 'string',
                    'Duplication' => 'string',
                    'Duplication Date' => 'string',
                    'CC Code Dup' => 'string',
                );
            }            
            
            break;
    }


    /* ----------------Export to Excel------------------------ */
    /** Error reporting */
//echo count($dataReportGeneral).'---'.count($dataReportDetails);die;
    include_once("xlsxwriter.class.php");
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);

    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($file_name) . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    $writer = new XLSXWriter();
    $writer->setAuthor('SAIGON BPO');
    $writer->writeSheet($dataReportGeneral, 'General', $header_general);
    $writer->writeSheet($dataReportDetails, 'Details', $header_details);
//$writer->writeToFile('example.xlsx');
    $writer->writeToStdOut();
//}
exit(0);
?>