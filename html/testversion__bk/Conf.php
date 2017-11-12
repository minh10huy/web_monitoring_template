<?php

/**
 * Description of conf
 *
 * @author ntvu_1
 */
class Conf {

    /**
     * Chuyển nhanh sang database chính
     * @var type 
     * boolean
     */
    var $is_main_db = false;
    
    /**
     * For your connect, input database information here
     * Digi-soft database config
     * FOR TESTING, MAIN DATABASE IN __construct FUNCTION
    */

    var $digi_soft_dbhost = 'localhost';
    var $digi_soft_dbport = '5432';//Postgresql 9.5
    //var $digi_soft_dbport = '5433';//Postgresql 9.2
    var $digi_soft_dbname = 'production';
    var $digi_soft_dbschema = 'db_16001_0001_bak_20160525';
    var $digi_soft_dbuser = 'postgre';
    var $digi_soft_dbpass = '123456';	
    var $digi_soft_version = 1.0;
        
    function __construct() {
        if ($this->is_main_db) {            
            $this->digi_soft_dbhost = 'localhost';
            $this->digi_soft_dbport = '5432';
            $this->digi_soft_dbname = 'production';
            $this->digi_soft_dbschema = 'db_16001_0001_bak_20160525';
            $this->digi_soft_dbuser = 'postgre';
            $this->digi_soft_dbpass = '123456';			
            $this->digi_soft_version = 1.0;
        }        
    }

}

?>