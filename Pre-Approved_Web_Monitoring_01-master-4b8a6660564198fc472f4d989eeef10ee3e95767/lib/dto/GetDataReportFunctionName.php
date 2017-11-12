<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetDataReportFunctionName
 *
 * @author ntvu_1
 */
class GetDataReportFunctionName {
    
    // new app - report
    var $sp_get_data_report_general;
    var $sp_get_data_report_details;
    var $sp_get_data_report_details_with_speed;

    // QDE NTB - report
    var $sp_get_data_report_qde_general_for_web_ntb;
    var $sp_get_data_report_qde_details_for_web_ntb;    
    
    // PreApprove
    var $sp_get_data_report_general_preapprove;
    var $sp_get_data_report_details_preapprove;
    
    // QDE PreApprove - report
    var $sp_get_data_report_qde_general_for_web_pl_pre;
    var $sp_get_data_report_qde_details_for_web_pl_pre;     
    
    // PreApproveCRC
    var $sp_get_data_report_general_preapprove_crc;
    var $sp_get_data_report_details_preapprove_crc;    
    
    // QDE PreApproveCRC - report
    var $sp_get_data_report_qde_general_for_web_crc_pre;
    var $sp_get_data_report_qde_details_for_web_crc_pre;    
    
    //QDE Mobile
    var $sp_get_data_report_general_mobile_qde;
    var $sp_get_data_report_details_mobile_qde;
    
    //New App Mobile
    var $sp_get_data_report_general_mobile_newapp;
    var $sp_get_data_report_details_mobile_newapp;
    
    function __construct() {
        // new app - report
//        $this->sp_get_data_report_general = "sp_get_data_report_hosomoi_general_for_web";
//        $this->sp_get_data_report_details = "sp_get_data_report_hosomoi_details_for_web";
//        $this->sp_get_data_report_details_with_speed = "sp_get_data_report_details_with_speed";
//
//        // QDE - report
//        $this->sp_get_data_report_general_form3 = "sp_get_data_report_qde_general_for_web";
//        $this->sp_get_data_report_details_form3 = "sp_get_data_report_qde_details_for_web";
//        $this->sp_get_data_report_details_with_speed_form3 = "sp_get_data_report_details_with_speed_form3";
//        
//        // PreApprove -report
//        $this->sp_get_data_report_general_preapprove = "sp_get_data_report_pre_approve_topup_general_for_web";
//        $this->sp_get_data_report_details_preapprove = "sp_get_data_report_pre_approve_topup_details_for_web";
        
        $this->sp_get_data_report_general = "sp_get_data_report_hosomoi_general_for_web";
        //$this->sp_get_data_report_details = "sp_get_data_report_hosomoi_details_for_web";
	$this->sp_get_data_report_details = "sp_get_data_report_hosomoi_details_for_web_new";

        // QDE NTB - report
        $this->sp_get_data_report_qde_general_for_web_ntb = "sp_get_data_report_qde_general_for_web_ntb_new";
        $this->sp_get_data_report_qde_details_for_web_ntb = "sp_get_data_report_qde_details_for_web_ntb";
        
        // PreApprove -report
        $this->sp_get_data_report_general_preapprove = "sp_get_data_report_pre_approve_topup_general_for_web";
//        $this->sp_get_data_report_details_preapprove = "sp_get_data_report_pre_approve_topup_details_for_web";
//        $this->sp_get_data_report_details_preapprove = "sp_get_data_report_data_details_for_web_muimui";
        $this->sp_get_data_report_details_preapprove = "sp_get_data_report_data_details_for_web_pre_approved_hyhd";
        
        // QDE PL Pre - report
        $this->sp_get_data_report_qde_general_for_web_pl_pre = "sp_get_data_report_qde_general_for_web_pl_pre";
        $this->sp_get_data_report_qde_details_for_web_pl_pre = "sp_get_data_report_qde_details_for_web_pl_pre";        
        
        // PreApproveCRC -report
        $this->sp_get_data_report_general_preapprove_crc = "sp_get_data_report_pre_approve_crc_general_for_web";
        $this->sp_get_data_report_details_preapprove_crc = "sp_get_data_report_pre_approve_crc_details_for_web";        
        
        // QDE CRC Pre - report
        $this->sp_get_data_report_qde_general_for_web_crc_pre = "sp_get_data_report_qde_general_for_web_crc_pre";
        $this->sp_get_data_report_qde_details_for_web_crc_pre = "sp_get_data_report_qde_details_for_web_crc_pre";        
                                                                
        // Mobile QDE
        $this->sp_get_data_report_general_mobile_qde = "sp_get_data_report_qde_general_mobile";
        $this->sp_get_data_report_details_mobile_qde = "sp_get_data_report_qde_details_mobile";
        
        // Mobile New App
        $this->sp_get_data_report_general_mobile_newapp = "sp_get_data_report_hosomoi_general_mobile";
        $this->sp_get_data_report_details_mobile_newapp = "sp_get_data_report_hosomoi_details_mobile";
    }
}
