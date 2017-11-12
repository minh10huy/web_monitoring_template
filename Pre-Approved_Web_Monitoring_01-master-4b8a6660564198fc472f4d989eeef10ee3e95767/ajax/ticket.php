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

    //$data = $vpBank->getHistoryTicket($_SESSION['monitoring_username'], $date_input, $_SESSION['usercompany']);
	$data = $vpBank->getHistoryTicket($_SESSION['monitoring_username'], $date_input, $_SESSION['usercompany'],$_SESSION['monitoring_userrole']);

    $util = new Util();
    $resultData = $util->analysisDataTicket($data);
    $result_monitoring = array(
        'resultData' => $resultData,
//    , 'resultDataReportDetailsSpeed' => $resultDataReportDetailsSpeed
    );      
//dung ham json_encode de chuyen mang $warning thanh chuoi JSON
    echo json_encode($result_monitoring);

//ket thuc tra ve du lieu va stop khong cho chay tiep
    die;
}
?>