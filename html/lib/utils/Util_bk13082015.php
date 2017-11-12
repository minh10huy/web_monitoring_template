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

    function analysisData($dataReportGeneral, $tableId) {
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
        if ($_SESSION['usercompany'] != null && $_SESSION['usercompany'] == 'vpbank') {
            $arrayHeader = array(
                'IDF1' => ' ',
                'Post Date' => ' ');
        } else {
            $arrayHeader = array(
                'IDF1' => ' ',
                'Post Actor' => ' ',
                'Post Date' => ' ');
        }

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
