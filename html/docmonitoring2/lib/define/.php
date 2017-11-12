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
    var $digi_soft_dbhost = '10.10.5.10';
    //var $digi_soft_dbhost = '10.10.1.3';
    var $digi_soft_dbport = '5432';
    var $digi_soft_dbname = 'fortester';
    //var $digi_soft_dbname = 'digisoft';
    var $digi_soft_dbschema = 'db_16_fecredit_0616';
    var $digi_soft_dbuser = 'digisoft_000_vpbank_0813';
    var $digi_soft_dbpass = 'db@000_vpbank_0813';	
    var $digi_soft_version = 1.0;
        
    function __construct() {
        
        // This is digi-soft database config
        // FOR MAIN DATABASE
        if ($this->is_main_db) {
            
            $this->digi_soft_dbhost = '10.10.5.10';
            //$this->digi_soft_dbhost = '10.10.1.3';
            $this->digi_soft_dbport = '5432';
            $this->digi_soft_dbname = 'fortester';
            //$this->digi_soft_dbname = 'digisoft';
            $this->digi_soft_dbschema = 'db_16_fecredit_0616';
            $this->digi_soft_dbuser = 'digisoft_000_vpbank_0813';
            $this->digi_soft_dbpass = 'db@000_vpbank_0813';			
            $this->digi_soft_version = 1.0;
        }
    }

}

?>
