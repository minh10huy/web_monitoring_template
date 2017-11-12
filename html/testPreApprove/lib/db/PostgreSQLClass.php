<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//require_once 'lib/define/Conf.php';
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
      $connection = new PDO("pgsql:host=".$this->conf->digi_soft_dbhost.";"
                . "port=".$this->conf->digi_soft_dbport.";"
               . "dbname=".$this->conf->digi_soft_dbname, 
             $this->conf->digi_soft_dbuser, 
           $this->conf->digi_soft_dbpass);
		//$dsn = "pgsql:host='10.1.1.3';port=5432;dbname=production;user='rls_dev';password='SaigonD3v'";		
		//$connection = new PDO($dsn);				
        $connection->exec("SET search_path TO ".$this->conf->digi_soft_dbschema." ;");
        // let me know if the connection fails
        if (!$connection) {
            print("Connection Failed.");
            exit;
        }
        return $connection;
    }
    
    public static function getConn() {
        
        
        $conf = new Conf();
        $strConn = "host=".$conf->digi_soft_dbhost." port=".$conf->digi_soft_dbport." dbname=".$conf->digi_soft_dbname." user=".$conf->digi_soft_dbuser." password=".$conf->digi_soft_dbpass;
        
        // make our connection
        $connection = pg_connect($strConn);
        
        pg_query("set search_path to" .$conf->digi_soft_dbschema .";" );
        
        // let me know if the connection fails
        if (!$connection) {
            print("Connection Failed.");
            exit;
        }
        return $connection;
    }
}

?>
