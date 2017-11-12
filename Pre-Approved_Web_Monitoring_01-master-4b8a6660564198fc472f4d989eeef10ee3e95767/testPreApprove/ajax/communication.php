<?php

// Start the session
session_start();
?>
<?php

$ccCode = $_SESSION['monitoring_username'];
$userrole = $_SESSION['monitoring_userrole'];
//die($ccChannel.$ccCode.$userrole);
if ($userrole == "cc") {
    $post_from = 'vpbank';
} else {
    $post_from = 'saigonbpo';
}
if (isset($_POST['idF1']) && isset($_POST['content'])) {
    set_include_path(implode(PATH_SEPARATOR, array(
        realpath(__DIR__ . '/..'),
        get_include_path()
    )));
    require_once ('../lib/dao/VPBankDAO.php');
    require_once ('../lib/utils/Util.php');
    require_once ('../lib/dto/GetDataReportFunctionName.php');
    $idF1 = $_POST['idF1'];
    $content = $_POST['content'];
    $vpBank = new VPBankDAO();
    $result = $vpBank->insertCommunication($idF1, $content, $ccCode, $post_from);
    if ($result == 1) {
        $result = "Post: OK";
        require '../PHPMailer/PHPMailerAutoload.php';
        require '../lib/define/mailConf.php';

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

        if ($userrole == "cc") {
            $pm_mail = $vpBank->getPMEmail();

            $mail->Subject = 'New Ticket from '.$ccCode;
            $mail->Body = $ccCode.' had posted a ticket for '.$idF1.'. <b>Pls get it & process now!</b>'
                    .'<br> Content: '
                    .'<br> '.$content
                    .'<br> Link: '.'<a target="" title="New Ticket" href="http://fec.saigonbpo.vn:8080/qde_commu.php?idF1='.$idF1.'">http://fec.saigonbpo.vn:8080/qde_commu.php?idF1='.$idF1.'</a>'
                    .'<br> Thank you!';
            $mail->AltBody = $ccCode.' had posted a ticket for '.$idF1;
            foreach ($pm_mail as $key => $value) {
                $mail->addAddress($value['email'], $value['pm_name']);
            }
        } else {
            
            $saleemail = $vpBank->getSaleEmailViaAppID($idF1);
//            die("select email, cc_name from db_16001_0001_bak_20160525.lookup_channel 
//            where cc_code = (select post_actor from db_16001_0001_bak_20160525.ticket_communication 
//            where idf1 = ".$idF1." and post_from = 'vpbank' and post_actor like 'CC%'  limit 1)");
            
            $mail->Subject = 'New Answer From SAIGON BPO for '.$idF1;
            $mail->Body = 'SAIGON BPO had answered for '.$idF1.'. <b> Pls get it & process now!</b>'
                    .'<br> Content: '
                    .'<br> '.$content
                    .'<br> Link: '.'<a target="" title="New Ticket" href="http://fec.saigonbpo.vn:8080/qde_commu.php?idF1='.$idF1.'">http://fec.saigonbpo.vn:8080/qde_commu.php?idF1='.$idF1.'</a>'
                    .'<br> Thank you!';            
            $mail->AltBody = 'New Answer From SAIGON BPO for '.$idF1;
            foreach ($saleemail as $key => $value) {
                $mail->addAddress($value['email'], $value['cc_name']);
            }    
        }        
        // Send mail
        if (!$mail->send()) {
            $result.= ' Email could not be sent';
            $result.= ' Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $result.= ' Email has been sent';
        }
    }

    echo $result;
    die;
}
