$(function () {

    //ajax mocks
    $.mockjaxSettings.responseTime = 500;

    $.mockjax({
        url: '/post',
        response: function (settings) {
            log(settings, this);
        }
    });

    $.mockjax({
        url: '/error',
        status: 400,
        statusText: 'Bad Request',
        response: function (settings) {
            this.responseText = 'Please input correct value';
            log(settings, this);
        }
    });

    $.mockjax({
        url: '/status',
        status: 500,
        response: function (settings) {
            this.responseText = 'Internal Server Error';
            log(settings, this);
        }
    });

    $.mockjax({
        url: '/groups',
        response: function (settings) {
            this.responseText = [
                {value: 0, text: 'Guest'},
                {value: 1, text: 'Service'},
                {value: 2, text: 'Customer'},
                {value: 3, text: 'Operator'},
                {value: 4, text: 'Support'},
                {value: 5, text: 'Admin'}
            ];
            log(settings, this);
        }
    });

    function log(settings, response) {
        var s = [], str;
        s.push(settings.type.toUpperCase() + ' url = "' + settings.url + '"');
        for (var a in settings.data) {
            if (settings.data[a] && typeof settings.data[a] === 'object') {
                str = [];
                for (var j in settings.data[a]) {
                    str.push(j + ': "' + settings.data[a][j] + '"');
                }
                str = '{ ' + str.join(', ') + ' }';
            } else {
                str = '"' + settings.data[a] + '"';
            }
            s.push(a + ' = ' + str);
        }
        s.push('RESPONSE: status = ' + response.status);

        if (response.responseText) {
            if ($.isArray(response.responseText)) {
                s.push('[');
                $.each(response.responseText, function (i, v) {
                    s.push('{value: ' + v.value + ', text: "' + v.text + '"}');
                });
                s.push(']');
            } else {
                s.push($.trim(response.responseText));
            }
        }
        s.push('--------------------------------------\n');
        $('#console').val(s.join('\n') + $('#console').val());
    }


    //defaults
    $.fn.editable.defaults.url = '/post';

    //enable / disable
    $('#enable').click(function () {
        $('#customers_info .editable').editable('toggleDisabled');
    });

    //editables 
    $('#code_tsa').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'code_tsa'
    });
    $('#name_tsa').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'name_tsa'
    });
    $('#sodienthoai_tsa').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'sodienthoai_tsa'
    });

    $('#product_name_1').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'product_name_1'
    });
    $('#product_code_1').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'product_code_1'
    });

    $('#sotienvay').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'sotienvay'
    });
    $('#thoihanvay').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'thoihanvay'
    });

    $('#baohiem_vay').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'baohiem_vay'
    });
    $('#date_of_closure').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'date_of_closure'
    });

    $('#kenh_giai_ngan').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'kenh_giai_ngan'
    });
    $('#branch_code').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'branch_code'
    });

    $('#description').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'description'
    });
    $('#sdt_thamchieu1').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'sdt_thamchieu1'
    });

    $('#sdt_thamchieu2').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'sdt_thamchieu2'
    });
    $('#thongtin_vochong').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'thongtin_vochong'
    });

    $('#cc_code').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'cc_code'
    });
    $('#cc_name').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'cc_name'
    });

    $('#code_dsa').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'code_dsa'
    });
    $('#name_dsa').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'name_dsa'
    });

    $('#tenkhachhang').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'tenkhachhang'
    });
    $('#so_id_cu').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'so_id_cu'
    });
    $('#so_cmnd').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'so_cmnd'
    });

    $('#ngaycap_cmnd').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'ngaycap_cmnd'
    });

    $('#name_dsa').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'name_dsa'
    });

    $('#noicap_cmnd').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'noicap_cmnd'
    });
    $('#sdt_kh_bsung').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'sdt_kh_bsung'
    });
    $('#dia_chi_thuong_tru').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'dia_chi_thuong_tru'
    });

    $('#dia_chi_tam_tru').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'dia_chi_tam_tru'
    });
    $('#thunhap_kh_bsung').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'thunhap_kh_bsung'
    });
    $('#chiphi_kh_bsung').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'chiphi_kh_bsung'
    });
    $('#monthly_income_family').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'monthly_income_family'
    });

    $('#monthly_costs_family').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'monthly_costs_family'
    });
    $('#no_modified_fields').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'no_modified_fields'
    });

    $('#modified_fields').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'modified_fields'
    });

    $('#product_name').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'product_name'
    });
    $('#product_code').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'product_code'
    });
    $('#offered_credit_limit').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'offered_credit_limit'
    });
    $('#embossing_name').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'embossing_name'
    });    
    $('#mailing_address').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'mailing_address'
    });
    $('#answer_for_security_question').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'answer_for_security_question'
    });
    $('#customers_info.editable').on('hidden', function (e, reason) {
        if (reason === 'save' || reason === 'nochange') {
            var $next = $(this).closest('tr').next().find('.editable');
            if ($('#autoopen').is(':checked')) {
                setTimeout(function () {
                    $next.editable('show');
                }, 300);
            } else {
                $next.focus();
            }
        }
    });

    $('#save_data').click(function () {
        $elems = $('.topupEditable');
        data = $elems.editable('getValue');
        console.log(data);
//        $.ajax({
//            type: "POST",
//            url: "updateTopupData.php",
//            data: data,
//            cache: false,
//            dataType: 'json',
//            success: function (result) {
//
//            },
//            error: function (xhr, status, error) {
//                
//            }
//        });
    });

});