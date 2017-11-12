<?php

// Start the session
session_start();
?>
<?php

$dataReportGeneral = array();
$dataReportDetails = array();
if (isset($_POST['txtDate']) && isset($_POST['slType'])) {
    set_include_path(implode(PATH_SEPARATOR, array(
        realpath(__DIR__ . '/..'),
        get_include_path()
    )));
    require_once ('../lib/dao/VPBankDAO.php');
    require_once ('../lib/utils/Util.php');
    require_once ('../lib/dto/GetDataReportFunctionName.php');

    $date_input = $_POST['txtDate'];
    $type_input = $_POST['slType'];

    $vpBank = new VPBankDAO();
    $getDataReportFunctionName = new GetDataReportFunctionName();
    $file_name = "";
    $today = date("Ymd");

    if ($type_input == 1) {
        $file_name = "VPB_Report_NewApp_" . $today . ".xls";
        $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general, $date_input, $_SESSION['monitoring_userrole']);
        $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details, $date_input, $_SESSION['monitoring_userrole']);
        //echo'herer';die;
//    $dataReportDetailsSpeed = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_with_speed, $date_input);
    } else {
        $file_name = "VPB_Report_QDE_" . $today . ".xls";
        $dataReportGeneral = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_general_form3, $date_input, $_SESSION['monitoring_userrole']);
        $dataReportDetails = $vpBank->getDataReport($_SESSION['monitoring_username'], $getDataReportFunctionName->sp_get_data_report_details_form3, $date_input, $_SESSION['monitoring_userrole']);
    }
    /* ----------------Export to Excel------------------------ */
    /** Error reporting */
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
    if (PHP_SAPI == 'cli')
        die('This example should only be run from a Web Browser');
    /** Include PHPExcel */
    require_once dirname(__FILE__) . '/../phpexcel/PHPExcel.php';

// Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

// Set document properties
    $objPHPExcel->getProperties()->setCreator("SAIOGON BPO")
            ->setLastModifiedBy("SAIGON BPO")
            ->setTitle("SAIGON BPO Report")
            ->setSubject("Report document")
            ->setDescription("Report document")
            ->setKeywords("report")
            ->setCategory("report file");
    /* ---------------------------Sheet General-------------------------------- */
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    foreach (range('A', 'Z') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
    }
    $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle(1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $arrheader = array();
    $i = 0;
    foreach ($dataReportGeneral[0] as $key => $value) {
        $arrheader[$i++] = $key;
    }
    $objPHPExcel->getActiveSheet()->fromArray($arrheader, NULL, 'A1');
    $objPHPExcel->getActiveSheet()->fromArray($dataReportGeneral, NULL, 'A2');
    //$objPHPExcel->getActiveSheet()->set
// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('General');

    /* ---------------------------Sheet Detail-------------------------------- */
    $objPHPExcel->createSheet(1);
    $objPHPExcel->setActiveSheetIndex(1);
    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    foreach (range('A', 'Z') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
    }
    $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle(1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $arrheader = array();
    $i = 0;
    foreach ($dataReportDetails[0] as $key => $value) {
        $arrheader[$i++] = $key;
    }
    $objPHPExcel->getActiveSheet()->fromArray($arrheader, NULL, 'A1');
    $objPHPExcel->getActiveSheet()->fromArray($dataReportDetails, NULL, 'A2');
// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Details');

    /* ---------------------------Save data-------------------------------- */
    $objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename=' . $file_name);
    header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
?>