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
    
    function get_file_path_by_id($mana_id) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();
            $sql = "SELECT m.filepath, m.filename  
                from $proj_schema.management m
                where m.id = $mana_id";
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
    
    function getWarningData($cc_code) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();
            $sql = "SELECT o.*, m.folder_customer_name, m.folder_customer_cmnd 
                from offline_warning_status o
                join management m on o.management_id = m.id
                where o.is_read = 0 and o.cc_code = '".$cc_code."'";

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
    
    function getAppFileNTB($mana_id) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();
            $sql = "SELECT m.id, m.filename, m.upload_time, m.filepath
                    FROM db_16001_0001_bak_20160525.management m
                    where m.filepath = (select filepath from management where id = $mana_id)";
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
    
    function getSaleData($ccCode, $from, $to) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();
            $sql = "SELECT m.id as management_id, m.cc_code_from_zip as ccCode, m.ntb_status, m.ntb_reason,
	m.folder_customer_name, m.folder_customer_cmnd, m.reason_bad, 
	d.id_f1, d.code_dsa, d.code_tsa
  FROM $proj_schema.data d
  join $proj_schema.management m on d.management_id = m.id
where  m.form_id = 1 and m.createdtime::date >= '".$from."'::date and  m.createdtime::date <= '".$to."'::date and m.cc_code_from_zip = '".$ccCode."'
order by d.id desc";
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

    function __construct() {
        $this->conf = new Conf();
    }

    function getCusDataCRC($mana_id) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            // call the function
            $stmt = $con->prepare("SELECT *
                                from $proj_schema.pre_approve_crc where management_id = " . $mana_id);

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

    function getCusDataTOPUP($mana_id) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            // call the function
            $stmt = $con->prepare("SELECT m.*,
                                d.id as data_id,
                                d.create_time,
                                d.badimage,
                                d.reasonbad,
                                d.typist_name,
                                d.capture_date,
                                d.capture_date_time,
                                d.dsa_fpc_code,
                                d.tsa_tsr_code,
                                regexp_replace(d.tensanpham,E'^(.+) - ([0-9]+([- 0-9]+)?)$','\\1') as \"ten_san_pham\",
                                substring(d.tensanpham,E' - ([0-9]+([- 0-9]+)?)$') as \"ma_san_pham\",
                                d.khoan_vay,
                                d.id_f1,
                                d.i_ngay_thang_nam_sinh,
                                CASE
                                  WHEN m.form_id =1 THEN 'NTB'
                                  WHEN m.form_id =3 THEN 'QDE'
                                  WHEN m.form_id =4 THEN 'PL-PreApprove'
                                  WHEN m.form_id =9 THEN 'CRC-PreApprove'
                                  ELSE ''
                                 END AS \"inputype\",                                

                                CASE
                                  WHEN d.i_1_nam !='' THEN 'Nam'
                                  WHEN d.i_1_nu !='' THEN 'Nữ'
                                  ELSE ''
                                 END AS \"gender\",
                                CASE
                                  WHEN d.i_1_tieu_hoc !='' THEN 'Tiểu học'
                                  WHEN d.i_1_thcs !='' THEN 'Trung học cơ sở'
                                  WHEN d.i_1_thpt !='' THEN 'Trung học phổ thông'
                                  WHEN d.i_1_trung_cap !='' THEN 'Trung cấp'    
                                  WHEN d.i_1_cao_dang !='' THEN 'Cao đẳng'
                                  WHEN d.i_1_dai_hoc !='' THEN 'Đại học'
                                  WHEN d.i_1_sau_dh !='' THEN 'Sau đại học'
                                  WHEN d.i_1_hoc_van_khac !='' THEN d.i_1_hoc_van_khac
                                  ELSE ''
                                 END AS \"hocvan\", 
                                 
                                CASE
                                  WHEN d.i_1_doc_than !='' THEN 'Độc thân'
                                  WHEN d.i_1_ket_hon !='' THEN 'Đã kết hôn'
                                  WHEN d.i_1_ly_hon !='' THEN 'Ly hôn'
                                  WHEN d.i_1_tthn_khac !='' THEN d.i_1_tthn_khac                               
                                  ELSE ''
                                 END AS \"honnhan\",
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
                                d.insurance_plus,
                                d.insurance_name
                                from $proj_schema.data d join $proj_schema.management m on d.management_id = m.id where m.id = " . $mana_id);

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

    function getCusDataNTB($mana_id, $type) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $results = array();

        try {

            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $results;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            // call the function
            $stmt = $con->prepare("SELECT m.*,
                                d.id as data_id,
                                d.create_time,
                                d.badimage,
                                d.reasonbad,
                                d.typist_name,
                                d.capture_date,
                                d.capture_date_time,
                                d.dsa_fpc_code,
                                d.tsa_tsr_code,
                                d.san_pham,
                                d.khoan_vay,
                                d.i_ho_ten,
                                d.i_cmnd,
                                d.i_ngay_cap,
                                d.i_noi_cap,
                                
                                CASE
                                  WHEN m.form_id =1 THEN 'NTB'
                                  WHEN m.form_id =3 THEN 'QDE'
                                  WHEN m.form_id =4 THEN 'PL-PreApprove'
                                  WHEN m.form_id =4 THEN 'CRC-PreApprove'
                                  ELSE ''
                                 END AS \"inputype\",                                

                                CASE
                                  WHEN d.i_1_nam !='' THEN 'Nam'
                                  WHEN d.i_1_nu !='' THEN 'Nữ'
                                  ELSE ''
                                 END AS \"gender\",
                                CASE
                                  WHEN d.i_1_tieu_hoc !='' THEN 'Tiểu học'
                                  WHEN d.i_1_thcs !='' THEN 'Trung học cơ sở'
                                  WHEN d.i_1_thpt !='' THEN 'Trung học phổ thông'
                                  WHEN d.i_1_trung_cap !='' THEN 'Trung cấp'    
                                  WHEN d.i_1_cao_dang !='' THEN 'Cao đẳng'
                                  WHEN d.i_1_dai_hoc !='' THEN 'Đại học'
                                  WHEN d.i_1_sau_dh !='' THEN 'Sau đại học'
                                  WHEN d.i_1_hoc_van_khac !='' THEN d.i_1_hoc_van_khac
                                  ELSE ''
                                 END AS \"hocvan\", 
                                 
                                CASE
                                  WHEN d.i_1_doc_than !='' THEN 'Độc thân'
                                  WHEN d.i_1_ket_hon !='' THEN 'Đã kết hôn'
                                  WHEN d.i_1_ly_hon !='' THEN 'Ly hôn'
                                  WHEN d.i_1_tthn_khac !='' THEN d.i_1_tthn_khac                               
                                  ELSE ''
                                 END AS \"honnhan\",
                                 
                                d.i_ngay_thang_nam_sinh,
                                d.i_thoi_han_vay,
                                d.i_dt_di_dong,
                                d.id_f1,
                                d.notes,
                                d.i_6_thu_nhap_cn,
                                d.i_6_thu_nhap_gd,
                                d.i_6_chi_phi_cn,
                                d.i_6_chi_phi_gd,
                                d.i_dt_di_dong,
                                d.user_input,
                                d.sodienthoai_tsa,
                                d.tensanpham,
                                d.sotienvay,
                                d.thoihanvay,
                                d.code_tsa,
                                d.name_tsa,
                                d.code_dsa,
                                d.name_dsa,
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
                                d.dia_chi_thuong_tru_bsung,
                                d.diachi_hientai_bsung,
                                d.thunhap_kh_bsung,
                                d.chiphi_kh_bsung,
                                d.sdt_kh_bsung,
                                d.so_cmnd_bsung,
                                d.noicap_cmnd_bsung,
                                d.id_f1_old,
                                d.masanpham,
                                d.remark,
                                d.sodienthoai_sale,
                                d.reason_qde,
                                d.reason_bad,
                                d.description,
                                d.monthly_income_family,
                                d.monthly_costs_family,
                                d.insurance_plus,
                                d.insurance_name
                                from $proj_schema.data d join $proj_schema.management m on d.management_id = m.id where m.id = " . $mana_id);

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
            $stmt = $con->prepare("select * from db_16001_0001_bak_20160525.sp_get_file_not_download_yet_ddmui()");
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

    function getDataReport($user, $function_name, $date = null, $userrole, $mobile = null) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        if (!isset($user)) {
            return $resultDataReport;
        }

        $userInfo = $this->getUserInfo($user);
        if (count($userInfo) == 0) {
            return $resultDataReport;
        }
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();

            $stmt = null;
            // call the function
            if ($date != null) {
                $splitDate = explode("-", $date);
                $fromDate = trim($splitDate[0]);
                $toDate = trim($splitDate[1]);

                $splitFromDate = explode("/", $fromDate);
                $splitToDate = explode("/", $toDate);

                $fromDate = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0] . " " . "00:00:00";
                $toDate = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0] . " " . "23:59:59";

                if (isset($mobile))
                    $stmt = $con->prepare("select * from $proj_schema.$function_name('" . $fromDate . "','" . $toDate . "', '" . $user . "', '', '1,2', 9999999, 0);");
                else
                    $stmt = $con->prepare("select * from $proj_schema.$function_name('" . $fromDate . "','" . $toDate . "', '" . $user . "');");
            } else {
                // Default return empty
                return $resultDataReport;
            }
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
                        if ($key === "Classify user SG" || $key === "Speed" || $key === "DE user SG" || $key === "Speed DE") {
                            continue;
                        }
                        if ($userrole != "admin" && $key === "Classify Speed") {
                            continue;
                        }
                        if ($userrole != "admin" && $key === "Turn Around Time (h)") {
                            continue;
                        }
                        if ($key === "Classification") {
                            $key = "Check";
                        }
                        if (!is_int($key)) {
                            $resultDataReport[$i][$key] = $value;
                        }
                    }
                    $i++;
                }

                // Chỉ lấy kết quả của con trỏ đầu tiên
                break;
            }

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }

    function getUserInfo($user) {

        $proj_schema = $this->conf->digi_soft_dbschema;

        $resultDataReport = array();
        if (!isset($user)) {
            return $resultDataReport;
        }

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
            $stmt = $con->prepare("select * from $proj_schema.lookup_channel where cc_code = '" . $user . "' limit 1;");

            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();

            for ($i = 0; $i < count($results); $i++) {
                foreach ($results[$i] as $key => $value) {
                    switch ($key) {
                        case "cc_name":
                            $key = "CC Name";
                            $resultDataReport[$key] = $value;
                            break;
                        case "province":
                            $key = "Province";
                            $resultDataReport[$key] = $value;
                            break;
                        case "channel":
                            $key = "Channel";
                            $resultDataReport[$key] = $value;
                            break;
                        default:
                            break;
                    }
                }
            }

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }

    function getAllUser() {

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
            $stmt = $con->prepare("select * from $proj_schema.lookup_channel");

            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();

            for ($i = 0; $i < count($results); $i++) {
                $temp = false;
                foreach ($results[$i] as $key => $value) {
                    if ($key == 7) {
                        $temp = !$temp;
                        continue;
                    }
                    if ($temp) {
                        $resultDataReport[$i][$key] = $value;
                    }
                    $temp = $temp ? false : true;
                }
            }

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }

    function changePassword($user, $newPass) {

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
            if ($newPass != null) {
                $stmt = $con->prepare("update $proj_schema.lookup_channel set cc_password = '" . md5($newPass) . "' where cc_code = '" . $user . "';");
            } else {
                // Default return empty
                return false;
            }
            if (null == $stmt) {
                return false;
            }
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);

            return $result;
        } catch (Exception $e) {
            
        }
        return false;
    }

    function resetPassword($user) {

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


            $stmt = $con->prepare("update $proj_schema.lookup_channel set cc_password = '" . md5("saigonbpo@123") . "' where cc_code = '" . $user . "';");

            if (null == $stmt) {
                return false;
            }
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);

            return $result;
        } catch (Exception $e) {
            
        }
        return false;
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

            $con->beginTransaction();
            $stmt = "";
            if ($type === "qde") {
                $stmt = $con->prepare("select count(*) from " . $proj_schema .
                        ".view_upload_info where (type = 'HOSOBOSUNG' OR upload_type = 'upload_qde') and upload_date = date" . "'" . $date . "'" . "and cc_code = " . "'" . $cc_code . "'" . " and file_name != ''");
            } else {
                $stmt = $con->prepare("select count(*) from " . $proj_schema .
                        ".view_upload_info where (type = 'HOSOMOI' OR upload_type = 'upload_info') and upload_date = date" . "'" . $date . "'" . "and cc_code = " . "'" . $cc_code . "'" . " and file_name != ''");
            }
            $stmt->execute();
            $cursors = $stmt->fetchAll();
            //print_r($cursors);
            $stmt->closeCursor();
            $results = $cursors[0];
            $con->commit();
            unset($stmt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $results;
    }

    function insertCommunication($idF1, $content_request, $post_actor = "", $post_from = 'vpbank') {
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
//            print_r("insert into " . $proj_schema . ".ticket_communication" . "(idf1, content_request, post_actor, post_from) VALUES (" .
//                    "'" . $idF1 . "', '" . $content_request . "', '" . $post_actor . "', '" . $post_from . "')");
            $stmt = $con->prepare("insert into " . $proj_schema . ".ticket_communication" . "(idf1, content_request, post_actor, post_from) VALUES (" .
                    "'" . $idF1 . "', '" . $content_request . "', '" . $post_actor . "', '" . $post_from . "')");
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);
            return $result;
        } catch (Exception $e) {
            
        }
    }

    function insertQDE($cc_code, $file_name = '', $idF1, $cus_id, $cus_name, $reason, $type, $error_code, $qde_type_code = '') {
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
//            print_r("insert into " . $proj_schema . ".upload_qde" . "(cc_code, file_name, id_f1, cus_name, cus_id, reason) VALUES (" .
//                    "'" . $cc_code . "', '" . $file_name . "', '" . $idF1 . "', '". $cus_name . "', '" . $cus_id . "', '". $reason . "')");die;
            if ($type == 3) {
                $stmt = $con->prepare("insert into " . $proj_schema . ".upload_qde" . "(cc_code, file_name, id_f1, cus_name, cus_id_number, reason, error_code, is_pre_approved, qde_type, qde_type_code) VALUES (" .
                        "'" . $cc_code . "', '" . $file_name . "', '" . $idF1 . "', '" . pg_escape_string($cus_name) . "', '" . $cus_id . "', '" . $reason . "','".$error_code."', 1, 1, '".$qde_type_code."')");
            } elseif ($type == 6) {
                $stmt = $con->prepare("insert into " . $proj_schema . ".upload_qde" . "(cc_code, file_name, id_f1, cus_name, cus_id_number, reason, error_code, is_pre_approved, qde_type, qde_type_code) VALUES (" .
                        "'" . $cc_code . "', '" . $file_name . "', '" . $idF1 . "', '" . pg_escape_string($cus_name) . "', '" . $cus_id . "', '" . $reason . "','".$error_code."', 1, 1, '".$qde_type_code."')");
            } else {
                $stmt = $con->prepare("insert into " . $proj_schema . ".upload_qde" . "(cc_code, file_name, id_f1, cus_name, cus_id_number, reason, error_code) VALUES (" .
                        "'" . $cc_code . "', '" . $file_name . "', '" . $idF1 . "', '" . pg_escape_string($cus_name) . "', '" . $cus_id . "', '" . $reason . "', '" . $error_code . "')");
            }
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);
            return $result;
        } catch (Exception $e) {
            
        }
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
            $stmt = $con->prepare("insert into " . $proj_schema . ".upload_info " . "(cc_code, file_name, type, ip) VALUES (" .
                    "'" . $cc_code . "', '" . $file_name . "', '" . $type . "', '" . $ip . "')");
            $result = $stmt->execute();

            $con->commit();
            unset($stmt);
            return $result;
        } catch (Exception $e) {
            
        }
    }

    function getListTicketByID($idF1) {
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
            $stmt = $con->prepare("select * from $proj_schema.ticket_communication where idf1 = $idF1 order by id");

            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();

            for ($i = 0; $i < count($results); $i++) {
                foreach ($results[$i] as $key => $value) {
                    $resultDataReport[$i][$key] = $value;
                }
            }

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }

    function getPMEmail() {

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
            $stmt = $con->prepare("select * from $proj_schema.pm_email");

            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();

            for ($i = 0; $i < count($results); $i++) {
                foreach ($results[$i] as $key => $value) {
                    $resultDataReport[$i][$key] = $value;
                }
            }

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }

    function getSaleEmailViaAppID($idF1) {
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
            $stmt = $con->prepare("select email, cc_name from $proj_schema.lookup_channel 
            where cc_code = (select post_actor from $proj_schema.ticket_communication 
            where idf1 = " . $idF1 . " and post_from = 'vpbank' and post_actor like 'CC%'  limit 1)");

            if (null == $stmt) {
                return $resultDataReport;
            }
            $stmt->execute();
            $results = $stmt->fetchAll();

            for ($i = 0; $i < count($results); $i++) {
                foreach ($results[$i] as $key => $value) {
                    $resultDataReport[$i][$key] = $value;
                }
            }

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }

    function getHistoryQDE($user, $date = null, $usercompany) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $resultDataReport = array();
        if (!isset($user)) {
            return $resultDataReport;
        }

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
            $stmt = null;
            // call the function
            if ($date != null) {
                $splitDate = explode("-", $date);
                $fromDate = trim($splitDate[0]);
                $toDate = trim($splitDate[1]);

                $splitFromDate = explode("/", $fromDate);
                $splitToDate = explode("/", $toDate);

                $fromDate = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0];
                $toDate = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0];
//                $str = "select * from $proj_schema.view_upload_info where upload_type = 'upload_qde' "."and cc_code = " . "'" . $user . "'"
//                        ." and upload_date between '".$fromDate."' and '".$toDate."' order by upload_date desc, upload_time asc";
//                echo $str;die;
                if ($usercompany != null && $usercompany == 'vpbank') {
                    $stmt = $con->prepare("select file_name, upload_date, upload_time, reason from $proj_schema.view_upload_info where upload_type = 'upload_qde' " . "and cc_code = " . "'" . $user . "'"
                            . " and upload_date between '" . $fromDate . "' and '" . $toDate . "' order by upload_date desc, upload_time asc");
                } else {
                    $stmt = $con->prepare("select cc_code, file_name, upload_date, upload_time, reason from $proj_schema.view_upload_info where upload_type = 'upload_qde'"
                            . " and upload_date between '" . $fromDate . "' and '" . $toDate . "' order by upload_date desc, upload_time asc");
                }
            } else {
                // Default return empty
                return $resultDataReport;
            }
            if (null == $stmt) {
                return $resultDataReport;
            }

//            $stmt->execute();
//            $cursors = $stmt->fetchAll();
//            $stmt->closeCursor();
//            // get each result set
//            $results = array();
//            foreach ($cursors as $k => $v) {
//                $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
//                $results[$k] = $stmt->fetchAll();
//
//                $i = 0;
//                for ($j = 0; $j < count($results[$k]); $j++) {
//
//                    foreach ($results[$k][$j] as $key => $value) {
//                        if (!is_int($key)) {
//                            $resultDataReport[$i][$key] = $value;
//                        }
//                    }
//                    $i++;
//                }
//                
//                // Ch? l?y k?t qu? c?a con tr? d?u ti�n
//                break;
//            }
            $stmt->execute();
            $results = $stmt->fetchAll();
            for ($i = 0; $i < count($results); $i++) {
                foreach ($results[$i] as $key => $value) {
                    $resultDataReport[$i][$key] = $value;
                }
            }
            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }

        return $resultDataReport;
    }

    function getHistoryTicket($user, $date = null, $usercompany, $userrole) {
        $proj_schema = $this->conf->digi_soft_dbschema;

        $resultDataReport = array();
        if (!isset($user)) {
            return $resultDataReport;
        }
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
            $stmt = null;
            // call the function
            if ($date != null) {
                $splitDate = explode("-", $date);
                $fromDate = trim($splitDate[0]);
                $toDate = trim($splitDate[1]);
                $splitFromDate = explode("/", $fromDate);
                $splitToDate = explode("/", $toDate);

                $fromDate = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0];
                $toDate = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0];
                if ($usercompany != null && strtolower($usercompany) == 'vpbank') {
                    if (strtolower($userrole) == 'admin' || strtolower($userrole) == 'subadmin') {
                        $stmt = $con->prepare("select distinct on (idf1) idf1, post_actor, post_date from $proj_schema.ticket_communication where"
                                . " post_date between '" . $fromDate . "' and '" . $toDate . "' order by idf1, post_date desc");
                    } else {
                        $stmt = $con->prepare("select distinct on (idf1) idf1,post_actor, post_date from $proj_schema.ticket_communication where post_actor = " . "'" . $user . "'"
                                . " and post_date between '" . $fromDate . "' and '" . $toDate . "' order by idf1 desc, post_date desc");
                    }
                } else {
                    $stmt = $con->prepare("select distinct on (idf1) idf1, post_actor, post_date from $proj_schema.ticket_communication where"
                            . " post_date between '" . $fromDate . "' and '" . $toDate . "' order by idf1, post_date desc");
                }
            } else {
                // Default return empty
                return $resultDataReport;
            }
            if (null == $stmt) {
                return $resultDataReport;
            }

            $stmt->execute();
            $results = $stmt->fetchAll();
            for ($i = 0; $i < count($results); $i++) {
                foreach ($results[$i] as $key => $value) {
                    $resultDataReport[$i][$key] = $value;
                }
            }
            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }

        return $resultDataReport;
    }

    function getDataReportTest($user, $function_name, $date = null, $userrole, $mobile = null) {
        $proj_schema = $this->conf->digi_soft_dbschema;
        $resultDataReport = array();
        if (!isset($user)) {
            return $resultDataReport;
        }

        $userInfo = $this->getUserInfo($user);
        if (count($userInfo) == 0) {
            return $resultDataReport;
        }
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();
            if (!$con) {
                return $resultDataReport;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            $stmt = null;
            // call the function
            if ($date != null) {
                $splitDate = explode("-", $date);
                $fromDate = trim($splitDate[0]);
                $toDate = trim($splitDate[1]);

                $splitFromDate = explode("/", $fromDate);
                $splitToDate = explode("/", $toDate);

                $fromDate = $splitFromDate[2] . "-" . $splitFromDate[1] . "-" . $splitFromDate[0] . " " . "00:00:00";
                $toDate = $splitToDate[2] . "-" . $splitToDate[1] . "-" . $splitToDate[0] . " " . "23:59:59";

                if (isset($mobile))
                    $stmt = $con->prepare("select * from $proj_schema.$function_name('" . $fromDate . "','" . $toDate . "', '" . $user . "', '', '1,2', 9999999, 0);");
                else
                    $stmt = $con->prepare("select * from $proj_schema.$function_name('" . $fromDate . "','" . $toDate . "', '" . $user . "');");
            } else {
                // Default return empty
                return $resultDataReport;
            }
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

                //$i = 0;
                for ($j = 0; $j < count($results[$k]); $j++) {
                    $temp_array = array();

                    foreach ($results[$k][$j] as $key => $value) {
                        if ($key === "Classify user SG" || $key === "Speed" || $key === "DE user SG" || $key === "Speed DE") {
                            continue;
                        }
                        if ($userrole != "admin" && $key === "Classify Speed") {
                            continue;
                        }
                        if ($userrole != "admin" && $key === "Turn Around Time (h)") {
                            continue;
                        }
                        if ($key === "Classification") {
                            $key = "Check";
                        }
                        if (!is_int($key)) {
                            array_push($temp_array, $value);
                        }
                    }
                    array_push($resultDataReport, $temp_array);
                    //$i++;
                }

                // Chỉ lấy kết quả của con trỏ đầu tiên
                break;
            }

            $con->commit();
            unset($stmt);
        } catch (Exception $e) {
            
        }
        return $resultDataReport;
    }

}
