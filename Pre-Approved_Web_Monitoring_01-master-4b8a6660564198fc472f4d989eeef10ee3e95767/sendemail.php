<?php

$flagsendmail = true;

if($flagsendmail) {

require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

//$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.saigonbpo.vn';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'non-reply';                 // SMTP username
$mail->Password = 'S@igonbpo';                           // SMTP password
$mail->SMTPSecure = 'starttls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->setFrom('non-reply@saigonbpo.vn', 'Warning Autodownload');
$mail->addAddress('huy.td@saigonbpo.vn', 'ITD');
//$mail->addAddress('itd@saigonbpo.vn', 'ITD');     // Add a recipient
//$mail->addAddress('tam.nm@saigonbpo.vn', 'Tam Nguyen Minh');               // Name is optional
//$mail->addAddress('tuyen.ntk@saigonbpo.vn', 'Tuyen Nguyen Thi Kim');
//$mail->addAddress('sdd@saigonbpo.vn', 'SDD');

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = '[WARNING] Autodownload incorrect';

$bodymess =<<<MESSAGE

<html>
<body style="background-color:powderblue;">
	<h3>Autodownload getting slow or droping mount drive</h3>
	<a href="http://fec1.saigonbpo.vn:8181/file_warning.php">Visit URL to view detail</a>
</body>
</html>

MESSAGE;

$mail->Body    = $bodymess;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//$date = date('Y-m-d H:i:s');
if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

}

?>

