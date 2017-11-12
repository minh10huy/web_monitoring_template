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


$(document).ready(function () {
    $("#customerForm :input").prop("disabled", true);
    $("#save_topup").prop("disabled", true);
});
$('#edit_topup').click(function () {
    $("#customerForm :input").prop("disabled", false);
    $("#save_topup").prop("disabled", false);
    $("#code_tsa").prop("disabled", true);
});
$('#save_topup').click(function () {
    waitingDialog.show('Đang xử lý...');
    var data = $("#customerForm").serialize();

    $.ajax({
        type: "POST",
        url: "save_topup.php",
        cache: false,
        data: data,
        success: function (result) {
            waitingDialog.hide();
            alert(result);
            window.location.reload(true);
        },
        error: function (xhr, status, error) {
            waitingDialog.hide();
            alert("Failed!");
        }
    });
});
$('#save_qde').click(function () {
    if ($("#qde_content").val() !== "") {        
        $("#qdeForm").submit(function (event) {
            waitingDialog.show('Đang xử lý...');
            var data = $("#qdeForm").serialize();
            $.ajax({
                type: "POST",
                url: "save_qde.php",
                cache: false,
                data: data,
                success: function (result) {
                    waitingDialog.hide();
                    alert(result);
                    window.location.reload(true);
                },
                error: function (xhr, status, error) {
                    waitingDialog.hide();
                    alert("Failed!");
                }
            });
            event.preventDefault();
        });
    } else {
        alert("Vui lòng nhập nội dung QDE!");
        return false;
    }
});
$('#thunhap_kh_bsung').priceFormat({
    prefix: '',
    limit: 10,
    centsLimit: 0,
    thousandsSeparator: '.'
});
$('#monthly_income_family').priceFormat({
    prefix: '',
    limit: 10,
    centsLimit: 0,
    thousandsSeparator: '.'
});
$('#chiphi_kh_bsung').priceFormat({
    prefix: '',
    limit: 10,
    centsLimit: 0,
    thousandsSeparator: '.'
});
$('#monthly_costs_family').priceFormat({
    prefix: '',
    limit: 10,
    centsLimit: 0,
    thousandsSeparator: '.'
});
$('#sotienvay').priceFormat({
    prefix: '',
    limit: 10,
    centsLimit: 0,
    thousandsSeparator: '.'
});