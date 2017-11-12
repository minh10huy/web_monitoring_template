<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'lib/dto/ViewInterface.php';

/**
 * Description of utils
 *
 * @author ntvu_1
 */
class Util {

    function analysisData($dataReportGeneral, $tableId, $type) {
        if ($dataReportGeneral == null || count($dataReportGeneral) == 0) {
            return "";
        }
        $resultDataReportGeneral = "";
//        if($tableId == 1){
//        $resultDataReportGeneral .= '<div><label>Search Province: </label>'.
//                                                '<input type="text" id="province_search1" placeholder="Search Province">'.
//                                                '<label style="margin-left:20px;">Search Channel: </label>'.
//                                                '<input type="text" id="channel_search1" placeholder="Search Channel"></div>';
//        }else{
//            $resultDataReportGeneral .= '<div><label>Search Province: </label>'.
//                                                '<input type="text" id="province_search2" placeholder="Search Province">'.
//                                                '<label style="margin-left:20px;">Search Channel: </label>'.
//                                                '<input type="text" id="channel_search2" placeholder="Search Channel"></div>';
//        }
        $resultDataReportGeneral .=
                '<table id="tableData' . $tableId . '" class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>';
        
//        for ($i = 0; $i < count($dataReportGeneral); $i++) {
            foreach ($dataReportGeneral[0] as $key => $value) {
                if ($tableId === 2 && $type==="3" && $key === "management_id")
                    $resultDataReportGeneral .= "<th class='hide_me'>" . $key . "</th>";
                else
                    $resultDataReportGeneral .= "<th>" . $key . "</th>";
            }
//        }
        if ($tableId === 2 && $type===3) {
            $resultDataReportGeneral .= '<th class="tabledit-toolbar-column">Edit</th>';
        }
//        $resultDataReportGeneral .= '<th class="tabledit-toolbar-column">Edit</th>';

        $resultDataReportGeneral .=
                '</tr>
                </thead>
                <tbody>';
        
                                 $toolbar = '<div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                                           <div class="btn-group btn-group-sm" style="float: none;">' . '<button type="button" class="tabledit-edit-button ' . 'btn btn-sm btn-default' . '" style="float: none;">' . '<span class="glyphicon glyphicon-pencil"></span>' . '</button></div>
                                           ' . '<button type="button" class="tabledit-save-button ' . 'btn btn-sm btn-success'. '" style="display: none; float: none;">' . 'save' . '</button>' . '
                                           
                                       </div></div>';

                        // Add toolbar column cells.
//                        $table.find('tr:gt(0)').append('<td style="white-space: nowrap; width: 1%;">' + toolbar + '</td>');
        for ($i = 0; $i < count($dataReportGeneral); $i++) {
            if ($tableId === 2 && $type===3 )
                $resultDataReportGeneral .= "<tr id='". $dataReportGeneral[$i]['management_id'].  "'>";
            else    
                $resultDataReportGeneral .= "<tr>";
            foreach ($dataReportGeneral[$i] as $key => $value) {
                if ($tableId === 2 && $type===3) {
                    if ($key === "DSA Code" ||$key === "DSA Name" || $key === "TSA Code F1" || $key === "Spouse Name" || $key === "TSA Name" || $key === "TSA Phone Number" || $key === "Product Name 1" || $key === "Loan Amount Request" || $key === "Loan Term Request" || $key === "Insurance" || $key === "Insurance Plus" || $key === "Insurance Name" || $key === "Date of Closure" || $key === "Disb Channel" || $key === "Branch Code" || $key === "Referee 1" || $key === "Referee 2" || $key === "Spouse Name" || $key === "CC Code" || $key === "CC Name" || $key === "Opportunity Name" || $key === "No. Agreement ID" || $key === "New ID Card Number" || $key === "Date of Issue" || $key === "Place of Issue" || $key === "New Phone" || $key === "Address" || $key === "Actual Address" || $key === "Monthly Income" || $key === "Monthly Costs" || $key === "Monthly Income Family"|| $key === "Monthly Costs Family"|| $key === "Number of Modified Fields" || $key === "Modified Fields")
                        $resultDataReportGeneral .= '<td class="tabledit-view-mode"><span class="tabledit-span">' . $value .'</span><input type="text" disabled="" style="display: none;width:100%" value="' . $value . '" name="'. $key .'" class="tabledit-input form-control input-sm"></td>';
                    else if ($key === "management_id")
                        $resultDataReportGeneral .= '<td>'.'<span class="tabledit-span tabledit-identifier">' . $value . '</span>' .'<input class="tabledit-input tabledit-identifier" type="hidden" name="' . 'management_id' . '" value="' . $value . '" disabled>'.'</td>';
                    else 
                        $resultDataReportGeneral .= "<td>" . $value . "</td>";
                    
                  


                } else {
                    $resultDataReportGeneral .= "<td>" . $value . "</td>";
                }
            }
            if ($tableId === 2 && $type===3) {
                if (($dataReportGeneral[$i]['ID F1'] === "" || !isset($dataReportGeneral[$i]['ID F1']) || strlen($dataReportGeneral[$i]['ID F1']) === 0) && $dataReportGeneral[$i]['Status SaigonBPO'] === "Pending")
                    $resultDataReportGeneral .= '<td style="white-space: nowrap; width: 1%;">' . $toolbar . '</td>';
                else 
                    $resultDataReportGeneral .= '<td style="white-space: nowrap; width: 1%;">' . '</td>';
            }
            $resultDataReportGeneral .= "</tr>";
        }
        
        $resultDataReportGeneral .=
                '</tbody>
                <tfoot>
                    <tr>';

        foreach ($dataReportGeneral[0] as $key => $value) {
//            $resultDataReportGeneral .= "<th>" . $key . "</th>";
            $resultDataReportGeneral .= "<th></th>";
        }

        $resultDataReportGeneral .=
                '</tr>
                </tfoot>
            </table>';

        $resultDataReportGeneral .= "</div><!-- /.box-body -->";
        return $resultDataReportGeneral;
    }

    function analysisData1($dataReportGeneral, $tableId) {
        if ($dataReportGeneral == null || count($dataReportGeneral) == 0) {
            return "";
        }
        $resultDataReportGeneral .=
                '<table id="tableData' . $tableId . '" class="table table-bordered table-striped">
                <thead>
                    <tr>';

        foreach ($dataReportGeneral[0] as $key => $value) {
            $resultDataReportGeneral .= "<th>" . $key . "</th>";
        }

        $resultDataReportGeneral .=
                '</tr>
                </thead>
                <tbody>';

        for ($i = 0; $i < count($dataReportGeneral); $i++) {
            $resultDataReportGeneral .= "<tr>";
            foreach ($dataReportGeneral[$i] as $key => $value) {
                $resultDataReportGeneral .= "<td>" . $value . "</td>";
            }
            $resultDataReportGeneral .= "</tr>";
        }

        $resultDataReportGeneral .=
                '</tbody>
                <tfoot>
                    <tr>';

        foreach ($dataReportGeneral[0] as $key => $value) {
            $resultDataReportGeneral .= "<th>" . $key . "</th>";
        }

        $resultDataReportGeneral .=
                '</tr>
                </tfoot>
            </table>';

        $resultDataReportGeneral .= "</div><!-- /.box-body -->";
        return $resultDataReportGeneral;
    }

    function analysisDataQDE($dataReportGeneral) {
        if ($dataReportGeneral == null || count($dataReportGeneral) == 0) {
            return "";
        }
        $resultDataReportGeneral = "";
        $arrayHeader = array();
        if ($_SESSION['usercompany'] != null && $_SESSION['usercompany'] == 'vpbank') {
            $arrayHeader = array(
                'File Upload' => ' ',
                'Upload Date' => ' ',
                'Upload Time' => ' ',
                'Reason' => ' ');
        } else {
            $arrayHeader = array(
                'CC Code' => ' ',
                'File Upload' => ' ',
                'Upload Date' => ' ',
                'Upload Time' => ' ',
                'Reason' => ' ');
        }

        $resultDataReportGeneral .=
                '<table id="tableQDE" class="table table-bordered table-striped">
                <thead>
                    <tr>';
        while (current($arrayHeader)) {
            $resultDataReportGeneral .= "<th>" . key($arrayHeader) . "</th>";
            next($arrayHeader);
        }
        $resultDataReportGeneral .=
        '</tr>
                </thead>
                <tbody>';

        foreach ($dataReportGeneral as $key => $value) {
            $resultDataReportGeneral .= "<tr>";
            for ($i = 0; $i < count($arrayHeader); $i++) {
                $resultDataReportGeneral .= "<td>" . $value[$i] . "</td>";
            }
            $resultDataReportGeneral .= "</tr>";
        }

        $resultDataReportGeneral .=
                '</tbody>
                <tfoot>
                    <tr>';

        while (current($arrayHeader)) {
            //$resultDataReportGeneral .= "<th>" . key($arrayHeader) . "</th>";
            $resultDataReportGeneral .= "<th>" . $key . "</th>";
            next($arrayHeader);
        }

        $resultDataReportGeneral .=
                '</tr>
                </tfoot>
            </table>';

        $resultDataReportGeneral .= "</div><!-- /.box-body -->";
        return $resultDataReportGeneral;
    }

    function analysisDataTicket($dataReportGeneral) {
        if ($dataReportGeneral == null || count($dataReportGeneral) == 0) {
            return "";
        }
        $resultDataReportGeneral = "";
        $arrayHeader = array();
//        if ($_SESSION['usercompany'] != null && $_SESSION['usercompany'] == 'vpbank') {
//            $arrayHeader = array(
//                'IDF1' => ' ',
//                'Post Date' => ' ');
//        } else {
//            $arrayHeader = array(
//                'IDF1' => ' ',
//                'Post Actor' => ' ',
//                'Post Date' => ' ');
//        }
            $arrayHeader = array(
                'IDF1' => ' ',
                'Post Actor' => ' ',
                'Post Date' => ' ');  

        $resultDataReportGeneral .=
                '<table id="tableTicket" class="table table-bordered table-striped">
                <thead>
                    <tr>';
        while (current($arrayHeader)) {
            $resultDataReportGeneral .= "<th>" . key($arrayHeader) . "</th>";
            next($arrayHeader);
        }
        $resultDataReportGeneral .=
        '</tr>
                </thead>
                <tbody>';

        foreach ($dataReportGeneral as $key => $value) {
            $resultDataReportGeneral .= "<tr>";
            for ($i = 0; $i < count($arrayHeader); $i++) {
                $resultDataReportGeneral .= "<td>" . $value[$i] . "</td>";
            }
            $resultDataReportGeneral .= "</tr>";
        }

        $resultDataReportGeneral .=
                '</tbody>
                <tfoot>
                    <tr>';

        while (current($arrayHeader)) {
            //$resultDataReportGeneral .= "<th>" . key($arrayHeader) . "</th>";
            $resultDataReportGeneral .= "<th>" . $key . "</th>";
            next($arrayHeader);
        }

        $resultDataReportGeneral .=
                '</tr>
                </tfoot>
            </table>';

        $resultDataReportGeneral .= "</div><!-- /.box-body -->";
        return $resultDataReportGeneral;
    }
    	
}

?>
