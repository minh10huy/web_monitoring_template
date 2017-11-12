user_role = '@Session["monitoring_userrole"]';
var waitingDialog = waitingDialog || (function ($) {
    'use strict';
    var $dialog = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-m">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
            '<div class="modal-body">' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '</div>' +
            '</div></div></div>');
    return {
        show: function (message, options) {
            // Assigning defaults
            if (typeof options === 'undefined') {
                options = {};
            }
            if (typeof message === 'undefined') {
                message = 'Loading';
            }
            var settings = $.extend({
                dialogSize: 'm',
                progressType: '',
                onHide: null // This callback runs after the dialog was hidden
            }, options);

            // Configuring dialog
            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
            $dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) {
                $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
            }
            $dialog.find('h3').text(message);
            // Adding callbacks
            if (typeof settings.onHide === 'function') {
                $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                    settings.onHide.call($dialog);
                });
            }
            // Opening dialog
            $dialog.modal();
        },
        hide: function () {
            $dialog.modal('hide');
        }
    };
})(jQuery);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.dataTable.pipeline = function (opts) {
    // Configuration options
    var conf = $.extend({
        pages: 5, // number of pages to cache
        url: '', // script url
        data: null, // function or object with parameters to send to the server
        // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
    }, opts);

    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;

    return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;
        var requestEnd = requestStart + requestLength;

        if (settings.clearCache) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
            // outside cached data - need to make a request
            ajax = true;
        } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
                ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }

        // Store the request for checking next time around
        cacheLastRequest = $.extend(true, {}, request);

        if (ajax) {
            // Need data from the server
            if (requestStart < cacheLower) {
                requestStart = requestStart - (requestLength * (conf.pages - 1));

                if (requestStart < 0) {
                    requestStart = 0;
                }
            }

            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);

            request.start = requestStart;
            request.length = requestLength * conf.pages;

            // Provide the same `data` options as DataTables.
            if ($.isFunction(conf.data)) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data(request);
                if (d) {
                    $.extend(request, d);
                }
            } else if ($.isPlainObject(conf.data)) {
                // As an object, the data given extends the default
                $.extend(request, conf.data);
            }

            settings.jqXHR = $.ajax({
                "type": conf.method,
                "url": conf.url,
                "data": request,
                "dataType": "json",
                "cache": false,
                "success": function (json) {
                    cacheLastJson = $.extend(true, {}, json);

                    if (cacheLower != drawStart) {
                        json.data.splice(0, drawStart - cacheLower);
                    }
                    json.data.splice(requestLength, json.data.length);

                    drawCallback(json);
                }
            });
        } else {
            json = $.extend(true, {}, cacheLastJson);
            json.draw = request.draw; // Update the echo for each response
            json.data.splice(0, requestStart - cacheLower);
            json.data.splice(requestLength, json.data.length);

            drawCallback(json);
        }
    }
};


// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
$.fn.dataTable.Api.register('clearPipeline()', function () {
    return this.iterator('table', function (settings) {
        settings.clearCache = true;
    });
});

$(function () {
    $('#txtFromDate').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    $('#txtToDate').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
});
$('#filter-btn').click(function () {
//    $("[data-widget='collapse']").click();
    var type_input = $("#slType").val();


    var activeTab = $('ul#tab-display').find('li.active').children();
    if (activeTab.attr('id') === "details") {
        initializeDetailsTable(type_input);
    } else {
        initializeGeneralTable(type_input);
    }
});
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var type_input = $("#slType").val();
    var target = $(e.target).attr("id"); // activated tab
    if (target === "general") {
        //console.log("toggle event");
        if (typeof table1 === "undefined") {
            initializeGeneralTable(type_input);
        } else {
            table1.columns.adjust();
        }
    }
});
$('#btnExport').click(function () {
    waitingDialog.show('Đang xuất dữ liệu...');
    $.ajax({
        type: "POST",
        url: "exportexcel/prepareinfo.php",
        data: {FromDate: $('#txtFromDate').val(), ToDate: $('#txtToDate').val(), type_input: $("#slType").val()},
        async: false,
        success: function (result)
        {
            waitingDialog.hide();
            window.open("exportexcel/export_performance.php", "_blank");
        },
        error: function (xhr, status, error) {
            waitingDialog.hide();
            window.location.reload(true);
        }
    });
});

var isclick = false;
$(document).ready(function () {

    var inactive = false; //ko cho load lần đầu
    $(window).blur(function () {
        inactive = true;
//          document.title = 'Inactive';
    });
    $(window).focus(function () {
//          document.title = 'Active';
//        if (inactive && isclick) {
//            $('#filter-btn').click();
//            isclick =false;
//            inactive = false;
//        }
    });
});

function initializeGeneralTable(type_input) {
    switch (type_input) {
        case "1":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>            <th>#</th>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>From</th>            <th>To</th>            <th>Finished</th>            <th>Canceled</th>            <th>Duplication</th>            <th>Pending</th>      </tr>   </thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "2":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%"><thead><tr>            <th>#</th>            <th>Date</th>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>Hard</th>            <th>Soft</th>            <th>Cancelled</th>            <th>Pending</th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "3":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%"><thead><tr>        <th>Day</th>        <th>Done - Xử lý</th>        <th>Done - Pending</th>        <th>Duplicate</th>        <th>Entered</th>        <th>Xử lý</th>        <th>Pending</th>        <th>Pending - Updated</th>        <th>QDE - Cancel</th>        <th>QDE - Done</th>        <th>QDE - Others</th>        <th>QDE - Updated</th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "4":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>            <th>Date</th>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>Hard</th>            <th>Soft</th>            <th>Cancelled</th>            <th>Pending</th>            </tr>   </thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "5":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>From</th>            <th>To</th>            <th>Finished</th>            <th>Canceled</th>            <th>Duplication</th>            <th>Pending</th>      </tr>   </thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "6":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%"><thead><tr>        <th>Day</th>        <th>Done - Xử lý</th>        <th>Done - Pending</th>        <th>Duplicate</th>        <th>Entered</th>        <th>Xử lý</th>        <th>Pending</th>        <th>Pending - Updated</th>        <th>QDE - Cancel</th>        <th>QDE - Done</th>        <th>QDE - Others</th>        <th>QDE - Updated</th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "7":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%"><thead><tr>            <th>#</th>            <th>Date</th>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>Hard</th>            <th>Soft</th>            <th>Cancelled</th>            <th>Pending</th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "8":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%"><thead><tr>            <th>#</th>            <th>Date</th>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>Hard</th>            <th>Soft</th>            <th>Cancelled</th>            <th>Pending</th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
    }

    if (typeof table1 !== "undefined") {
        table1.destroy();
    }
    //console.log("initialise table 1");
    if (type_input == "4" || type_input == "5") {
        table1 = $('#tableData1').DataTable({
            "ajax": {
                "url": "server_processing_general.php",
                "pagingType": "full_numbers",
                "data": function (d) {
                    d.FromDate = $('#txtFromDate').val();
                    d.ToDate = $('#txtToDate').val();
                    d.type = $("#slType").val();
                    d.mobile = true;
                }
            },
            "deferRender": true,
            "oLanguage": {
                sProcessing: "<img src='img/ajax-loader1.gif'>"
            },
            "bProcessing": true,
//                "scrollY": 555,
            "scrollY": 555,
            "scrollX": true,
            "bAutoWidth": false,
            "iDisplayLength": 30,
            "footerCallback": function (row, data, start, end, display) {
                //console.log("footer callback");
                //console.log("end index :" + data.length);
                if (data.length === 0)
                    return;
                var api = this.api(),
                        data;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };
                var beginTemp, lenTemp;
                var type = $("#slType").val();
                switch (type) {
                    case "1":
                        beginTemp = 7;
                        lenTemp = 11;
                        break;
                    case "2":
                        beginTemp = 6;
                        lenTemp = 10;
                        break;
                    case "3":
                        beginTemp = 1;
                        lenTemp = 12;
                        break;
                    case "4":
                        beginTemp = 5;
                        lenTemp = 9;
                        break;
                    case "5":
                        beginTemp = 6;
                        lenTemp = 10;
                        break;
                    case "6":
                        beginTemp = 1;
                        lenTemp = 12;
                        break;
                    case "7":
                        beginTemp = 6;
                        lenTemp = 10;
                        break;
                    case "8":
                        beginTemp = 6;
                        lenTemp = 10;
                        break;
                }


                ////console.log("begin")
                for (var temp = beginTemp; temp < lenTemp; temp++) {
                    // Total over all pages
                    total = api
                            .column(temp)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            });
                    // Total over this page
                    pageTotal = api
                            .column(temp, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                    // Update footer
                    $(api.column(temp).footer()).html(
                            pageTotal + ' (' + total + ' total)'
                            );
                }
            }
        });
    } else {
        table1 = $('#tableData1').DataTable({
            "ajax": {
                "url": "server_processing_general.php",
                "pagingType": "full_numbers",
                "data": function (d) {
                    d.FromDate = $('#txtFromDate').val();
                    d.ToDate = $('#txtToDate').val();
                    d.type = $("#slType").val();

                }
            },
            "deferRender": true,
            "oLanguage": {
                sProcessing: "<img src='img/ajax-loader1.gif'>"
            },
            "scrollY": 555,
            "scrollX": true,
            "bAutoWidth": false,
            "bProcessing": true,
            "iDisplayLength": 30,
            "footerCallback": function (row, data, start, end, display) {
                //console.log("footer callback");
                //console.log("end index :" + data.length);
                if (data.length === 0)
                    return;
                var api = this.api(),
                        data;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };
                var beginTemp, lenTemp;
                var type = $("#slType").val();
                switch (type) {
                    case "1":
                        beginTemp = 7;
                        lenTemp = 11;
                        break;
                    case "2":
                        beginTemp = 6;
                        lenTemp = 10;
                        break;
                    case "3":
                        beginTemp = 1;
                        lenTemp = 12;
                        break;
                    case "4":
                        beginTemp = 5;
                        lenTemp = 9;
                        break;
                    case "5":
                        beginTemp = 6;
                        lenTemp = 10;
                        break;
                    case "6":
                        beginTemp = 1;
                        lenTemp = 12;
                        break;
                    case "7":
                        beginTemp = 6;
                        lenTemp = 10;
                        break;
                    case "8":
                        beginTemp = 6;
                        lenTemp = 10;
                        break;
                }

                ////console.log("begin")
                for (var temp = beginTemp; temp < lenTemp; temp++) {
                    // Total over all pages
                    total = api
                            .column(temp)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            });
                    // Total over this page
                    pageTotal = api
                            .column(temp, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                    // Update footer
                    $(api.column(temp).footer()).html(
                            pageTotal + ' (' + total + ' total)'
                            );
                }
            }
        });
    }
}

function initializeDetailsTable(type_input) {
    switch (type_input) {
        case "1":
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>               <th>#</th>  <th>Upload Date</th>           <th>Upload Time</th>            <th>Download Date</th>            <th>Download Time</th>            <th>Folder</th>            <th>CC Code</th>            <th>CC Name</th>            <th>Province</th>             <th>Customer Name</th>            <th>ID number</th>            <th>Channel</th>            <th>Cancel</th>            <th>Reason</th>      <th>Note</th>      <th>Size</th>            <th>Filename</th>            <th>Check</th>           <th>Classify user SG</th>   <th>Classify Speed</th>            <th>ID F1</th>            <th>User F1</th>   <th>Status F1</th>     <th>F1 Reason</th>    <th>DE user SG</th>          <th>DE Date</th>            <th>DE Time</th>       <th>Speed DE</th>       <th>Turn Around Time (h)</th>   <th>Duplication</th>            <th>Duplication Date</th>            <th>CC Code Dup</th>    </tr>   </thead></table>';
            break;
        case "2":
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>                          <th>#</th>      <th>Download Date</th>       <th>Download Time</th>            <th>Folder</th>            <th>CC Code</th>            <th>CC Name</th>            <th>Province</th>            <th>Kind</th>            <th>Name</th>            <th>ID number</th>            <th>Channel</th>            <th>Cancel</th>            <th>Cancel Reason</th>            <th>ID F1</th>            <th>User F1</th>            <th>Reason</th>      <th>Notes</th>       <th>Date</th>            <th>Time</th>        <th>Speed</th>     <th>Turn Around Time (h)</th>  <th>From VPBank</th>  <th>From SaigonBPO</th> </tr>   </thead></table>';
            break;
        case "7":
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>                          <th>#</th>      <th>Download Date</th>       <th>Download Time</th>            <th>Folder</th>            <th>CC Code</th>            <th>CC Name</th>            <th>Province</th>            <th>Kind</th>            <th>Name</th>            <th>ID number</th>            <th>Channel</th>            <th>Cancel</th>            <th>Cancel Reason</th>            <th>ID F1</th>            <th>User F1</th>            <th>Reason</th>      <th>Notes</th>       <th>Date</th>            <th>Time</th>        <th>Speed</th>     <th>Turn Around Time (h)</th>  <th>From VPBank</th>  <th>From SaigonBPO</th> </tr>   </thead></table>';
            break;
        case "8":
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>                          <th>#</th>      <th>Download Date</th>       <th>Download Time</th>            <th>Folder</th>            <th>CC Code</th>            <th>CC Name</th>            <th>Province</th>            <th>Kind</th>            <th>Name</th>            <th>ID number</th>            <th>Channel</th>            <th>Cancel</th>            <th>Cancel Reason</th>            <th>ID F1</th>            <th>User F1</th>            <th>Reason</th>      <th>Notes</th>       <th>Date</th>            <th>Time</th>        <th>Speed</th>     <th>Turn Around Time (h)</th>  <th>From VPBank</th>  <th>From SaigonBPO</th> </tr>   </thead></table>';
            break;
        case "3":
            document.getElementById("tab_details").innerHTML = '<table id="tablePreApproveDetails" class="table table-bordered table-striped" width="100%"><thead><tr><th>#</th> <th>Download Time</th> <th>ID F1</th> <th>Status F1</th> <th>QDE Reason of Sale</th> <th>Status SaigonBPO</th><th>Reason NOT OK</th> <th>Opportunity Name</th><th>No. Agreement ID</th> <th>TSA Code F1</th><th>TSA Name</th><th>TSA Phone Number</th><th>Product Name 1</th><th>Product Code 1</th><th>Loan Amount Request</th> <th>Loan Term Request</th><th>Insurance</th><th>Insurance Plus</th><th>Insurance Name</th><th>Date of Closure</th> <th>Disb Channel</th><th>Branch Code</th>  <th>Xử lý City</th> <th>Description</th> <th>Referee 1</th>   <th>Referee 2</th>   <th>Spouse Name</th><th>CC Code</th><th>CC Name</th> <th>DSA Code</th> <th>DSA Name</th> <th>New ID Card Number</th> <th>Date of Issue</th><th>Place of Issue</th><th>New Phone</th><th>Address</th><th>Actual Address</th><th>Monthly Income</th><th>Monthly Costs</th> <th>Monthly Income Family</th><th>Monthly Costs Family</th><th>Number of Modified Fields</th><th>Modified Fields</th> <th>management_id</th></tr></thead></table>';
//        $.ajax({
//            type: "POST",
//            url: "server_processing_details.php",
//            data: {FromDate : $('#txtFromDate').val(),ToDate : $('#txtToDate').val(), type : $("#slType").val()},
//            success: function (result) {
//                alert(result); return;
//            },
//            error: function (xhr, status, error) {
//                alert(error); return;
//            }
//        });            

            if (typeof table2 !== "undefined") {
                table2.destroy();
            }

            //console.log("initiallize");
            table2 = $('#tablePreApproveDetails').DataTable({
                "ajax": {
                    "url": "server_processing_details.php",
                    "pagingType": "full_numbers",
                    "data": function (d) {
                        d.FromDate = $('#txtFromDate').val();
                        d.ToDate = $('#txtToDate').val();
                        d.type = $("#slType").val();
                    }
                },
                "deferRender": true,
                "order": [
                    [0, "asc"]
                ],
                "scrollY": 555,
                "scrollX": true,
                scrollCollapse: true,
//                "bAutoWidth": false,
                "oLanguage": {
                    sProcessing: "<img src='img/ajax-loader.gif'>"
                },
                "bProcessing": true,
                "iDisplayLength": 44,
                "columnDefs": [
                    {
                        "targets": [20],
                        "visible": false,
                        "orderable": false
                    },
                    {
                        "targets": [35],
                        "visible": false,
                        "orderable": false
                    },
                    {
                        "targets": [41],
                        "visible": false,
                        "orderable": false
                    },
                    {
                        "targets": [42],
                        "visible": false,
                        "orderable": false
                    },
                    {
                        "targets": [43],
                        "visible": false,
                        "orderable": false
                    },
                    {
                        "targets": [1],
                        "width": 70
                    },
                    {
                        "targets": [4],
                        "width": 180
                    },
                    {
                        "targets": [6],
                        "width": 200
                    },
                    {
                        "targets": [7],
                        "width": 170
                    },
                    {
                        "targets": [10],
                        "width": 170
                    },
                    {
                        "targets": [12],
                        "width": 200
                    },
                    {
                        "targets": [23],
                        "width": 400
                    },
                    {
                        "targets": [26],
                        "width": 200
                    },
                    {
                        "targets": [28],
                        "width": 200
                    },
                    {
                        "targets": [33],
                        "width": 150
                    },
                    {
                        "targets": [36],
                        "width": 200
                    }
                ],
//                "aoColumnDefs": [
//                    {
//                        "targets": [37],
//                        "render": $.fn.dataTable.render.number(',', '.', 0, '')
//                    },
//                    {
//                        "targets": [38],
//                        "render": $.fn.dataTable.render.number(',', '.', 0, '')
//                    },
//                    {
//                        "targets": [39],
//                        "render": $.fn.dataTable.render.number(',', '.', 0, '')
//                    },
//                    {
//                        "targets": [40],
//                        "render": $.fn.dataTable.render.number(',', '.', 0, '')
//                    }                    
//                ],
                "fixedColumns": true

            });

            $('#dropdown_status').on('change', function () {
                var regExSearch = '^' + this.value + '$';
                //table2.columns(4).search('^\\s*' + this.value +'\\s*$').draw();
                if (this.value == '') {
                    table2.column(5).search('').draw();
                } else {
                    table2.column(5).search(regExSearch, true, false).draw();
                }
            });

//            table2.columns.adjust();
            $('#tablePreApproveDetails tbody').on('dblclick', 'tr', function () {
                var d = table2.row(this).data();
                var mana_id = d[43];
                var zip_id = 0;
                isclick = true;
                if ($(this).hasClass('selected'))
                    $(this).removeClass('selected');
                else
                {
                    $(this).siblings('.selected').removeClass('selected');
                    $(this).addClass('selected');
                }

                $.ajax({
                    url: 'content_pages/dataPost.php',
                    type: 'POST',
                    data: {mana_id: mana_id, zip_id: zip_id, type: type_input},
                    success: function (data) {
                        window.open('cus_loan_info_topup.php');
                    },
                    async: false
                });
            });

            $(document).on('keyup', function (event) {
                var type = $("#slType").val();
                ////console.log(event.keyCode + type);
                if ((event.keyCode == 13 || event.keyCode == 27) && type === "3") {
                    if (typeof table2 !== "undefined") {
                        table2.columns.adjust();
                    }
                }
            });

            break;
        case "4":
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%"><thead><tr><th>Download Date</th><th>Download Time</th> <th>Folder</th><th>CC Code</th><th>CC Name</th><th>Province</th><th>Kind</th><th>Name</th><th>ID number</th> <th>Channel</th><th>Cancel</th><th>Cancel Reason</th> <th>ID F1</th><th>User F1</th>   <th>Reason</th>  <th>Notes</th>  <th>Date</th>   <th>Time</th>   <th>Speed</th><th>Turn Around Time (h)</th></tr></thead></table>';
            break;
        case "5":
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>               <th>#</th>  <th>Upload Date</th>           <th>Upload Time</th>            <th>Download Date</th>            <th>Download Time</th>            <th>Folder</th>            <th>CC Code</th>            <th>CC Name</th>            <th>Province</th>             <th>Customer Name</th>            <th>ID number</th>            <th>Channel</th>            <th>Cancel</th>            <th>Reason</th>      <th>Note</th>      <th>Size</th>            <th>Filename</th>            <th>Check</th>           <th>Classify user SG</th>   <th>Classify Speed</th>            <th>ID F1</th>            <th>User F1</th>  <th>DE user SG</th>          <th>DE Date</th>            <th>DE Time</th>       <th>Speed DE</th>       <th>Turn Around Time (h)</th>   <th>Duplication</th>            <th>Duplication Date</th>            <th>CC Code Dup</th>    </tr>   </thead></table>';
            break;
        case "6":
            document.getElementById("tab_details").innerHTML = '<table id="tablePreApproveDetails" class="table table-bordered table-striped" width="100%"><thead><tr><th>#</th><th>Download Time</th><th>ID F1</th> <th>Status F1</th> <th>QDE Reason of Sale</th> <th>Status SaigonBPO</th> <th>Reason NOT OK</th><th>Opportunity Name</th><th>No. Agreement ID</th><th>TSA Code F1</th><th>TSA Name</th><th>TSA Phone Number</th><th>Product Name 1</th> <th>Product Code 1</th> <th>Loan Amount Request</th> <th>Loan Term Request</th><th>Insurance</th><th>Date of Closure</th> <th>Disb Channel</th><th>Branch Code</th><th>Description</th><th>Referee 1</th><th>Referee 2</th><th>Spouse Name</th><th>CC Code</th><th>CC Name</th> <th>DSA Code</th> <th>DSA Name</th> <th>New ID Card Number</th> <th>Date of Issue</th><th>Place of Issue</th><th>New Phone</th><th>Address</th><th>Actual Address</th><th>Monthly Income</th><th>Monthly Costs</th> <th>Monthly Income Family</th><th>Monthly Costs Family</th> <th>Product Name</th><th>Product Code</th><th>Offered Credit Limit</th><th>Embossing Name</th><th>Mailing Address</th><th>Answer for Security Question</th><th>Card Insurance Type</th><th>Number of Modified Fields</th><th>Modified Fields</th> <th>management_id</th></tr></thead></table>';
            if (typeof table2 !== "undefined") {
                table2.destroy();
            }

            //console.log("initiallize");
            table2 = $('#tablePreApproveDetails').DataTable({
                "ajax": {
                    "url": "server_processing_details.php",
                    "pagingType": "full_numbers",
                    "data": function (d) {
                        d.FromDate = $('#txtFromDate').val();
                        d.ToDate = $('#txtToDate').val();
                        d.type = $("#slType").val();

                    }
                },
                "deferRender": true,
                "order": [
                    [0, "asc"]
                ],
                "scrollY": 555,
                "scrollX": true,
                scrollCollapse: true,
//                "bAutoWidth": false,
                "oLanguage": {
                    sProcessing: "<img src='img/ajax-loader1.gif'>"
                },
                "bProcessing": true,
                "iDisplayLength": 48,
                "columnDefs": [{
                        "targets": [47],
                        "visible": false,
                        "orderable": false
                    }],
                    "fixedColumns": true
            });

            $('#dropdown_status').on('change', function () {
                var regExSearch = '^' + this.value + '$';
                //table2.columns(4).search('^\\s*' + this.value +'\\s*$').draw();
                if (this.value == '') {
                    table2.column(5).search('').draw();
                } else {
                    table2.column(5).search(regExSearch, true, false).draw();
                }
            });
            
            $('#tablePreApproveDetails tbody').on('dblclick', 'tr', function () {
                var d = table2.row(this).data();
                var mana_id = d[47];
                var zip_id = 0;
                isclick = true;
                if ($(this).hasClass('selected'))
                    $(this).removeClass('selected');
                else
                {
                    $(this).siblings('.selected').removeClass('selected');
                    $(this).addClass('selected');
                }

                $.ajax({
                    url: 'content_pages/dataPost.php',
                    type: 'POST',
                    data: {mana_id: mana_id, zip_id: zip_id, type: type_input},
                    success: function (data) {
                        window.open('cus_loan_info_crc.php');
                    },
                    async: false
                });
            });
            
//            $(document).on('keyup', function (event) {
//                var type = $("#slType").val();
//                ////console.log(event.keyCode + type);
//                if ((event.keyCode == 13 || event.keyCode == 27) && type === "3") {
//                    if (typeof table2 !== "undefined") {
//
//                        table2.columns.adjust();
//                    }
//                }
//            });
            break;
    }

    if (type_input != "3" && type_input != "6") {
        if (type_input == "1" || type_input == "2" || type_input == "7" || type_input == "8") {
            table2 = $('#tableData2').DataTable({
                "ajax": {
                    "url": "server_processing_details.php",
                    "pagingType": "full_numbers",
                    "data": function (d) {
                        d.FromDate = $('#txtFromDate').val();
                        d.ToDate = $('#txtToDate').val();
                        d.type = $("#slType").val();
                    }
                },
                "oLanguage": {
                    sProcessing: "<img src='img/ajax-loader1.gif'>"
                },
                "bProcessing": true,
                "deferRender": true,
                "scrollY": 555,
                "scrollX": true,
                "bAutoWidth": false,
                "iDisplayLength": 31
            });
        } else {
            table2 = $('#tableData2').DataTable({
                "ajax": {
                    "url": "server_processing_details.php",
                    "pagingType": "full_numbers",
                    "data": function (d) {
                        d.FromDate = $('#txtFromDate').val();
                        d.ToDate = $('#txtToDate').val();
                        d.type = $("#slType").val();
                        d.mobile = true;
                    }
                },
                "deferRender": true,
                "oLanguage": {
                    sProcessing: "<img src='img/ajax-loader1.gif'>"
                },
                "bProcessing": true,
                "scrollY": 555,
                "scrollX": true,
                "bAutoWidth": false,
                "iDisplayLength": 30
            });
        }
    }

//    $('#tableData2 tbody').on('dblclick', 'tr', function () {
//        if (type_input !== 2 && type_input !== 4 && type_input !== 5) {
//            var d = table2.row(this).data();
//            var mana_id = d[30];
//            var zip_id = 0;
////            $.post('cus_loan_info_ntb.php', {mana_id: mana_id, zip_id: zip_id, type: type_input}, function () {
////                window.open('cus_loan_info_ntb.php');
////            });
//            $.ajax({
//                url: 'content_pages/dataPost.php',
//                type: 'POST',
//                data: {mana_id: mana_id, zip_id: zip_id, type: type_input},
//                success: function (data) {
//                    window.open('cus_loan_info_ntb.php');
//                },
//                async: false
//            });
//        }
//    });

    // Hide column 
    switch (type_input) {
        case "1":
            // Get the column API object
            //var column_classy_user_dg = table2.column( 23 );

            var role = '@Session["monitoring_userrole"]';
            if (role !== "admin") {
                var column_classify_speed = table2.column(19);
                var column_classify_user_dg = table2.column(18);
                var column_de_user_dg = table2.column(24);
                var column_speed_de = table2.column(27);
                var column_tat = table2.column(28);
                if (role == "teamleader") {
                    var column_note = table2.column(14);
                    column_note.visible(false);
                }
                column_classify_speed.visible(false);
                column_classify_user_dg.visible(false);
                // Toggle the visibility
                column_de_user_dg.visible(false);
                column_speed_de.visible(false);
                column_tat.visible(false);
            }

            break;
        case "2":
            var role = user_role;
            if (role !== "admin") {
                var column_speed = table2.column(19);
                var column_tat = table2.column(20);
                column_tat.visible(false);
                column_speed.visible(false);
            }
            break;
        case "3":
            // Get the column API object
            //                    var column_management = table2.column( 2 );
            //                    var column_iseditable = table2.column( 40 );
            //                    // Toggle the visibility
            //                    column_management.visible( false );
            //                    column_iseditable.visible(false);
            break;
        case "4":
            var role = user_role;
            if (role !== "admin") {
                var column_speed = table2.column(18);
                column_speed.visible(false);
                var column_tat = table2.column(19);
                column_tat.visible(false);
            }
            break;
        case "5":
            var role = user_role;
            if (role !== "admin") {
                var column_classify_speed = table2.column(19);
                var column_classify_user_dg = table2.column(18);
                var column_de_user_dg = table2.column(22);
                var column_speed_de = table2.column(25);
                var column_tat = table2.column(26);

                column_classify_speed.visible(false);
                column_classify_user_dg.visible(false);
                // Toggle the visibility
                column_de_user_dg.visible(false);
                column_speed_de.visible(false);
                column_tat.visible(false);
            }
            break;
        case "7":
            var role = user_role;
            if (role !== "admin") {
                var column_speed = table2.column(19);
                var column_tat = table2.column(20);
                column_tat.visible(false);
                column_speed.visible(false);
            }
            break;
        case "8":
            var role = user_role;
            if (role !== "admin") {
                var column_speed = table2.column(19);
                var column_tat = table2.column(20);
                column_tat.visible(false);
                column_speed.visible(false);
            }
            break;
    }

//        jQuery('.numbersOnly').keyup(function () { 
//            //console.log("foisjdfij");
//            this.value = this.value.replace(/[^0-9\.]/g,'');
//        });
    $(document).on('keydown', '.datepicker', function (e) {
        e.preventDefault();
    });

    $(document).on('keydown', '.numbersOnly', function (e) {
        //var v = this.value;
        var keyPressed;
        if (!e)
            var e = window.event;
        if (e.keyCode)
            keyPressed = e.keyCode;
        else if (e.which)
            keyPressed = e.which;
        var hasDecimalPoint = (($(this).val().split('.').length - 1) > 0);
        if (keyPressed == 46 || keyPressed == 8 || ((keyPressed == 190 || keyPressed == 110) && (!hasDecimalPoint)) || keyPressed == 9 || keyPressed == 27 ||
                // Allow: Ctrl+A
                        (keyPressed == 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                                (keyPressed >= 35 && keyPressed <= 39)) {
                    // let it happen, don't do anything
                    return;
                } else {
                    // Ensure that it is a number and stop the keypress
                    if (e.shiftKey || (keyPressed < 48 || keyPressed > 57) && (keyPressed < 96 || keyPressed > 105)) {
                        e.preventDefault();
                    }
                }
            });

}

//function detailinfo(id) {
//    $.post('cus_loan_info_ntb.php', {mana_id: id, zip_id: 0, type: 0}, function () {
////                            window.open('cus_loan_info_ntb.php');
//        var popup = window.open('cus_loan_info_ntb.php', "popup", "resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes");
//        if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight)
//        {
//            popup.moveTo(0, 0);
//            popup.resizeTo(screen.availWidth, screen.availHeight);
//        }
//    });
//}