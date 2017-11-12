<?php

//$filteredData=substr($_POST['img_val'], strpos($_POST['img_val'], ",")+1);
//Decode the string
//$unencodedData=base64_decode($filteredData);
//Save the image
//file_put_contents('report/img/img.png', $unencodedData);
require 'PHPMailer/PHPMailerAutoload.php';
require 'lib/define/mailConf.php';

//require_once 'config.php';
//require (ROOT_PATH . 'lib/define/Conf.php');
//require(ROOT_PATH . 'lib/db/PostgreSQLClass.php');
//require(ROOT_PATH . 'ssp.class.pg.php' );
//
//set_time_limit(1000000);
//$request = $_REQUEST;
//$pgSQL = new PostgreSQLClass();
//$con = $pgSQL->getConDPO_DIGISOFT();
//if (!$con) {
//    echo json_encode(array(
//        "draw" => intval($_REQUEST['draw']),
//        "recordsTotal" => null,
//        "recordsFiltered" => null,
//        "data" => array())
//    );
//    die();
//}
//
//$columns = array(
//    array('db' => 'download_hour', 'dt' => 0),
//    array('db' => 'PL', 'dt' => 1),
//    array('db' => 'QDE', 'dt' => 2),
//    array('db' => 'CRC Pre-Approve', 'dt' => 3));
//$function = "sp_get_data_report_tat_hourly_total_download_with_crc";
//echo json_encode(
//        SSP::simple($con, null, $function, $request, $columns, '2016-07-07')
//);
        


$mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = EmailConf::smtpHost;  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = EmailConf::smtpUser;                 // SMTP username
$mail->Password = EmailConf::smtpPass;                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = EmailConf::smtpPort;  //25                                  // TCP port to connect to

$mail->From = EmailConf::from;
$mail->FromName = EmailConf::fromName;
$mail->isHTML(true);

$mail->Subject = 'Nihon test';
$message = file_get_contents('report/emailtemplate.php');
$mail->MsgHTML(stripslashes($message)); 
//$message = '<img src="'.$_POST['img_val'].'">';
//$mail->MsgHTML(stripslashes($message));
//$mail->Body = '<img src="'.$_POST['img_val'].'">';
$mail->AltBody = 'Altbody Test';
//$mail->addAddress("muidd@saigonbpo.vn", "Đặng Đình Mùi");
$mail->addAddress("77thienlong77@gmail.com", "Đặng Đình Mùi");

$mail->send();
?>
<!--<html>
<head>
<script type="text/javascript">
</script>
</head>
</html>-->