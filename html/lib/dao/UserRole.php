<?php

require_once ROOT_PATH . 'lib/define/Conf.php';
require_once ROOT_PATH . 'lib/db/PostgreSQLClass.php';

/**
 * Description of VPBankDAO
 *
 * @author ntvu_1
 */
class UserRole {

    var $conf;

    function __construct() {
        $this->conf = new Conf();
    }
    
    function getAllRole() {

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

            // call the function
            $stmt = $con->prepare("select * from $proj_schema.channel_role");
            
            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();

            for ($i = 0; $i < count($results); $i++) {
                $temp = false;
                foreach ($results[$i] as $key => $value) {
                    if($temp){
                        $resultDataReport[$i][$key] = $value;
                    }
                    $temp = $temp?false:true;
                }
            }

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }
}
