<?php

require_once 'lib/define/Conf.php';
require_once 'lib/db/PostgreSQLClass.php';

class CRCDAO {

    var $conf;

    function __construct() {
        $this->conf = new ConfCRC();
    }

    function getCusDataCRC($mana_id) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT(true);
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();
            $query = "SELECT    m.*,
                                d.id as data_id,
                                d.create_time,
                                d.badimage,
                                d.reasonbad,
                                d.typist_name,
                                d.capture_date,
                                d.capture_date_time,
                                regexp_replace(d.tensanpham,E'^(.+) - ([0-9]+([- 0-9]+)?)$','\\1') as \"ten_san_pham\",
                                substring(d.tensanpham,E' - ([0-9]+([- 0-9]+)?)$') as \"ma_san_pham\",
                                d.id_f1,
                                CASE
                                  WHEN m.form_id =1 THEN 'NTB'
                                  WHEN m.form_id =3 THEN 'QDE'
                                  WHEN m.form_id =4 THEN 'PL-PreApprove'
                                  WHEN m.form_id =9 THEN 'CRC-PreApprove'
                                  ELSE ''
                                 END AS \"inputype\",                                                               
                                d.user_input,
                                d.cc_code,
                                d.cc_name,
                                d.sodienthoai_tsa,
                                d.tensanpham,
                                d.sotienvay,
                                d.thoihanvay,
                                d.code_tsa,
                                d.name_tsa,
                                d.code_dsa,
                                d.name_dsa,
                                d.reason_qde,
                                d.baohiem_vay,
                                d.tenkhachhang,
                                d.so_id_cu,
                                d.so_cmnd,
                                d.ngaycap_cmnd,
                                d.noicap_cmnd,
                                d.date_of_closure,
                                d.kenh_giai_ngan,
                                d.branch_code,
                                d.dia_chi_thuong_tru,
                                d.dia_chi_tam_tru,
                                d.sdt_thamchieu1,
                                d.sdt_thamchieu2, 
                                d.thongtin_vochong,
                                d.thunhap_kh_bsung,
                                d.chiphi_kh_bsung,
                                d.sdt_kh_bsung,
                                d.so_cmnd_bsung,
                                d.noicap_cmnd_bsung,
                                d.id_f1_old,
                                d.masanpham,
                                d.remark,
                                d.sodienthoai_sale,                                
                                d.monthly_income_family,
                                d.monthly_costs_family,
                                d.no_modified_fields,
                                d.modified_fields,
                                d.reason_bad,
                                d.description,                                
				d.birthday,
                                d.offered_credit_limit,
                                d.embossing_name,
                                d.mailing_address,
                                d.answer_for_security_question,
                                d.card_insurance_type
                                from $proj_schema.data d join $proj_schema.management m on d.management_id = m.id where m.id = " . $mana_id;
            // call the function
            $stmt = $con->prepare($query);

            if (null == $stmt) {
                return $results;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        //print_r($results[0]);die;
        return $results;
    }

    function getQDEHistoryCRC($idF1) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT(true);
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();
            $sql = "SELECT d.id, d.create_time, d.capture_date_time
                from $proj_schema.data d
                where d.id_f1 = '$idF1' order by d.id";
            // call the function
            $stmt = $con->prepare($sql);

            if (null == $stmt) {
                return $results;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();
            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $results;
    }

    function check_mana_id_work_CRC($idF1) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT(true);
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();
            $sql = "SELECT managementid 
                from $proj_schema.assign a
                where a.managementid = $idF1 limit 1";
            // call the function
            $stmt = $con->prepare($sql);

            if (null == $stmt) {
                return $results;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();
            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $results;
    }

    function getCusDataQDECRC($mana_id) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT(true);
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            // call the function
            $stmt = $con->prepare("SELECT m.bad_status, m.capture_status
                                from $proj_schema.management m where m.id = " . $mana_id);

            if (null == $stmt) {
                return $results;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        //print_r($results[0]);die;
        return $results;
    }

    function getHistoryUpdateDataCRC($mana_id) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT(true);
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();
            $sql = "SELECT change_detail, change_date, change_time, change_by
                    FROM $proj_schema.preapprove_data_change_log where managementid = $mana_id and change_detail <> ''";
            // call the function
            $stmt = $con->prepare($sql);

            if (null == $stmt) {
                return $results;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();
            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $results;
    }

    function insertQDE($cc_code, $file_name = '', $idF1, $cus_id, $cus_name, $reason, $type, $error_code, $qde_type_code = '') {
        $proj_schema = $this->conf->digi_soft_dbschema;
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT(true);
            if (!$con) {
                return false;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            $stmt = $con->prepare("insert into " . $proj_schema . ".upload_qde" . "(cc_code, file_name, id_f1, cus_name, cus_id_number, reason, error_code, is_pre_approved, qde_type, qde_type_code) VALUES (" .
                    "'" . $cc_code . "', '" . $file_name . "', '" . $idF1 . "', '" . pg_escape_string($cus_name) . "', '" . $cus_id . "', '" . $reason . "','" . $error_code . "', 1, 2, '" . $qde_type_code . "')");
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);
            return $result;
        } catch (Exception $e) {
            
        }
    }

    function cancel_qde($mana_id, $qde_mana_id) {

        $proj_schema = $this->conf->digi_soft_dbschema;
        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT(true);
            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();


            $stmt = $con->prepare("update $proj_schema.management set is_have_qde = false where id = $mana_id RETURNING id;");
            $stmt2 = $con->prepare("update $proj_schema.management set bad_status = 2 where id = $qde_mana_id RETURNING id;");

            if (null == $stmt) {
                return false;
            }
            $result = $stmt->execute();
            $result2 = $stmt2->execute();
            $con->commit();
            unset($stmt);

            return $result && $result2;
        } catch (Exception $e) {
            
        }
        return false;
    }    
}
