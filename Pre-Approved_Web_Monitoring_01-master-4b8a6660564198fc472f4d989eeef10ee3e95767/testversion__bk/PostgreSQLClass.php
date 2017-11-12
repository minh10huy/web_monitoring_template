<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostgreSQLClass
 *
 * @author ntvu_1
 */
class PostgreSQLClass {

    var $conf;

    function __construct() {
        if (!isset($g_link)) {
            $g_link = false;
        }
        $this->conf = new Conf();
    }

    function getConDPO_DIGISOFT() {
        $connection = new PDO("pgsql:host=" . $this->conf->digi_soft_dbhost . ";"
                . "port=" . $this->conf->digi_soft_dbport . ";"
                . "dbname=" . $this->conf->digi_soft_dbname, $this->conf->digi_soft_dbuser, $this->conf->digi_soft_dbpass);

        $connection->exec("SET search_path TO ".$this->conf->digi_soft_dbschema." ;");
        // let me know if the connection fails
        if (!$connection) {
            print("Connection Failed.");
            exit;
        }
        return $connection;
    }

}

?>
