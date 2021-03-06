<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
//$filteredData=substr($_POST['img_val'], strpos($_POST['img_val'], ",")+1);
$img_val_tbl_st = $_POST['img_val_tbl_st'];
$img_val_hourly_amount = $_POST['img_val_hourly_amount'];
$img_val_hourly_user = $_POST['img_val_hourly_user'];
//Decode the string
//$unencodedData=base64_decode($filteredData);
//$image = '<img src="data:image/jpg;base64,'.$filteredData.'" alt="base64" />';
//$image2 = '<img src="'.$filteredData.'" />';
//Save the image
//file_put_contents('report/img/img.png', $unencodedData);
require 'PHPMailer/PHPMailerAutoload.php';
require 'lib/define/mailConf.php';

$mail = new PHPMailer;
$mail->CharSet = 'UTF-8';
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
$current_date = date("d.m.y");
$current_time = date("H:i");
$mail->Subject = '[VPB_FE] Hourly Report ngày '.$current_date.' lúc '.$current_time;
//$message = file_get_contents('report/emailtemplate.php');
//$mail->MsgHTML(stripslashes($message)); 
$message = 'Dear Anh/Chị, <BR> <BR>Hourly Report ngày '.$current_date.' lúc '.$current_time.'';
$message = $message.'<BR>'.'***Thông tin hồ sơ theo giờ:';
$message = $message.'<BR>'.$img_val_tbl_st;
$message = $message.'<BR>'.'***Sơ đồ số lượng hàng down theo giờ:';
$message = $message.'<BR>'.$img_val_hourly_amount.'<BR>';
//$message = $message.'<BR>'.'***Sơ đồ nguồn lực theo giờ:';
//$message = $message.'<BR>'.$img_val_hourly_user;
$message = $message.'<BR>'.'Anh/chị vui lòng nắm thông tin bên trên giúp em nhé! <BR><BR>';
$message = $message.'SAIGON BPO Ltd. <BR>T: + 84 8 7300 8184 <BR> M: + 0938735082';

$mail->Body = ($message);
$mail->AltBody = 'SGB Hourly Report';
$mail->addAddress("vi.ntx@saigonbpo.vn", "Nguyễn Thụy Xuân Vi");
$mail->addAddress("mui.dd@saigonbpo.vn", "Đặng Đình Mùi");
$mail->addAddress("tuyen.ntk@saigonbpo.vn", "Nguyễn Thị Kim Tuyền");
$mail->addAddress("tam.nm@saigonbpo.vn", "Nguyễn Thị Kim Tuyền");
//$mail->addAddress("tan.truong@fecredit.com.vn", "Trương Hoàng Tân");

$mail->send();
echo "<h1>Gởi mail thành công!</h1>";
?>