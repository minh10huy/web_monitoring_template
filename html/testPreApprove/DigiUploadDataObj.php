<?php

require_once 'Conf.php';
require_once 'PostgreSQLClass.php';

class DigiUploadDataObj {

    var $conf;

    function __construct() {
        $this->conf = new Conf();
    }

    function checkUserLogin($username, $password) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        //print_r($proj_schema);        
        try {
// Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }

// begin transaction, this is all one process
            $con->beginTransaction();
//           print_r("select cc_name, cc_password, channel, province from " . $proj_schema . ".lookup_channel ".
//                    "where cc_code like "."'".$username."'" );
            $stmt = $con->prepare("select cc_name, cc_password, channel, province from " . $proj_schema . ".lookup_channel " .
                    "where cc_code like " . "'" . $username . "'");

            $stmt->execute();
            $cursors = $stmt->fetchAll();
            //print_r($cursors);
            $stmt->closeCursor();
            $results = $cursors[0];

            //$con->commit();
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $results;
    }

    function insertUploadInfo($cc_code, $file_name, $type, $ip = '0.0.0.0') {
        $proj_schema = $this->conf->digi_soft_dbschema;

        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return false;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = null;
            // call the function
            //INSERT INTO db_16001_0001_bak_20160525.upload_info (cc_code, file_name, type, ip) VALUES (123, 'Cheese.zip', 'NewApp', '10.10.10.10');
//            print_r("insert into " . $proj_schema . ".upload_info " . "(cc_code, file_name, type, ip) VALUES (" .
//                    "'" . $cc_code . "', '" . $file_name . "', '" . $type . "', '" . $ip . "')");
            $stmt = $con->prepare("insert into " . $proj_schema . ".upload_info " . "(cc_code, file_name, type, ip) VALUES (" .
                    "'" . $cc_code . "', '" . $file_name . "', '" . $type . "', '" . $ip . "')");
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);
            return $result;
        } catch (Exception $e) {
            
        }
    }
    
    function insertQDE($cc_code, $file_name = '', $idF1, $cus_id, $cus_name, $reason) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return false;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = null;
            // call the function
            $stmt = $con->prepare("insert into " . $proj_schema . ".upload_qde" . "(cc_code, file_name, id_f1, cus_name, cus_id_number, reason) VALUES (" .
                    "'" . $cc_code . "', '" . $file_name . "', '" . $idF1 . "', '". $cus_name . "', '" . $cus_id . "', '". $reason . "')");            
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);
            return $result;
        } catch (Exception $e) {
            
        }
    }    

    function countUploadPerDay($cc_code, $date, $type) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        //print_r($proj_schema);        
        try {
// Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
// begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = '';
            if ($type == 'HOSOMOI') {
                $stmt = $con->prepare("select count(*) from " . $proj_schema .
                        ".upload_info where upload_info.cc_code = " . "'" . $cc_code . "'" .
                        " and upload_info.upload_date = date" . "'" . $date . "'" . " and upload_info.type = " . "'" . $type . "'");
            } else {
                $stmt = $con->prepare("select count(*) from " . $proj_schema .
                    ".view_upload_info where (type = 'HOSOBOSUNG' OR upload_type = 'upload_qde') and upload_date = date" . "'" . $date . "'" ."and cc_code = " . "'" . $cc_code . "'"." and file_name != ''");
//                $stmt = $con->prepare("select count(*) from " . $proj_schema .
//                        ".upload_qde_test where upload_qde_test.cc_code = " . "'" . $cc_code . "'" .
//                        " and upload_qde_test.upload_date = date" . "'" . $date . "'");                
            }
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            //print_r($cursors);
            $stmt->closeCursor();
            $results = $cursors[0];
            //$con->commit();
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $results;
    }

    function uploadPerDay($cc_code, $date, $type) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        //print_r($proj_schema);        
        try {
// Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
// begin transaction, this is all one process
            $con->beginTransaction();
//            print_r("select view_upload_info_test.file_name from " . $proj_schema .
//                    ".view_upload_info_test where view_upload_info_test.cc_code = " . "'" . $cc_code . "'" .
//                    " and view_upload_info_test.upload_date = date" . "('" . $date . "')" . " and view_upload_info_test.type = " . "'" . $type . "'"." and file_name != ''");
//            die;
            $stmt = $con->prepare("select view_upload_info.file_name from " . $proj_schema .
                    ".view_upload_info where view_upload_info.cc_code = " . "'" . $cc_code . "'" .
                    " and view_upload_info.upload_date = date" . "('" . $date . "')" . " and view_upload_info.type = " . "'" . $type . "'"." and file_name != ''");

            $stmt->execute();
            $cursors = $stmt->fetchAll();
            //print_r($cursors);
            $stmt->closeCursor();
            $results = array();
            $results = $cursors;
            //$con->commit();
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $results;
    }

    function checkIDF1($idf1) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        //print_r($proj_schema);        
        try {
// Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }

            $con->beginTransaction();
            $stmt = $con->prepare("select * from $proj_schema.sp_search_id_f1('" . $idf1 . "');");
            //echo ("select * from $proj_schema.sp_search_id_f1('".$idf1."');");die;
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();
            //echo $cursors[0][0];die;
            // get each result set
            $results = array();
            foreach ($cursors as $k => $v) {
                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
                $results[$k] = $stmt->fetchAll();

                $i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {

                    foreach ($results[$k][$j] as $key => $value) {
                        if (!is_int($key)) {
                            $resultDataReport[$i][$key] = $value;
                        }
                    }
                    $i++;
                }

                break;
            }
            $con->commit();
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
    }

    function checkWarning($ccCode, $today, $time) {
        $existData = $this->checkExistData($ccCode);
        $last_date = $existData[0]['push_date'];
        $last_time = $existData[0]['push_time'];
        //echo $last_date."   ".$last_time;die;
        if (count($existData) > 0) {
            $this->updateDate($ccCode, $today, $time);
        } else {
            $this->insertData($ccCode);
        }

        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        //echo "select folder_customer_name from $proj_schema.management_test where cc_code_from_zip = '" . $ccCode . "' and createdtime >= '" . $last_date . " " . $last_time . "' and bad_status > 0 limit 1;"; die;
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            $con->beginTransaction();

            // get the last time pushing by this sale
            $stmt = $con->prepare("select folder_customer_name from $proj_schema.management_test where cc_code_from_zip = '" . $ccCode . "' and createdtime >= '" . $last_date . " " . $last_time . "' and bad_status > 0 limit 1;");
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();
            $resultDataReport = $cursors;
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
    }

    function getBadApp($ccCode, $today) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        //echo "select folder_customer_name, filename, reason_bad, notes, folder_customer_cmnd, createdtime from $proj_schema.management_test where cc_code_from_zip = '" . $ccCode . "' and createdtime >= '" . $today . " 00:00:00" . "' and bad_status > 0 order by createdtime DESC;";die;
        try {
            //echo "select folder_customer_name, filename, reason_bad, notes, folder_customer_cmnd, createdtime from $proj_schema.management where cc_code_from_zip = '" . $ccCode . "' and createdtime >= '" . $today . " 00:00:00" . "' and bad_status > 0 order by createdtime DESC;";die;
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            $con->beginTransaction();

            // get the last time pushing by this sale
            $stmt = $con->prepare("select folder_customer_name, filename, reason_bad, notes, folder_customer_cmnd, createdtime from $proj_schema.management_test where cc_code_from_zip = '" . $ccCode . "' and createdtime >= '" . $today . " 00:00:00" . "' and bad_status > 0 order by createdtime DESC;");
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();
            $resultDataReport = $cursors;
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
    }

    function getAppStatusFromTo($ccCode, $fromdate, $todate, $typeview) {
        $intTypeView = 0; //All
        switch ($typeview) {
            case 'ALL':
                $intTypeView = 0;
                break;
            case 'BAD':
                $intTypeView = 1;
                break;
            case 'PROCESSING':
                $intTypeView = 2;
                break;
            case 'SUCCESS':
                $intTypeView = 3;
                break;
            default:
                break;
        }
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
//echo "SELECT $proj_schema.sp_dgt_get_report_status_by_cccode('"
//                    . $ccCode . "', '" . $fromdate . " 00:00:00' ::timestamp without time zone, '" . $todate
//                    . " 23:59:59' ::timestamp without time zone, ".$intTypeView . " );";die;
        try {

            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            $con->beginTransaction();

            // get the last time pushing by this sale
            $stmt = $con->prepare("SELECT $proj_schema.sp_dgt_get_report_status_by_cccode('"
                    . $ccCode . "', '" . $fromdate . " 00:00:00' ::timestamp without time zone, '" . $todate
                    . " 23:59:59' ::timestamp without time zone, ".$intTypeView . " );");
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();
            
            $results = array();
            foreach ($cursors as $k => $v) {
                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
                $results[$k] = $stmt->fetchAll();

                $i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {

                    foreach ($results[$k][$j] as $key => $value) {
                        if (!is_int($key)) {
                            $resultDataReport[$i][$key] = $value;
                        }
                    }
                    $i++;
                }

                break;
            }
            $con->commit();
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
    }

    function getAppStatusID($ccCode, $cus_id) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        //echo "select folder_customer_name, filename, reason_bad, notes, folder_customer_cmnd, createdtime from $proj_schema.management_test where cc_code_from_zip = '" . $ccCode . "' and createdtime >= '" . $today . " 00:00:00" . "' and bad_status > 0 order by createdtime DESC;";die;
        try {
//echo "select folder_customer_name, filename, reason_bad, notes, folder_customer_cmnd, createdtime from $proj_schema.management where cc_code_from_zip = '" 
//                                    . $ccCode . "' and folder_customer_cmnd = '".$cus_id."';"; die;
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            $con->beginTransaction();

            // get the last time pushing by this sale
//            $stmt = $con->prepare("select folder_customer_name, filename, reason_bad, notes, folder_customer_cmnd, createdtime from $proj_schema.management where cc_code_from_zip = '" 
//                                    . $ccCode . "' and folder_customer_cmnd = '".$cus_id."';");
            $stmt = $con->prepare("select $proj_schema.sp_dgt_get_report_status_by_cus_id_and_cccode('" . $cus_id . "', '" . $ccCode . "');");
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();

            $results = array();
            foreach ($cursors as $k => $v) {
                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
                $results[$k] = $stmt->fetchAll();

                $i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {

                    foreach ($results[$k][$j] as $key => $value) {
                        if (!is_int($key)) {
                            $resultDataReport[$i][$key] = $value;
                        }
                    }
                    $i++;
                }

                break;
            }
            $con->commit();
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
    }

    function insertData($cc_code) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return false;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = null;
            // call the function
            $stmt = $con->prepare("insert into " . $proj_schema . ".time_push_management" . "(cc_code) VALUES (" . "'" . $cc_code . "')");
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);
            return $result;
        } catch (Exception $e) {
            
        }
    }

    function updateDate($cc_code, $date, $time) {
        //UPDATE films SET kind = 'Dramatic' WHERE kind = 'Drama';
        $proj_schema = $this->conf->digi_soft_dbschema;

        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return false;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = null;
            // call the function
            $stmt = $con->prepare("UPDATE " . $proj_schema . ".time_push_management" . " SET push_date = '" . $date .
                    "', push_time = '" . $time . "' WHERE cc_code = '" . $cc_code . "'");
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);
            return $result;
        } catch (Exception $e) {
            
        }
    }

    function selectData() {
        
    }

    function checkExistData($cc_code) {
        //select exists (select 1 from db_16001_0001_bak_20160525.time_push_management where cc_code = 'CC100785' limit 1)
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            $con->beginTransaction();
            $stmt = $con->prepare("select * from db_16001_0001_bak_20160525.time_push_management where cc_code = '" . $cc_code . "' limit 1");
            //echo "select * from db_16001_0001_bak_20160525.time_push_management where cc_code = '" . $cc_code . "' limit 1";die;
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();
            $resultDataReport = $cursors;
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
//        if (count($resultDataReport) > 0) {
//            return true;
//        }
//        return false;
    }

    function getWarningVPBank($ccCode, $today) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            //echo "select id_f1, qde_starting_time, last_update_time, last_cas_status, client_name, reason_needaddinfo_qde from $proj_schema.warning_from_vpbank where dsa_code = '" . $ccCode . "' and date_of_adsapp_creation >= '" . $today . " 00:00:00' order by last_update_time DESC;";die;
            $con->beginTransaction();

            // get the last time pushing by this sale
            $stmt = $con->prepare("select id_f1, qde_starting_time, last_update_time, last_cas_status, client_name, reason_needaddinfo_qde from $proj_schema.warning_from_vpbank where dsa_code = '" . $ccCode . "' and date_of_app_creation >= '" . $today . " 00:00:00' order by last_update_time DESC;");
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();
            $resultDataReport = $cursors;
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
    }

    function getWarningVPBankFromTo($ccCode, $fromdate, $todate) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            //echo "select id_f1, qde_starting_time, last_update_time, last_cas_status, client_name, reason_needaddinfo_qde from $proj_schema.warning_from_vpbank where dsa_code = '" . $ccCode . "' and date_of_adsapp_creation >= '" . $today . " 00:00:00' order by last_update_time DESC;";die;
            $con->beginTransaction();

            // get the last time pushing by this sale
            $stmt = $con->prepare("select id_f1, qde_starting_time, last_update_time, last_cas_status, client_name, reason_needaddinfo_qde from $proj_schema.warning_from_vpbank where dsa_code = '" . $ccCode . "' and date_of_app_creation >= '" . $fromdate . " 00:00:00' and  date_of_app_creation <= '" . $todate . " 23:59:59' order by last_update_time DESC;");
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();
            $resultDataReport = $cursors;
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
    }

    function checkWarningVPBank($ccCode, $today, $time) {
        //echo "select id_f1 from $proj_schema.warning_from_vpbank where dsa_code = '" . $ccCode . "' and date_of_app_creation >= '" . $today ." ".$time. "' limit 1;";die;
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            $con->beginTransaction();

            // get the last time pushing by this sale
            $stmt = $con->prepare("select id_f1 from $proj_schema.warning_from_vpbank where dsa_code = '" . $ccCode . "' and date_of_app_creation >= '" . $today . " " . "00:00:00" . "' limit 1;");
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();
            $resultDataReport = $cursors;
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $resultDataReport;
    }	
	
}
