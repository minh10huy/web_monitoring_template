<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author ntvu_1
 */
class Utils {

    //put your code here
    public function getListProjects($status) {
        try {
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConnPMS();
            if (!$con) {
                return false;
            }
            $sql = "select * from tbl_projects where proj_prjstatus_id = " . $status;

//            $result = $pgSQL->executeQuery($sql);
            $result = pg_query($sql);

            while ($row = mysql_fetch_assoc($result)) {
                
            }
            pg_close($con);
        } catch (Exception $e) {
            return false;
        }
    }

}
