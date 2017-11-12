<?php

// Start the session
session_start();
?>
<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Ho_Chi_Minh');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
/** Include PHPExcel */
require_once dirname(__FILE__) . '/../phpexcel/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("SAIOGON BPO")
        ->setLastModifiedBy("SAIGON BPO")
        ->setTitle("SAIOGON BPO Report")
        ->setSubject("Report document")
        ->setDescription("Report document")
        ->setKeywords("report")
        ->setCategory("report file");










