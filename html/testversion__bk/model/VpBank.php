<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Personal
 *
 * @author ntvu_1
 */
require_once 'db/Conf.php';
require_once 'db/DbConnection.php';

class VpBank {

    /**
     * Xem username đã tồn tại trong bảng user chưa
     * @author Tuấn Vũ
     * @param type $username
     * @return string
     */
    function checkUsername($username){
        $con = new DbConnection();
        if (!$con->GetDBConnection()) {
            return "Could not connect to mysql server";
        }
        $sql = "SELECT name from users WHERE username = '".$username."' LIMIT 1";

        $result = $con->executeQuery($sql);
        $numRows = mysql_num_rows($result);
        
        $con->CleanUpDB();
        
        return $numRows > 0?true:false;
    }
    
    function getUser(){
        $con = new DbConnection();
        $users = Array();
        if (!$con->GetDBConnection()) {
//            return "Could not connect to mysql server";
            return $users;
        }
        
        $sql = "SELECT username from users";
        
        $result = $con->executeQuery($sql);
        
        while($row = mysql_fetch_assoc($result)){
            $users[] = $row['username'];
        }
        
        $con->CleanUpDB();
        return $users;
    }
    function addSuplement($user, $lack_image, $username, $app_name, $comment){
        $con = new DbConnection();
        if (!$con->GetDBConnection()) {
            return false;
        }
        $sql = "insert into supplement(user, lack_image, dpo_user, app_name, comment) value('".$user."', '".$lack_image."','".$username."', '".$app_name."', '".$comment."')";

        $result = $con->executeQuery($sql);
        
        $con->CleanUpDB();
        
        return $result;
    }
    
    function checkLogin($username, $password){
        $con = new DbConnection();
        if (!$con->GetDBConnection()) {
            return false;
        }
        $sql = "SELECT * from users WHERE username = '".$username."' and password = '".$password."' LIMIT 1";

        $result = $con->executeQuery($sql);
        $numRows = mysql_num_rows($result);
        
        $con->CleanUpDB();
        
        return $numRows > 0?true:false;
    }
    
    /**
     * Lấy Image Upload
     * @param type $upload_from
     * @param type $upload_to
     * @return string
     */
    function getAllImageUpload($upload_from = null, $upload_to = null){
        $con = new DbConnection();
        $imageUpload = Array();
        if (!$con->GetDBConnection()) {
//            return "Could not connect to mysql server";
            return $imageUpload;
        }
        
        $sql = "SELECT * from imageUpload";
        if($upload_from != null && $upload_to != null){
            $sql = "SELECT * from imageUpload where DATE(upload_date) >= DATE('".$upload_from."') AND DATE(upload_date) <= DATE('".$upload_to."')";
        }else if($upload_from != null && $upload_to == null){
            $sql = "SELECT * from imageUpload where DATE(upload_date) >= DATE('".$upload_from."')";
        }else if($upload_from == null && $upload_to != null){
            $sql = "SELECT * from imageUpload where DATE(upload_date) <= DATE('".$upload_to."')";
        }
        
        $result = $con->executeQuery($sql);
        
        $i = 0;
        while($row = mysql_fetch_assoc($result)){
            $imageUpload[$i]['id'] = $row['id'];
            $imageUpload[$i]['username'] = $row['username'];
            $imageUpload[$i]['image_link'] = $row['image_link'];
            $imageUpload[$i]['upload_date'] = $row['upload_date'];
            $imageUpload[$i++]['app_name'] = $row['app_name'];
        }
        $con->CleanUpDB();
        return $imageUpload;
    }
    
    function insertSupplement($user, $lack_image, $dpo_user){
        $con = new DbConnection();
        if (!$con->GetDBConnection()) {
            return false;
        }
        $sql = "insert into supplement value('".$user."', '".$lack_image."', '".$dpo_user."')";
        
        $result = $con->executeQuery($sql);
        
        return $result;
    }
    /**
     * Remove kí tự dấu tiếng việt
     * @author: Tuấn Vũ
     * @param type $str
     * @return type
     */
    function vn_str_filter($str) {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }

    /**
     * Lấy usercode từ fullname
     * @author Tuấn Vũ
     * @param type $fullname
     * @return type
     */
    public function getPerCode($fullname){
        $fullname_nonunicode = $this->vn_str_filter($fullname);
        
        $split_fullname = explode(" ", $fullname_nonunicode);
        
        $len = count($split_fullname);
        if($len == 1){
            return $fullname_nonunicode;
        }
        
        $percode = "";
        for($i = 0; $i < $len - 1;$i++){
            $percode .= $split_fullname[$i][0];
        }
        $percode .= $split_fullname[$len - 1];
        
        return strtolower($percode);
    }
    
    public function insertPersonalInfo($personal) {
        //$personal = new PersonalInfo();
        // Set percode again
        $fullname = $personal->getPer_fullname();
        $perCode = $this->getPerCode($fullname);
        $savePerCode = $perCode;
        
        $i = 1;
        // Nếu username bị trùng thì tăng lên 1
        // cho tới khi không còn trùng nữa thì lấy username đó
        while($this->checkUsername($savePerCode)){
            $savePerCode = $perCode."_".$i;
            $i++;
        }
        $perCode = $savePerCode;
        
        $personal->setPer_code($perCode);
        
        $con = new DbConnection();
        if (!$con->GetDBConnection()) {
            return "Could not connect to mysql server";
        }
        $sql = "INSERT INTO hs_hr_personal_info(`per_code`, `per_fullname`, "
                . "`per_email`, `per_home_phone`, `per_telephone`, `per_dob`,"
                . "`per_pob`, `per_sex`, `per_marital_status`, `per_id_no`, "
                . "`per_doi`, `per_poi`, `per_ethnic`, `per_religion`, `per_permanent_address`, "
                . "`per_current_address`, `per_education1`, `per_education2`, `per_education3`, "
                . "`per_professional1`, `per_professional2`, `per_professional3`,"
                . "`per_school1`, `per_school2`, `per_school3`, "
                . "`per_foreign_language`, `per_computer_skill`, `per_other_skills`, "
                . "`per_position`, `per_date_applied`, `per_date_able_to_work`, "
                . "`per_salary_expected_from`,`per_salary_expected_to`, "
                . "`his_job_comp_name1`, `his_job_position1`, `his_job_startdate1`, "
                . "`his_job_enddate1`, `his_job_salary1`,`his_job_description1`, `his_job_reason_leave1`,"
                . "`his_job_comp_name2`, `his_job_position2`, `his_job_startdate2`, "
                . "`his_job_enddate2`, `his_job_salary2`,`his_job_description2`, `his_job_reason_leave2`,"
                . "`other_history_job`,"
                . "`per_ref_fullname`, `per_ref_company`, `per_ref_position`, `per_ref_relatives`) "
                . " VALUES ('" . $personal->getPer_code() . "'"
                . ",'" . $personal->getPer_fullname() . "'"
                . ",'" . $personal->getPer_email() . "'"
                . ",'" . $personal->getPer_home_phone() . "'"
                . ",'" . $personal->getPer_telephone() . "'"
                . ",'" . $personal->getPer_dob() . "'"
                . ",'" . $personal->getPer_pob() . "'"
                . ",'" . $personal->getPer_sex() . "'"
                . ",'" . $personal->getPer_marital_status() . "'"
                . ",'" . $personal->getPer_id_no() . "'"
                . ",'" . $personal->getPer_doi() . "'"
                . ",'" . $personal->getPer_poi() . "'"
                . ",'" . $personal->getPer_ethnic() . "'"
                . ",'" . $personal->getPer_religion() . "'"
                . ",'" . $personal->getPer_permanent_address() . "'"
                . ",'" . $personal->getPer_current_address() . "'"
                . ",'" . $personal->getPer_education1() . "'"
                . ",'" . $personal->getPer_education2() . "'"
                . ",'" . $personal->getPer_education3() . "'"
                . ",'" . $personal->getPer_professional1() . "'"
                . ",'" . $personal->getPer_professional2() . "'"
                . ",'" . $personal->getPer_professional3() . "'"
                . ",'" . $personal->getPer_school1() . "'"
                . ",'" . $personal->getPer_school2() . "'"
                . ",'" . $personal->getPer_school3() . "'"
                . ",'" . $personal->getPer_foreign_language() . "'"
                . ",'" . $personal->getPer_computer_skill() . "'"
                . ",'" . $personal->getPer_other_skills() . "'"
                . ",'" . $personal->getPer_position() . "'"
                . ",'" . $personal->getPer_date_applied() . "'"
                . ",'" . $personal->getPer_date_able_to_work() . "'"
                . ",'" . $personal->getPer_salary_expected_from() . "'"
                . ",'" . $personal->getPer_salary_expected_to() . "'"
                . ",'" . $personal->getHis_job_comp_name1() . "'"
                . ",'" . $personal->getHis_job_position1() . "'"
                . ",'" . $personal->getHis_job_startdate1() . "'"
                . ",'" . $personal->getHis_job_enddate1() . "'"
                . ",'" . $personal->getHis_job_salary1() . "'"
                . ",'" . $personal->getHis_job_description1() . "'"
                . ",'" . $personal->getHis_job_reason_leave1() . "'"
                . ",'" . $personal->getHis_job_comp_name2() . "'"
                . ",'" . $personal->getHis_job_position2() . "'"
                . ",'" . $personal->getHis_job_startdate2() . "'"
                . ",'" . $personal->getHis_job_enddate2() . "'"
                . ",'" . $personal->getHis_job_salary2() . "'"
                . ",'" . $personal->getHis_job_description2() . "'"
                . ",'" . $personal->getHis_job_reason_leave2() . "'"
                . ",'" . $personal->getOther_history_job() . "'"
                . ",'" . $personal->getPer_ref_fullname() . "'"
                . ",'" . $personal->getPer_ref_company() . "'"
                . ",'" . $personal->getPer_ref_position() . "'"
                . ",'" . $personal->getPer_ref_relatives() . "')";

//        return $sql;
        $con->executeQuery("SET CHARSET 'utf8'; ");
        $result = $con->executeQuery($sql);
        $con->CleanUpDB();

//        if($result == 1){
//            return $perCode."#success";
//        }
        return $result;
    }

    public function insertPersonalWorkingHistory($history_job) {

        $con = new DbConnection();
        if (!$con->GetDBConnection()) {
            return "Could not connect to mysql server";
        }
        $sql = "INSERT INTO hs_hr_personal_history_job(`per_id`, `his_job_comp_name`, "
                . "`his_job_position`, `his_job_startdate`, `his_job_enddate`, `his_job_salary`,"
                . "`his_job_description`, `his_job_reason_leave`) "
                . " VALUES ('" . $history_job->getPer_id() . "'"
                . ",'" . $history_job->getHis_job_comp_name() . "'"
                . ",'" . $history_job->getHis_job_position() . "'"
                . ",'" . $history_job->getHis_job_startdate() . "'"
                . ",'" . $history_job->getHis_job_enddate() . "'"
                . ",'" . $history_job->getHis_job_salary() . "'"
                . ",'" . $history_job->getHis_job_description() . "'"
                . ",'" . $history_job->getHis_job_reason_leave() . "'"
                . ",'" . $history_job->getPer_marital_status() . "')";

        $con->executeQuery("SET CHARSET 'utf8'; ");
        $result = $con->executeQuery($sql);
        $con->CleanUpDB();

        return $result;
    }

    public function insertPersonalReference($personal_reference) {
        $personal_reference = new PersonalReference();
        $con = new DbConnection();
        if (!$con->GetDBConnection()) {
            return "Could not connect to mysql server";
        }
        $sql = "INSERT INTO hs_hr_personal_reference(`per_id`, `per_ref_fullname`, "
                . "`per_ref_company`, `per_ref_position`, `per_ref_relatives`) "
                . " VALUES ('" . $personal_reference->getPer_id() . "'"
                . ",'" . $personal_reference->getPer_ref_fullname() . "'"
                . ",'" . $personal_reference->getPer_ref_company() . "'"
                . ",'" . $personal_reference->getPer_ref_position() . "')"
                . ",'" . $personal_reference->getPer_ref_relatives() . "'";

        $con->executeQuery("SET CHARSET 'utf8'; ");
        $result = $con->executeQuery($sql);
        $con->CleanUpDB();

        return $result;
    }

}
