<?php

require_once 'lib/define/Conf.php';
require_once 'lib/db/PostgreSQLClass.php';

/**
 * Description of VPBankDAO
 *
 * @author ntvu_1
 */
class VPBankDAO {

    var $conf;
    var $confcrc;

    function __construct() {
        $this->conf = new Conf();
        $this->confcrc = new ConfCRC();
    }
    function getPendingFileCRC() {
        $proj_schema_crc = $this->confcrc->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT(true);
            if (!$con) {
                return $resultDataReport;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = $con->prepare("select * from $proj_schema_crc.sp_get_total_hoso_crc_pending_monitoring()");
            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();

            // get each result set
            $results = array();
            foreach ($cursors as $k => $v) {
                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
                $results[$k] = $stmt->fetchAll();
                $i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {
                    foreach ($results[$k][$j] as $key => $value) {
                        $resultDataReport[$i][$key] = $value;
                    }
                    $i++;
                }
            }
            // get each result set
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }
 
    function getPendingFile() {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = $con->prepare("select * from $proj_schema.sp_get_total_hoso_pending_monitoring()");
            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();

            // get each result set
            $results = array();
            foreach ($cursors as $k => $v) {
                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
                $results[$k] = $stmt->fetchAll();
                $i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {
                    foreach ($results[$k][$j] as $key => $value) {
                        $resultDataReport[$i][$key] = $value;
                    }
                    $i++;
                }
            }
            // get each result set
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }
    
    function getSpeedNTB() {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = $con->prepare("select * from $proj_schema.sp_get_speed_ntb_top_and_bottom_monitoring()");
            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();

            // get each result set
            $results = array();
            foreach ($cursors as $k => $v) {
                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
                $results[$k] = $stmt->fetchAll();
                $i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {
                    foreach ($results[$k][$j] as $key => $value) {
                        $resultDataReport[$i][$key] = $value;
                    }
                    $i++;
                }
            }
            // get each result set
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    } 
    
    function getSpeedPre() {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = $con->prepare("select * from $proj_schema.sp_get_speed_pre_top_and_bottom_monitoring()");
            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();

            // get each result set
            $results = array();
            foreach ($cursors as $k => $v) {
                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
                $results[$k] = $stmt->fetchAll();
                $i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {
                    foreach ($results[$k][$j] as $key => $value) {
                        $resultDataReport[$i][$key] = $value;
                    }
                    $i++;
                }
            }
            // get each result set
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }      
    
    function getWarningFile() {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = $con->prepare("select * from $proj_schema.sp_get_file_not_download_yet_ddmui()");
            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            $stmt->closeCursor();

            // get each result set
            $results = array();
            foreach ($cursors as $k => $v) {
                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
                $results[$k] = $stmt->fetchAll();
                $i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {
                    foreach ($results[$k][$j] as $key => $value) {
                        $resultDataReport[$i][$key] = $value;
                    }
                    $i++;
                }
            }
            // get each result set
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }    

}
