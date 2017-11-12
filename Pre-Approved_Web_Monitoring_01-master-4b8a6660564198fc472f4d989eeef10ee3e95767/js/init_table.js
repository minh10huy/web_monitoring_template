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
//         $.fn.DataTable.fnSetFilteringDelay = $.fn.fnSetFilteringDelay;
//        $.fn.dataTable.Api.register('fnSetFilteringDelay()', $.fn.fnSetFilteringDelay );

function initializeGeneralTable(type_input) {
    switch (type_input) {
        case "1":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>            <th>#</th>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>From</th>            <th>To</th>            <th>Finished</th>            <th>Canceled</th>            <th>Duplication</th>            <th>Pending</th>      </tr>   </thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "2":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%"><thead><tr>            <th>#</th>            <th>Date</th>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>Hard</th>            <th>Soft</th>            <th>Cancelled</th>            <th>Pending</th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "3":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%"><thead><tr>        <th>Day</th>        <th>Done - Meeting</th>        <th>Done - Pending</th>        <th>Duplicate</th>        <th>Entered</th>        <th>Meeting</th>        <th>Pending</th>        <th>Pending - Updated</th>        <th>QDE - Cancel</th>        <th>QDE - Done</th>        <th>QDE - Others</th>        <th>QDE - Updated</th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "4":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>            <th>Date</th>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>Hard</th>            <th>Soft</th>            <th>Cancelled</th>            <th>Pending</th>            </tr>   </thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "5":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%">   <thead>      <tr>            <th>User</th>            <th>CC Name</th>            <th>Channel</th>            <th>Province</th>            <th>From</th>            <th>To</th>            <th>Finished</th>            <th>Canceled</th>            <th>Duplication</th>            <th>Pending</th>      </tr>   </thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
            break;
        case "6":
            document.getElementById("tab_general").innerHTML = '<table id="tableData1" class="table table-bordered table-striped" width="100%"><thead><tr>        <th>Day</th>        <th>Done - Meeting</th>        <th>Done - Pending</th>        <th>Duplicate</th>        <th>Entered</th>        <th>Meeting</th>        <th>Pending</th>        <th>Pending - Updated</th>        <th>QDE - Cancel</th>        <th>QDE - Done</th>        <th>QDE - Others</th>        <th>QDE - Updated</th></tr></thead><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table>';
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
                    d.date = $('#txtDate').val();
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
                    d.date = $('#txtDate').val();
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
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>               <th>#</th>  <th>Upload Date</th>           <th>Upload Time</th>            <th>Download Date</th>            <th>Download Time</th>            <th>Folder</th>            <th>CC Code</th>            <th>CC Name</th>            <th>Province</th>             <th>Customer Name</th>            <th>ID number</th>            <th>Channel</th>            <th>Cancel</th>            <th>Reason</th>            <th>Size</th>            <th>Filename</th>            <th>Check</th>           <th>Classify user SG</th>   <th>Classify Speed</th>            <th>ID F1</th>            <th>User F1</th>  <th>DE user SG</th>          <th>DE Date</th>            <th>DE Time</th>            <th>Note</th>  <th>Speed DE</th>       <th>Turn Around Time (h)</th>   <th>Duplication</th>            <th>Duplication Date</th>            <th>CC Code Dup</th>  <th>management_id</th>  </tr>   </thead></table>';
            break;
        case "2":
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%">   <thead>      <tr>                          <th>#</th>      <th>Download Date</th>       <th>Download Time</th>            <th>Folder</th>            <th>CC Code</th>            <th>CC Name</th>            <th>Province</th>            <th>Kind</th>            <th>Name</th>            <th>ID number</th>            <th>Channel</th>            <th>Cancel</th>            <th>Cancel Reason</th>            <th>ID F1</th>            <th>User F1</th>            <th>Reason</th>      <th>Notes</th>       <th>Date</th>            <th>Time</th>        <th>Speed</th>     <th>Turn Around Time (h)</th>  <th>From VPBank</th>  <th>From SaigonBPO</th> </tr>   </thead></table>';

            break;
        case "3":
            document.getElementById("tab_details").innerHTML = '<table id="tablePreApproveDetails" class="table table-bordered table-striped" width="100%"><thead><tr><th class="no-sort">Edit</th><th>#</th> <th>management_id</th><th>TSA Code F1</th><th>TSA Name</th><th>TSA Phone Number</th><th>Product Name 1</th><th>Product Code 1</th><th>Loan Amount Request</th> <th>Loan Term Request</th><th>Insurance</th><th>Insurance Plus</th><th>Insurance Name</th><th>Date of Closure</th> <th>Disb Channel</th><th>Branch Code</th>   <th>Description</th> <th>ID F1</th> <th>Status F1</th> <th>QDE Reason of Sale</th> <th>Status SaigonBPO</th><th>Reason NOT OK</th> <th>Referee 1</th>   <th>Referee 2</th>   <th>Spouse Name</th><th>CC Code</th><th>CC Name</th> <th>DSA Code</th> <th>DSA Name</th> <th>Opportunity Name</th><th>No. Agreement ID</th><th>New ID Card Number</th> <th>Date of Issue</th><th>Place of Issue</th><th>New Phone</th><th>Address</th><th>Actual Address</th><th>Monthly Income</th><th>Monthly Costs</th> <th>Monthly Income Family</th><th>Monthly Costs Family</th><th>Number of Modified Fields</th><th>Modified Fields</th> <th>Download Time</th> <th>is_editable</th></tr></thead></table>';

            if (typeof table2 !== "undefined") {
                table2.destroy();
            }

            //console.log("initiallize");
            table2 = $('#tablePreApproveDetails').DataTable({
                "ajax": {
                    "url": "server_processing_details.php",
                    "pagingType": "full_numbers",
                    "data": function (d) {
                        d.date = $('#txtDate').val();
                        d.type = $("#slType").val();

                    }
                },
                "deferRender": true,
                "order": [
                    [1, "asc"]
                ],
                "scrollY": 555,
                "scrollX": true,
                "bAutoWidth": false,
                "oLanguage": {
                    sProcessing: "<img src='img/ajax-loader1.gif'>"
                },
                "bProcessing": true,
                "iDisplayLength": 44,
                "aoColumnDefs": [{
                        "render": function (data, type, row) {

                            // Check condition to display edit button
                            // There is no ID F1 and Status Digi is Pending
                            if (((row[17] == null || row[17].length == 0) && row[20] == "Pending") || row[44] === "f")
                                return '<div style="text-align: left;" class="tabledit-toolbar btn-toolbar"><div style="float: none;" class="btn-group btn-group-sm"><button style="float: none;" class="tabledit-edit-button btn btn-sm btn-default" type="button"><span class="glyphicon glyphicon-pencil"></span></button></div><button style="display: none; float: none;" class="tabledit-save-button btn btn-sm btn-success" type="button">save</button></div>';
                            else
                                return '';
                        },
                        "targets": 0,
//                        "sClass": "edit_style",
                        "sClass": "hide_me",
                        "orderable": false
                    }, {
                        "targets": 2,
                        "sClass": "hide_me"
                    }, {
                        "targets": 44,
                        "sClass": "hide_me"
                    }],
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).find('td').each(function (index) {
                        //                                          //console.log("index : " + index);  
                        var $th = $("#tablePreApproveDetails thead tr th").eq($(this).index());

                        //                                         //console.log("column : " + $th.text());  
                        if ($th.text() === "TSA Code F1" || $th.text() === "TSA Code F1" || $th.text() === "Download Time" || $th.text() === "#" || $th.text() === "Status F1" || $th.text() === "ID F1" || $th.text() === "Status SaigonBPO" || $th.text() === "Reason NOT OK" || $th.text() === "is_editable" || $th.text() === "Edit" || $th.text() === "management_id")
                            return true;
                        ////console.log($th.text() + " : " +  aData[index+1]);
                        var td = 'td:eq(' + index + ')';
                        if ($th.text() == "Date of Issue" || $th.text() == "Date of Closure")
                            $(td, nRow).html('<span class="tabledit-span">' + aData[index] + '</span><input class="tabledit-input form-control input-sm datepicker" type="text" name="' + $th.text() + '" value="' + aData[index] + '" style="display: none; width: 100%;" disabled="">');

                        else if ($th.text() == "Loan Amount Request")
                            $(td, nRow).html('<span class="tabledit-span">' + aData[index] + '</span><input class="tabledit-input form-control input-sm numbersOnly" type="text" name="' + $th.text() + '" value="' + aData[index] + '" style="display: none; width: 100%;" disabled="">');

                        else
                            $(td, nRow).html('<span class="tabledit-span">' + aData[index] + '</span><input class="tabledit-input form-control input-sm" type="text" name="' + $th.text() + '" value="' + aData[index] + '" style="display: none; width: 100%;" disabled="">');
                        $(td, nRow).addClass("tabledit-view-mode");
                    });
                    //                                  

                    $(nRow).attr('id', aData[2]);

                }

            });
            table2.columns.adjust();

            var tbedit = $('#tablePreApproveDetails').Tabledit({
                columns: {
                    identifier: [2, 'management_id'],
                    editable: [
                        [6, 'Product Name 1'],
                        [7, 'Product Code 1'],
                        [8, 'Loan Amount Request'],
                        [9, 'Loan Term Request'],
                        [10, 'Insurance'],
                        [11, 'Insurance Plus'],
                        [12, 'Insurance Name'],
                        [13, 'Date of Closure'],
                        [14, 'Disb Channel'],
                        [15, 'Branch Code'],
                        [16, 'Description'],
                        [22, 'Referee 1'],
                        [23, 'Referee 2'],
                        [24, 'Spouse Name'],
                        [25, 'CC Code'],
                        [26, 'CC Name'],
                        [27, 'DSA Code'],
                        [28, 'DSA Name'],
                        [29, 'Opportunity Name'],
                        [30, 'No. Agreement ID'],
                        [31, 'New ID Card Number'],
                        [32, 'Date of Issue'],
                        [33, 'Place of Issue'],
                        [34, 'New Phone'],
                        [35, 'Address'],
                        [36, 'Actual Address'],
                        [37, 'Monthly Income'],
                        [38, 'Monthly Costs'],
                        [39, 'Monthly Income Family'],
                        [40, 'Monthly Costs Family'],
                        [41, 'Number of Modified Fields'],
                        [42, 'Modified Fields']
                    ]
                },
                url: 'updateData.php'
            });

            $('#tablePreApproveDetails').on('click', 'button.tabledit-edit-button', function (event) {
                if (event.handled !== true) {
                    event.preventDefault();
                }
                table2.columns.adjust();
                //$(table2).dataTable().fnAdjustColumnSizing();
                //$(table2).fnAdjustColumnSizing(false);
                $(".tabledit-edit-mode input:first").focus();
                if (!$('.datepicker').data('datepicker'))
                    $('.datepicker').datepicker({format: 'yyyy-mm-dd', autoclose: true});
                $(".datepicker").datepicker("hide");
            });

            $('#tablePreApproveDetails tbody').on('click', 'tr', function () {

                if (user_role === "cc" || user_role === "admin" || user_role === "teamleader" || user_role === "subadmin") {
                    var d = table2.row(this).data();
                    var cus_name = d[29];
                    var idF1 = d[17];
                    var cus_id = d[31];
                    var is_editable = d[44];
                    var status = d[18];
                    var mana_id = d[2];

//                        if ((idF1 != null && idF1 != "" && idF1.length > 0) || is_editable === 'f') {
//                            window.location = "qde_commu.php?idF1=" + idF1 + "&cus_id=" + cus_id + "&cus_name=" + cus_name + "&prod_type=" + type_input;
//                            //$.redirect('qde_commu.php', {'idF1': idF1, 'cus_id': cus_id, 'cus_name': cus_name, 'prod_type': type_input}, 'GET');
//
//                        } else {}
                    var url = 'cus_loan_info_topup.php?mana_id=' + mana_id + '&type_input=' + type_input + '&is_editable=' + is_editable;
//                    window.open(url, 'popUpWindow', 'height=800, width=1000, left=300, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');
//                    window.location = url;
//                    window.open(url);
                    var popup = window.open(url, "popup", "resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes");
                    if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight)
                    {
                        popup.moveTo(0, 0);
                        popup.resizeTo(screen.availWidth, screen.availHeight);
                    }


//                    window.open(url, 'popUpWindow', 'height=800, width=1000, left=300, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');

//                    $.post('cus_loan_info.php', {mana_id: mana_id}, function (result) {
//                        newpage = result;
//                        window.open('cus_loan_info.php', 'popUpWindow', 'height=800, width=1000, left=300, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');
//                    });


                }
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
            document.getElementById("tab_details").innerHTML = '<table id="tableData2" class="table table-bordered table-striped" width="100%">   <thead>      <tr> <th>#</th>  <th>Upload Date</th>           <th>Upload Time</th>            <th>Download Date</th>            <th>Download Time</th>            <th>Folder</th>            <th>CC Code</th>            <th>CC Name</th>            <th>Province</th>             <th>Customer Name</th>            <th>ID number</th>            <th>Channel</th>            <th>Cancel</th>            <th>Reason</th>            <th>Size</th>            <th>Filename</th>            <th>Check</th>           <th>Classify user SG</th>   <th>Classify Speed</th>            <th>ID F1</th>            <th>User F1</th>  <th>DE user SG</th>          <th>DE Date</th>            <th>DE Time</th>            <th>Note</th>  <th>Speed DE</th>       <th>Turn Around Time (h)</th>   <th>Duplication</th>            <th>Duplication Date</th>            <th>CC Code Dup</th>  <th>management_id</th>  </tr>   </thead></table>';
            break;
        case "6":
            document.getElementById("tab_details").innerHTML = '<table id="tablePreApproveDetails" class="table table-bordered table-striped" width="100%"><thead><tr><th class="no-sort">Edit</th><th>#</th> <th>management_id</th><th>TSA Code F1</th><th>TSA Name</th><th>TSA Phone Number</th><th>Product Name 1</th> <th>Product Code 1</th> <th>Loan Amount Request</th> <th>Loan Term Request</th><th>Insurance</th><th>Date of Closure</th> <th>Disb Channel</th><th>Branch Code</th>   <th>Description</th> <th>ID F1</th> <th>Status F1</th> <th>QDE Reason of Sale</th> <th>Status SaigonBPO</th> <th>Reason NOT OK</th> <th>Referee 1</th>   <th>Referee 2</th>   <th>Spouse Name</th><th>CC Code</th><th>CC Name</th> <th>DSA Code</th> <th>DSA Name</th> <th>Opportunity Name</th><th>No. Agreement ID</th><th>New ID Card Number</th> <th>Date of Issue</th><th>Place of Issue</th><th>New Phone</th><th>Address</th><th>Actual Address</th><th>Monthly Income</th><th>Monthly Costs</th> <th>Monthly Income Family</th><th>Monthly Costs Family</th> <th>Product Name</th><th>Product Code</th><th>Offered Credit Limit</th><th>Embossing Name</th><th>Mailing Address</th><th>Answer for Security Question</th> <th>Number of Modified Fields</th><th>Modified Fields</th> <th>Download Time</th><th>is_editable</th></tr></thead></table>';

            if (typeof table2 !== "undefined") {
                table2.destroy();
            }

            //console.log("initiallize");
            table2 = $('#tablePreApproveDetails').DataTable({
                "ajax": {
                    "url": "server_processing_details.php",
                    "pagingType": "full_numbers",
                    "data": function (d) {
                        d.date = $('#txtDate').val();
                        d.type = $("#slType").val();

                    }
                },
                "deferRender": true,
                "order": [
                    [1, "asc"]
                ],
                "scrollY": 555,
                "scrollX": true,
                "bAutoWidth": false,
                "oLanguage": {
                    sProcessing: "<img src='img/ajax-loader1.gif'>"
                },
                "bProcessing": true,
                "iDisplayLength": 48,
                "aoColumnDefs": [{
                        "render": function (data, type, row) {

                            // Check condition to display edit button
                            // There is no ID F1 and Status Digi is Pending
                            if (((row[15] == null || row[15].length == 0) && row[18] == "Pending") || row[48] === "f")
                                return '<div style="text-align: left;" class="tabledit-toolbar btn-toolbar"><div style="float: none;" class="btn-group btn-group-sm"><button style="float: none;" class="tabledit-edit-button btn btn-sm btn-default" type="button"><span class="glyphicon glyphicon-pencil"></span></button></div><button style="display: none; float: none;" class="tabledit-save-button btn btn-sm btn-success" type="button">save</button></div>';
                            else
                                return '';
                        },
                        "targets": 0,
//                        "sClass": "edit_style",
                        "sClass": "hide_me",
                        "orderable": false
                    }, {
                        "targets": 2,
                        "sClass": "hide_me"
                    }, {
                        "targets": 2,
                        "sClass": "hide_me"
                    }, {
                        "targets": 48,
                        "sClass": "hide_me"
                    }],
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).find('td').each(function (index) {
                        //                                          //console.log("index : " + index);  
                        var $th = $("#tablePreApproveDetails thead tr th").eq($(this).index());

                        //                                         //console.log("column : " + $th.text());  
                        if ($th.text() === "TSA Code F1" || $th.text() === "Download Time" || $th.text() === "#" || $th.text() === "Status F1" || $th.text() === "ID F1" || $th.text() === "Status SaigonBPO" || $th.text() === "Reason NOT OK" || $th.text() === "is_editable" || $th.text() === "Edit" || $th.text() === "management_id")
                            return true;
                        ////console.log($th.text() + " : " +  aData[index+1]);
                        var td = 'td:eq(' + index + ')';
                        if ($th.text() == "Date of Issue" || $th.text() == "Date of Closure")
                            $(td, nRow).html('<span class="tabledit-span">' + aData[index] + '</span><input class="tabledit-input form-control input-sm datepicker" type="text" name="' + $th.text() + '" value="' + aData[index] + '" style="display: none; width: 100%;" disabled="">');

                        else if ($th.text() == "Loan Amount Request")
                            $(td, nRow).html('<span class="tabledit-span">' + aData[index] + '</span><input class="tabledit-input form-control input-sm numbersOnly" type="text" name="' + $th.text() + '" value="' + aData[index] + '" style="display: none; width: 100%;" disabled="">');

                        else
                            $(td, nRow).html('<span class="tabledit-span">' + aData[index] + '</span><input class="tabledit-input form-control input-sm" type="text" name="' + $th.text() + '" value="' + aData[index] + '" style="display: none; width: 100%;" disabled="">');
                        $(td, nRow).addClass("tabledit-view-mode");
                    });
                    //                                  

                    $(nRow).attr('id', aData[2]);

                }

            });
            table2.columns.adjust();

            var tbedit = $('#tablePreApproveDetails').Tabledit({
                columns: {
                    identifier: [2, 'management_id'],
                    editable: [
                        [6, 'Product Name 1'],
                        [7, 'Product Code 1'],
                        [8, 'Loan Amount Request'],
                        [9, 'Loan Term Request'],
                        [10, 'Insurance'],
                        [11, 'Date of Closure'],
                        [12, 'Disb Channel'],
                        [13, 'Branch Code'],
                        [14, 'Description'],
                        [20, 'Referee 1'],
                        [21, 'Referee 2'],
                        [22, 'Spouse Name'],
                        [23, 'CC Code'],
                        [24, 'CC Name'],
                        [25, 'DSA Code'],
                        [26, 'DSA Name'],
                        [27, 'Opportunity Name'],
                        [28, 'No. Agreement ID'],
                        [29, 'New ID Card Number'],
                        [30, 'Date of Issue'],
                        [31, 'Place of Issue'],
                        [32, 'New Phone'],
                        [33, 'Address'],
                        [34, 'Actual Address'],
                        [35, 'Monthly Income'],
                        [36, 'Monthly Costs'],
                        [37, 'Monthly Income Family'],
                        [38, 'Monthly Costs Family'],
                        [39, 'Product Name'],
                        [40, 'Product Code'],
                        [41, 'Offered Credit Limit'],
                        [42, 'Embossing Name'],
                        [43, 'Mailing Address'],
                        [44, 'Answer for Security Question'],
                        [45, 'Number of Modified Fields'],
                        [46, 'Modified Fields']
                    ]
                },
                url: 'updateDataCRC.php'
            });

            $('#tablePreApproveDetails').on('click', 'button.tabledit-edit-button', function (event) {
                if (event.handled !== true) {
                    event.preventDefault();
                }
                table2.columns.adjust();
                //$(table2).dataTable().fnAdjustColumnSizing();
                //$(table2).fnAdjustColumnSizing(false);
                $(".tabledit-edit-mode input:first").focus();
                if (!$('.datepicker').data('datepicker'))
                    $('.datepicker').datepicker({format: 'yyyy-mm-dd', autoclose: true});
                $(".datepicker").datepicker("hide");
            });

            $('#tablePreApproveDetails tbody').on('click', 'tr', function () {

                if (user_role === "cc" || user_role === "admin" || user_role === "teamleader" || user_role === "subadmin") {
                    var d = table2.row(this).data();
                    var cus_name = d[27];
                    var idF1 = d[15];
                    var cus_id = d[29];
                    var is_editable = d[48];
                    var status = d[16];
                    var mana_id = d[2];

//                    if ((idF1 != null && idF1 != "" && idF1.length > 0) || is_editable === 'f') {
//                        window.location = "qde_commu.php?idF1=" + idF1 + "&cus_id=" + cus_id + "&cus_name=" + cus_name + "&prod_type=" + type_input;
//                        //$.redirect('qde_commu.php', {'idF1': idF1, 'cus_id': cus_id, 'cus_name': cus_name, 'prod_type': type_input}, 'GET');
//
//                    } else {
//                    }
                    var url = 'cus_loan_info_crc.php?mana_id=' + mana_id + '&type_input=' + type_input + '&is_editable=' + is_editable;
//                    window.open(url, 'popUpWindow', 'height=800, width=1000, left=300, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');
//                    window.location = url;
//                    window.open(url);
                    var popup = window.open(url, "popup", "resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes");
                    if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight)
                    {
                        popup.moveTo(0, 0);
                        popup.resizeTo(screen.availWidth, screen.availHeight);
                    }
                }
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
    }

    if (type_input != "3" && type_input != "6") {
        if (type_input == "1" || type_input == "5") {
            table2 = $('#tableData2').DataTable({
                //                       

                "ajax": {
                    "url": "server_processing_details.php",
                    "pagingType": "full_numbers",
                    "data": function (d) {
                        d.date = $('#txtDate').val();
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
                "iDisplayLength": 30,
                "aoColumnDefs": [
                    {
                        "targets": 30,
                        "sClass": "hide_me"
                    }
                ]
            });
        } else {
            table2 = $('#tableData2').DataTable({
                //                       

                "ajax": {
                    "url": "server_processing_details.php",
                    "pagingType": "full_numbers",
                    "data": function (d) {
                        d.date = $('#txtDate').val();
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

    $('#tableData2 tbody').on('click', 'tr', function () {
        //console.log("clicked");
        if (type_input != 2 && type_input != 4 && type_input != 5 && (user_role === "cc" || user_role === "admin" || user_role === "teamleader")) {
            var idF1;
            var d = table2.row(this).data();
            if (username === "admin")
                idF1 = d[19];
            else
                idF1 = d[19];
            var cus_name = d[9];
            var cus_id = d[10];
            var mana_id = d[30];

            var url = 'cus_loan_info_ntb.php?mana_id=' + mana_id + '&type_input=' + type_input;
            var popup = window.open(url, "popup", "resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes");
            if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight)
            {
                popup.moveTo(0, 0);
                popup.resizeTo(screen.availWidth, screen.availHeight);
            }
        }
    });

    // Hide column 
    switch (type_input) {
        case "1":
            // Get the column API object
            //var column_classy_user_dg = table2.column( 23 );

            var role = user_role;
            if (role !== "admin") {
                var column_classify_speed = table2.column(18);
                var column_classify_user_dg = table2.column(17);
                var column_de_user_dg = table2.column(21);
                var column_speed_de = table2.column(25);
                var column_tat = table2.column(26);
                if (role == "teamleader") {
                    var column_note = table2.column(24);
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
                var column_classify_speed = table2.column(17);
                var column_classify_user_dg = table2.column(16);
                var column_de_user_dg = table2.column(20);
                var column_speed_de = table2.column(24);
                var column_tat = table2.column(25);

                column_classify_speed.visible(false);
                column_classify_user_dg.visible(false);
                // Toggle the visibility
                column_de_user_dg.visible(false);
                column_speed_de.visible(false);
                column_tat.visible(false);
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
;