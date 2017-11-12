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

    var $digi_soft_dbhost = '10.1.1.101';
    var $digi_soft_dbport = '5432';//Postgresql 9.5
    //var $digi_soft_dbport = '5433';//Postgresql 9.2
    var $digi_soft_dbname = 'production_test';
    //var $digi_soft_dbschema = 'db_16008_c001_bak_cd2w_20170112';
   // var $digi_soft_dbname = 'restore18012017';
    var $digi_soft_dbschema = 'db_16001_0001_bak_20160525';	
    var $digi_soft_dbuser = 'postgres';
    var $digi_soft_dbpass = 'S@GBtest2016';	
    var $digi_soft_version = 1.0;
        
    function __construct() {
        if ($this->is_main_db) {            
            $this->digi_soft_dbhost = '10.1.1.101';
            $this->digi_soft_dbport = '5432';
            $this->digi_soft_dbname = 'production_test';
            //$this->digi_soft_dbschema = 'db_16008_c001_bak_cd2w_20170112';
            //$this->digi_soft_dbname = 'restore18012017';
            $this->digi_soft_dbschema = 'db_16001_0001_bak_20160525';			
            $this->digi_soft_dbuser = 'postgres';
            $this->digi_soft_dbpass = 'S@GBtest2016';			
            $this->digi_soft_version = 1.0;
        }        
    }

}

?>