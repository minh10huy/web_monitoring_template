 
 
 
 
 $(function() {
        $('#txtDate').daterangepicker({
            format: 'DD/MM/YYYY'
        });
    });


//    $(document).ajaxComplete(function(event, request, settings) {
//        //$( "#msg" ).append( "<li>Request Complete.</li>" );
//        //Get object
//        var SupportDiv = document.getElementById('tablescroll');
//
//        //Scroll to location of SupportDiv on load
//        window.scroll(0, findPos(SupportDiv));
//    });
//
//    function findPos(obj) {
//            var curtop = 0;
//            if (obj.offsetParent) {
//                do {
//                    curtop += obj.offsetTop;
//                } while (obj = obj.offsetParent);
//                return [curtop];
//            }
//        }
        // Xuất dạng CSV
    function exportCSV(tab) {
        if (tab === "general") {
            window.location.href = 'data:text/csv;charset=UTF-8,' + encodeURIComponent(data_export_gereral);
        } else if (tab === "details") {
            window.location.href = 'data:text/csv;charset=UTF-8,' + encodeURIComponent(data_export_details);
        }
    }

    // Xuất dữ liệu dạng Excel
    function exportExcel(tab) {
        if (tab === "general") {
            ExcellentExport.excel(document.getElementById('exportGeneral'), innerHTMLTableExportGeneral, 'Sheet Name Here');
        } else if (tab === "details") {
            ExcellentExport.excel(document.getElementById('exportDetails'), innerHTMLTableExportDetails, 'Sheet Name Here');
        }
    }

//    // BACK TO TOP
//    $(function() {
//        $(window).scroll(function() {
//            if ($(this).scrollTop() !== 0) {
//                $('#bttop').fadeIn();
//            } else {
//                $('#bttop').fadeOut();
//            }
//        });
//        $('#bttop').click(function() {
//            $('body,html').animate({
//                scrollTop: 0
//            }, 800);
//        });
//    });

