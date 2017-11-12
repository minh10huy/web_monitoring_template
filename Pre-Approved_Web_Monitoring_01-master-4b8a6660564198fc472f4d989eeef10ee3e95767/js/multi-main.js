worker = new Worker('js/multi-worker.js');
worker.addEventListener('message', function(e) {
    showProgress(e.data);
});

getData = null;
dateInput = null;
type_input = 1;
function start(date, type) {
    $("#warning_box_loading").show(100);

    dateInput = date;
    type_input = type;
    // tell web worker to start busy work
    worker.postMessage(1);
}

function showProgress(elapsedSeconds) {

    var waiting_progressHTML = '<div class="box box-danger">' +
            '<div class="box-header">' +
            '<h3 class="box-title"></h3>' +
            '<div class="box-tools pull-right">' +
            '</div>' +
            '</div>' +
            '<div class="box-body">' +
            '<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;\n\
            </p><p>&nbsp;</p><p>&nbsp;</p></p><p>&nbsp;</p><p>&nbsp;</p>'+
            '</div><!-- /.box-body -->' +
            '<!-- Loading (remove the following to stop the loading)-->' +
            '<div class="overlay"></div>' +
            '<div class="loading-img"></div>' +
            '<!-- end loading -->' +
            '</div>';

    $('#tab_1').html(waiting_progressHTML);
    $('#tab_2').html(waiting_progressHTML);
    $('#tab_3').html(waiting_progressHTML);
//    $('#tab_1').show(1000);
//    $('#tab_2').show(1000);
//    $('#tab_3').show(1000);

    var strURL = "ajax/ajax.php";

    $.ajax({
        url: strURL,
        type: 'POST',
        cache: false,
        data: 'view=' + elapsedSeconds + "&date_input=" + dateInput + "&type_input="+type_input,
        success: function(string) {

            /**
             * Kiểu mặc định trả về là dạng String, dùng hàm parseJSON để phân tích dữ liệu trả về
             * có 2 cách parse JSON là : JSON.parse() và $.parseJSON();
             * 1. var getData = JSON.parse(string);
             * 2. var getData = $.parseJSON(string);
             **/
            var getData = $.parseJSON(string);
            var resultDataReportGeneral = getData.resultDataReportGeneral;
            var resultDataReportDetails = getData.resultDataReportDetails;
            var resultDataReportDetailsSpeed = getData.resultDataReportDetailsSpeed;
            
//            alert(resultDataReportGeneral);
//            alert(resultDataReportDetails);
//            alert(resultDataReportDetailsSpeed);
            
            // Put dữ liệu warning trả về lên giao diện
//            $('#tab_1').hide(1);
            $('#tab_1').html(resultDataReportGeneral);
//            $('#tab_1').html($('#tab_1').html() + "<div id='yourHeaderContainer'></div><div id='yourContentContainer'></div>");
//            var header = $('#tableData1').find("thead").html();
//            var body = $('#tableData1').find("tbody").html();
            
            // add <table> tags to both header and body or the containers
//            $("#yourHeaderContainer").html(header);
//            $("#yourContentContainer").html(body);
//            $('#tableData1').hide();
    
            $("#tableData1").dataTable();
//            $("#tableData1").tablesorter({sortList: [[0, 0], [2, 1]], widgets: ['zebra']});
//            $("#tableData1").tablesorter({sortList: [[0, 0]], headers: {3: {sorter: false}, 4: {sorter: false}}});
//            $("#tableData1").freezeHeader({ 'height': '300px' });
//            $('#tab_1').show(500);

//            $('#tab_2').hide(1);
            $('#tab_2').html(resultDataReportDetails);
            $("#tableData2").dataTable();
//            $('#tab_2').show(500);
//            
//            $('#tab_3').hide(1);
            $('#tab_3').html(resultDataReportDetailsSpeed);
            $("#tableData3").dataTable();
//            $('#tab_3').show(500);
            
            var exportTable1=new ExportHTMLTable('tableData1');
            exportTable1.exportToCSV();
        },
        error: function() {
//            alert('Có lỗi xảy ra');
        }

    });
}

$(function() {
    $('button').one('click', start);
});