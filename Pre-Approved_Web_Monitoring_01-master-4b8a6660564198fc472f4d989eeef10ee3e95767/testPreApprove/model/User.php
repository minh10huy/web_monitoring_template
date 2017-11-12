<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'lib/define/Conf.php';
require_once 'lib/define/constants.php';
require_once 'lib/db/PostgreSQLClass.php';

/**
 * Description of User
 *
 * @author ntvu_1
 */
class User {

    var $conf;

    function __construct() {
        $this->conf = new Conf();
    }

    /**
     * Kiểm tra user login vào hệ thống
     * @param type $username
     * username
     * @param type $password
     * password (md5)
     * @return boolean
     */
    function checkLogin($username, $password) {
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            // Clear any attempts if login_time is longer than 10 minutes ealier
            $sql = "UPDATE " . $this->conf->digi_soft_dbschema . "." . TBL_ATTEMPTS . " SET attempts = 0 WHERE attempts < 3 AND lastlogin + INTERVAL '10 MINUTES' < NOW()";

            $stmt = $con->prepare($sql);
            $stmt->execute();

            // Query get user from username and password
            $sql = "SELECT * FROM " . $this->conf->digi_soft_dbschema . ".lookup_channel "
                   // . "WHERE cc_code = '" . $username . "' "
                   // . "AND cc_password = '" . md5($password) . "' "
                    . "WHERE cc_code = :username "
                    . "AND cc_password = :pass "
                    . "LIMIT 1";

            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username, 'pass' => md5($password)));

            // Return count number of user valid
            $numRows = $stmt->rowCount();

            // Update active time and login 
            //$select_login = "SELECT count(*) FROM ".$this->conf->digi_soft_dbschema.".login_attempts WHERE username = '$username'";
            $select_login = "SELECT count(*) FROM ".$this->conf->digi_soft_dbschema.".login_attempts WHERE username = :username";
            $stmt = $con->prepare($select_login);
            $stmt->execute(array('username' => $username));
            $data = $stmt->fetch();
            if ($data[0] > 0)
                //$sql = "UPDATE ".$this->conf->digi_soft_dbschema.".login_attempts SET lastlogin = NOW() WHERE username = '$username'";
                $sql = "UPDATE ".$this->conf->digi_soft_dbschema.".login_attempts SET lastlogin = NOW() WHERE username = :username";
            else
                //$sql = "INSERT INTO ".$this->conf->digi_soft_dbschema.".login_attempts(lastlogin, username) VALUES(NOW(), '$username')";
                $sql = "INSERT INTO ".$this->conf->digi_soft_dbschema.".login_attempts(lastlogin, username) VALUES(NOW(), :username)";
            $prepare = $con->prepare($sql);
            $prepare->execute(array('username' => $username));
            if ($numRows > 0) {
                // Update acitve time as well as status if login successfully
                //$sql = "UPDATE ".$this->conf->digi_soft_dbschema.".login_attempts SET is_loggedin = 1 WHERE username = '$username'";
                $sql = "UPDATE ".$this->conf->digi_soft_dbschema.".login_attempts SET is_loggedin = 1 WHERE username = :username";
                $stmt = $con->prepare($sql);
                $stmt->execute(array('username' => $username));
                
            }

            $con->commit();
            unset($stmt);
            pg_close($con);

            return $numRows > 0 ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }
    
    function checkInsecurePass($username) {
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            // Query get user from username and password
            $sql = "SELECT cc_password FROM " . $this->conf->digi_soft_dbschema . ".lookup_channel "
            //        . "WHERE cc_code = '" . $username . "' "
                    . "WHERE cc_code = :username "
                    . "LIMIT 1";

            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username));
            $result = $stmt->fetch();

            $con->commit();
            unset($stmt);
            pg_close($con);

            return $result['cc_password'] == md5('123456') ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }    
    
    function getRole($username){
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            // Query get user from username and password
            $sql = "SELECT id, cc_role, channel, email, company FROM " . $this->conf->digi_soft_dbschema . ".lookup_channel "
                    //. "WHERE cc_code = '" . $username . "' "
                    . "WHERE cc_code = :username "
                    . "LIMIT 1";

            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username));
            $role = $stmt->fetch();
            // Return count number of user valid
            //$numRows = $stmt->rowCount();

            $con->commit();
            unset($stmt);
            pg_close($con);

            return $role;
        } catch (Exception $e) {
            return false;
        }        
    }
    
   function checkIsBlocked($username) {


        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            $sql = "SELECT attempts, is_blocked as denied " .
                   // " FROM " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " WHERE  username = '$username'";
                    " FROM " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " WHERE  username = :username";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username));
            $data = $stmt->fetch();
            if (!$data) {
                return 0;
            }
            if ($data["attempts"] >= ATTEMPTS_NUMBER) {
                if ($data["denied"] == 1) {
                    return 1;
                } else {
                    $this->clearLoginAttempts($username);
                    return 0;
                }
            }

            $con->commit();
            unset($stmt);
            pg_close($con);

            return 0;
        } catch (Exception $e) {
            return false;
        }
    }
    
       function checkValidUser($username) {


        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            $sql = "SELECT count(*) " .
                    // " FROM " . $this->conf->digi_soft_dbschema . ".lookup_channel WHERE cc_code = '$username'";
                    " FROM " . $this->conf->digi_soft_dbschema . ".lookup_channel WHERE cc_code = :username";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username));
            $data = $stmt->fetch();
            $result = false;
            if ($data[0] > 0) {
                $result = true;;
            }
            
            $con->commit();
            unset($stmt);
            pg_close($con);

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

   function checkDuplicateLogin($username) {


        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            $sql = "SELECT count(*) " .
                    //" FROM " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " WHERE lastlogin + INTERVAL '10 MINUTES' > NOW() AND username = '$username' AND is_loggedin = 1";
                    " FROM " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " WHERE lastlogin + INTERVAL '10 MINUTES' > NOW() AND username = :username AND is_loggedin = 1";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username));
            $data = $stmt->fetch();
            if ($data[0] > 0) {
                $result = true;
            } else {
                $result = false;
            }
            

            $con->commit();
            unset($stmt);
            pg_close($con);
            if (!$result) {
               $this->updateLoginStatus($username);
            }
            return $result;
        } catch (Exception $e) {
            return false;
        }
    } 
	
    function isVPBankUser($username) {
                try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            $sql = "SELECT count(*) " .
                   // " FROM " . $this->conf->digi_soft_dbschema . ".lookup_channel WHERE cc_code = '$username' AND lower(company) = 'vpbank'";
                    " FROM " . $this->conf->digi_soft_dbschema . ".lookup_channel WHERE cc_code = :username AND lower(company) = 'vpbank'";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username));
            $data = $stmt->fetch();
            $result = false;
            if ($data[0] > 0) {
                $result = true;
            }

            $con->commit();
            unset($stmt);
            $con = null;

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }	

   function updateLoginStatus($username) {
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }
            // begin transaction, this is all one process
            $con->beginTransaction();
            //$update = "UPDATE ". $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " SET is_loggedin = 0 WHERE username = '$username'";
            $update = "UPDATE ". $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " SET is_loggedin = 0 WHERE username = :username ";
            $stmt = $con->prepare($update);
            $stmt->execute(array('username' => $username));           
            $con->commit();
            unset($stmt);
            pg_close($con);
        } catch (Exception $e) {
            return false;
        }
    }    
   
   function addLoginAttempt($username) {
        // increase number of attempts
        // set last login attempt time if required  
        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            //$sql = "SELECT * FROM " . $this->conf->digi_soft_dbschema . "." . TBL_ATTEMPTS . " WHERE  username = '$username'";
            $sql = "SELECT * FROM " . $this->conf->digi_soft_dbschema . "." . TBL_ATTEMPTS . " WHERE  username = :username ";

            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username));
            $data = $stmt->fetch();
            if ($data) {
                $attempts = $data["attempts"] + 1;
                if ($attempts >= 5) {
                    //$sql = "UPDATE " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " SET attempts=" . $attempts . ", is_blocked = 1 WHERE  username = '$username'";
                    $sql = "UPDATE " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " SET attempts=" . $attempts . ", is_blocked = 1 WHERE  username = :username";
                    $stmt = $con->prepare($sql);
                    $stmt->execute(array('username' => $username));
                } else {
                    //$sql = "UPDATE " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " SET attempts=" . $attempts . " WHERE  username = '$username'";
                    $sql = "UPDATE " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " SET attempts=" . $attempts . " WHERE  username = :username";
                    $stmt = $con->prepare($sql);
                    $stmt->execute(array('username' => $username));
                }
            } else {
                //$sql = "INSERT INTO " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " (attempts, username) values (1, '$username')";
                $sql = "INSERT INTO " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " (attempts, username) values (1, :username)";
                $stmt = $con->prepare($sql);
                $stmt->execute(array('username' => $username));           
             }

            $con->commit();
            unset($stmt);
            pg_close($con);

            return $attempts;
        } catch (Exception $e) {
            return false;
        }
    }
   
   function clearLoginAttempts($username) {

        try {
            // Connect to Database
            $pgSQL = new PostgreSQLClass();
            $con = $pgSQL->getConDPO_DIGISOFT();

            if (!$con) {
                return false;
            }

            // begin transaction, this is all one process
            $con->beginTransaction();

            //$sql = "UPDATE " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " SET attempts = 0, is_blocked = 0 WHERE  username = '$username'";
            $sql = "UPDATE " . $this->conf->digi_soft_dbschema . "." .TBL_ATTEMPTS . " SET attempts = 0, is_blocked = 0 WHERE  username = :username ";

            $stmt = $con->prepare($sql);
            $stmt->execute(array('username' => $username));

            $con->commit();
            unset($stmt);
            pg_close($con);

            return 0;
        } catch (Exception $e) {
            return false;
        }
    }

}
