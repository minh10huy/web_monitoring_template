<?php
    set_include_path(implode(PATH_SEPARATOR, array(
        realpath(__DIR__ . '/..'),
        get_include_path()
    )));
        require 'PHPMailer/PHPMailerAutoload.php';
        require 'lib/define/mailConf.php';
        include("grabz/lib/GrabzItClient.class.php");      
        
$grabzIt = new GrabzItClient("Y2I2ZDc3ZjMwNTg4NDg4YTgzYWY5MjM1MDZjOTAwNWQ=", "Pz8/Pz8/Pz8/NVBhPz81Pz8JPwA8ITE/d21FPz8rP0M=");        
$grabzIt->SetImageOptions("http://fec1.saigonbpo.vn:8181/report/tat_hourly_test.php"); 
$grabzIt->SaveTo("img/test.jpg");
die;
        $mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();      
        // Set mailer to use SMTP
        $mail->Host = EmailConf::smtpHost;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = EmailConf::smtpUser;                 // SMTP username
        $mail->Password = EmailConf::smtpPass;                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = EmailConf::smtpPort;  //25                                  // TCP port to connect to

        $mail->From = EmailConf::from;
        $mail->FromName = EmailConf::fromName;
        $mail->isHTML(true);
        
$body = file_get_contents('report/report_tat_email_content.php'); 
//$body = eregi_replace("[]",'',$body);        

echo $body;die;

//$qr = 0;$size ='250';$EC_level='L';$margin='0';        
//$imageSrc = 'http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$qr;
//echo  $imageSrc; die;       
//$content = base64_encode(file_get_contents('http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$qr));        
////$image = '<img src="'.$imageSrc.'" alt="QR code" width="'.$size.'" height="'.$size.'"/>';     
//$image = '<img src="data:image/jpg;base64,'.$content.'" height="250" width="250" alt="base64" />';
        
        
        
        $mail->Subject = 'Test Auto Email';
        $mail->Body = ($body);
        $mail->AltBody = 'test thoi ma';
        
        $mail->addAddress('mui.dd@saigonbpo.vn', 'Đặng Đình Mùi');
        //$mail->addAddress("77thienlong77@gmail.com", "Đặng Đình Mùi");
        // Send mail
        if (!$mail->send()) {
            $result.= ' Email could not be sent';
            $result.= ' Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $result.= ' Email has been sent';
        }                
        
        
        
        die;
        
        
        
$qr = $_GET['number'];

// Check if numeric
if (!is_numeric($qr)) $qr = 0;
// or validate somehow the input

function google_qr($qr,$size ='250',$EC_level='L',$margin='0') {

$imageSrc = 'http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$qr;
$image = '<img src="'.$imageSrc.'" alt="QR code" width="'.$size.'" height="'.$size.'"/>';

echo $image;

// --- Send as remote image
$to       = 'muidd@saigonbpo.vn';
$subject  = 'QR mail test';
$message  = "Message header comes here...<br />$image<br />...message footer comes here";
$headers  = "From: noreply@example.com\r\n";
$headers  = "Reply-To: noreply@example.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
mail($to, $subject, $message, $headers);

// --- Send as attachment
$to       = 'muidd@saigonbpo.vn';
$subject  = 'QR mail test with attachment';
$headers  = "From: mui.dd@saigonbpo.vn\r\n";
$headers  = "Reply-To: mui.dd@saigonbpo.vn\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$boundary = md5(date('r', time()));
$headers .= "Content-Type: multipart/mixed; boundary=\"mixed-$boundary\"\r\n";

$rawImage = chunk_split(base64_encode(file_get_contents($imageSrc)));

$message = "
--mixed-$boundary
Content-Type: multipart/alternative; boundary=\"alt-$boundary\"

--alt-$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

Hello!
See the attached image.

--alt-$boundary
Content-Type: text/html; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

<h2>Hello!</h2>
See the attached <strong>image</strong>.

--alt-$boundary--

--mixed-$boundary
Content-Type: image/png; name=\"QR.png\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment

$rawImage
--mixed-$boundary--";

mail($to, $subject, $message, $headers);

}

google_qr($qr,250);

?>
