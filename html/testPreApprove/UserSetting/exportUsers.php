<?php

// Start the session
session_start();


$dataReport = array();
set_include_path(implode(PATH_SEPARATOR, array(
realpath(__DIR__ . '/..'),
 get_include_path()
)));
require_once '../config.php';
// require (ROOT_PATH  . 'lib\\define\\Conf.php');
// require(ROOT_PATH  . 'lib\\dao\\LookupChannelDataDAO.php');
// require(ROOT_PATH  . 'lib\\db\\PostgreSQLClass.php');

require (ROOT_PATH . 'lib/define/Conf.php');
require(ROOT_PATH . 'lib/dao/LookupChannelDataDAO.php');
require(ROOT_PATH . 'lib/db/PostgreSQLClass.php');

$today = date("YmdHis");


$file_name = "Users_Report_" . $today . ".xls";
$lookupChannel = new LookupChannelDataDAO;

$channel_input = $_POST['channel_ex'];

$dataReport = $lookupChannel->getDataReport($channel_input);
if (count($dataReport) == 0) {
    echo json_encode(array('empty' => 1));
    die();
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
//$objPHPExcel->getProperties()->setCreator("SaigonBPO")
//->setLastModifiedBy("SaigonBPO")
//->setTitle("SaigonBPO Report")
//->setSubject("Report document")
//->setDescription("Report document")
//->setKeywords("report")
//->setCategory("report file");
///* ---------------------------Sheet General-------------------------------- */
//$objPHPExcel->setActiveSheetIndex(0);
//$objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//$objPHPExcel->getActiveSheet()->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
//foreach (range('A', 'Z') as $columnID) {
//$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
//->setAutoSize(true);
//}
//$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->getStyle(1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$arrheader = array();
$i = 0;
foreach ($dataReport[0] as $key => $value) {
    $arrheader[$i++] = $key;
}
$dataReport = json_decode(json_encode($dataReport),true);
$objPHPExcel->getActiveSheet()->fromArray($arrheader, NULL, 'A1');
$objPHPExcel->getActiveSheet()->fromArray($dataReport, NULL, 'A2');
//$objPHPExcel->getActiveSheet()->set
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Users Report');

$objPHPExcel->getActiveSheet() ->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet() ->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet() ->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet() ->getColumnDimension('J')->setAutoSize(true);


/* ---------------------------Save data-------------------------------- */
//$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename=' . $file_name);
//header('Cache-Control: max-age=0');
//// If you're serving to IE 9, then the following may be needed
//header('Cache-Control: max-age=1');
//
//// If you're serving to IE over SSL, then the following may be needed
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//header('Pragma: public'); // HTTP/1.0
$path = ROOT_PATH . 'exportexcel/export/'.$file_name;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($path);
echo json_encode(array('link' => '../exportexcel/export/'.$file_name));

//exit;

?>