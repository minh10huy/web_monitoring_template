<?php
// Start the session
session_start();

if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: ../login.php");
    exit();
} elseif ($_SESSION['monitoring_userrole'] == 'cc') {
    header("Location: ../login.php");
    exit();
}else{
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <!--        <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">-->
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

        <title>SAIGON BPO’s Monitoring System | User Settings</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../jquery-easyui-1.4.2/themes/bootstrap/easyui.css">
        <link rel="stylesheet" type="text/css" href="../jquery-easyui-1.4.2/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="../jquery-easyui-1.4.2/themes/color.css">
        <style>
            /*            .fitem span input {
                            float:left;
                        }*/
            .fitem input {
                margin-top: 5px;
                margin-bottom: 5px;
                display:inline-block;
                *display: inline;     /* for IE7*/
                zoom:1; 
                padding-left: 10px;/* for IE7*/
                vertical-align:middle;

            }

            .fitem input[type=checkbox] {
                /* All browsers except webkit*/
                transform: scale(1.2);

                /* Webkit browsers*/
                -webkit-transform: scale(1.2);

                margin-left: 25px;
            }

            .fitem label {
                display:inline-block;
                *display: inline;      
                zoom:1;            
                float: left;
                padding-top: 5px;
                text-align: right;
                width: 80px;
            }

            .fitem .textbox {

                margin-left: 20px;
            }
            .datagrid-row-over td{
                background:#D0E5F5;
            }
            .datagrid-row-selected td{
                background:#0081c2;
            }
            .hidden {
                display : none;
            }/*
            
            .messager-window > .panel-header {
                width : 298px;
            }
            
            .messager-window > .messager-body {
                width : 298px;
            }*/
        </style>
<!--        <script src="../js/jquery.min.js"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../jquery-easyui-1.4.2/jquery.easyui.min.js"></script>


        <script>
            $(document).ready(function () {
                $('#dg').datagrid({
//                            rowStyler:function(index,row){
//                                //console.log("row :" + row.blocked);
//                                if (row.blocked == 'TRUE'){
//                                    return 'background-color:pink;color:blue;font-weight:bold;';
//                                }
//                            }
                });

            });

            var user_name = '<?php echo $_SESSION['monitoring_username']; ?>';

            function doSearch() {
                console.log("Search Called");
                $('#dg').datagrid('load', {
                    filter_value: $('#filter_id').val()
                });

            }
            ;

            $(document).ready(function () {
                $("#filter_id").keyup(function (event) {
                    console.log("search");

                    // Set Timeout
                    clearTimeout($.data(this, 'timer'));

                    // Set Search String
                    var search_string = $(this).val();

                    // Do Search
                    //    if (search_string == '') {
                    //        $("#row_data").fadeOut();
                    //        //$('h4#results-text').fadeOut();
                    //    }else{
                    //        $("#row_data").fadeIn();
                    //$('h4#results-text').fadeIn();
                    $(this).data('timer', setTimeout(doSearch, 1000));
                    //    };
                });

                //console.log("trần việt anh-ttu".substring(0, "trần".length).trim().localeCompare("trần".trim()));
                //console.log("trần việt anh-ttu".trim().indexOf("trần".trim()));
//             $("#modify_data").on("click", function(event) {
//                 console.log("test");
//                 
//                    var selectedrow = $("#dg").datagrid("getSelected");
////                    var rowIndex = $("#dg").datagrid("getData", selectedrow);
//                    console.log("selected : " + selectedrow.id);
////                    console.log("rowIndex : " + rowIndex);
//             });
                $("#parent_channel").combobox({
                    onSelect: function (record) {
                        $('#parent_channel').next().find('input').focus();
                    }
                });

                /*                     $('#im_no').numberbox({
                 decimalSeparator:'',
                 groupSeparator:''
                 }); */

            });
        </script>
        <script>
            $(document).ready(function () {
                $("#mobile_checkbox").click(function () {


                    if ($(this).is(':checked')) {
//                console.log("checked click");
                        $('#device_imei').removeClass('hidden');
                    } else {

//                console.log("unchecked click");
                        if (!$('#device_imei').hasClass('hidden'))
                            $('#device_imei').addClass('hidden');
                    }
                });
            });

            $.extend($.fn.validatebox.defaults.rules, {
                CCCheck: {
                    validator: function (value, param) {
                        return value.length > 2 && value.substring(0, 2).toLowerCase() === "cc";
//            return value.length >= param[0];
                    },
                    message: 'CC Code must start with "CC".'
                }, ParentChannelCheck: {
                    validator: function (value, param) {
                        var value = $('#parent_channel').combobox('getValue');
                        //console.log("Value :" + value);
                        //console.log("check : "  + value);
                        if (value == null || value.length == 0 || isNaN(value))
                            return false;
                        return true;
//            return value.length >= param[0];
                    },
                    message: 'This field is required.'
                }, ChannelCheck: {
                    validator: function (value, param) {

                        $('input[name=channel]').prevAll('input').focus();
                        var value = $('input[name=channel]').val();
//            console.log("Value :" + value);
                        //console.log("check : "  + value);
                        if (value != "All" && value != "DSNTB" && value != "KGK" && value != "POS-CDL" && value != "RBA" && value != "RBC" && value != "RBD" && value != "RBK" && value != "TELE-NTB" && value != "TELE-TOPUP" && value != "TTU" && value != "POS" && value != "DGT")
                            return false;

//            $('input[name=channel]').parent('span').addClass('textbox-focused');
//            $('input[name=channel]').parent('span').removeClass('textbox-invalid');
                        return true;
//            return value.length >= param[0];
                    },
                    message: 'This field is required.'
                }, CCRoleCheck: {
                    validator: function (value, param) {
                        var role = '<?php echo $_SESSION['monitoring_userrole']; ?>';
                        if (role == null || role.length == 0)
                            role = 'admin';
                        $('input[name=cc_role]').prevAll('input').focus();
                        var value = $('input[name=cc_role]').val();
                        //console.log("Value :" + value);
                        //console.log("check : "  + value);

                        if ((role == 'teamleader' && value != "teamleader" && value != "cc") || ((role == 'supervisor' || role == 'admin') && value != "supervisor" && value != "teamleader" && value != "cc"))
                            return false;

//            $('input[name=channel]').parent('span').addClass('textbox-focused');
//            $('input[name=channel]').parent('span').removeClass('textbox-invalid');
                        return true;
//            return value.length >= param[0];
                    },
                    message: 'This field is required.'
                }, ChannelExportCheck: {
                    validator: function (value, param) {

                        $('input[name=channel_ex]').prevAll('input').focus();
                        var value = $('input[name=channel_ex]').val();
//            console.log("Value :" + value);
                        //console.log("check : "  + value);
                        if (value != "All" && value != "DSNTB" && value != "KGK" && value != "POS-CDL" && value != "RBA" && value != "RBC" && value != "RBD" && value != "RBK" && value != "TELE-NTB" && value != "TELE-TOPUP" && value != "TTU" && value != "POS" && value != "DGT")
                            return false;

//            $('input[name=channel]').parent('span').addClass('textbox-focused');
//            $('input[name=channel]').parent('span').removeClass('textbox-invalid');
                        return true;
//            return value.length >= param[0];
                    },
                    message: 'This field is required.'
                }

            });

            $.extend($.fn.validatebox.defaults.rules, {
                minLength: {
                    validator: function (value, param) {
                        return value.length == param[0];
                    },
                    message: 'Please enter exact {0} numbers.'
                }
            });

            function newChannel() {
                $('#dlg').dialog('open').dialog('setTitle', 'New User');
                $('#fm').form('clear');
                url = 'save_channel.php';
            }

            function editChannel() {
                var row = $('#dg').datagrid('getSelected');
//                        if ($('#mobile_checkbox').prop('checked') == true) {
//				$('#mobile_checkbox').val('1');
//			} else {
//				$('#mobile_checkbox').val('0');
//			}
                if (row) {
//                                console.log(user_role);
                    if ((row.cc_role === "admin" || row.cc_role === "subadmin" || row.cc_role === "manager"))
                        $.messager.alert('Error', "You don't have permission to edit this user!", 'error');
                    else {
<?php if ($_SESSION['monitoring_userrole'] != "teamleader") { ?>
                            $.ajax({
                                type: "POST",
                                url: "get_combobox_channel.php",
                                data: {
                                    id: row.id
                                },
                                cache: false,
                                dataType: 'json',
                                success: function (result) {
    //                                            console.log(result.parent_channel);
                                    $('#parent_channel').combobox('setValue', result.id);
                                    $('#dlg').dialog('open').dialog('setTitle', 'Edit User');
                                    $('#fm').form('load', row);
                                    if (row.is_android == 'true') {
    //                                            console.log("checked");
                                        $('#mobile_checkbox').prop('checked', true);
    //                                            $('#device_imei').removeClass('hidden');
                                    } else {
                                        $('#mobile_checkbox').prop('checked', false);
    //                                            if (!$('#device_imei').hasClass('hidden'))
    //                                                $('#device_imei').addClass('hidden');
                                    }

                                },
                                error: function (xhr, status, error) {

    //                                           console.log("Error");
    //                                           console.log(error);

                                }
                            });
<?php } else { ?>
                            $('#dlg').dialog('open').dialog('setTitle', 'Edit User');
                            $('#fm').form('load', row);
    //                                    console.log("is_android :" + row.is_android);
                            if (row.is_android == 'true') {
    //                                        console.log("remove class");
                                $('#mobile_checkbox').prop('checked', true);
    //                                        $('#device_imei').removeClass('hidden');
                            } else {
                                $('#mobile_checkbox').prop('checked', false);
    //                                        if (!$('#device_imei').hasClass('hidden'))
    //                                            $('#device_imei').addClass('hidden');
                            }
<?php } ?>
                        url = 'update_channel.php?id=' + row.id;


                    }
                } else {
                    $.messager.alert('Error', "Please choose an user in advance.", 'error');
                }
            }

            function saveChannel() {
                $('#fm').form('submit', {
                    url: url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (result) {
                        var result = eval('(' + result + ')');
                        if (result.errorMsg) {
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $('#dlg').dialog('close');		// close the dialog
                            $('#dg').datagrid('reload');	// reload the user data
                        }
                    }
                });
            }

            function saveImei() {
                $('#fm_imei').form('submit', {
                    url: url,
                    onSubmit: function () {
                        return $(this).form('validate');
                    },
                    success: function (result) {
                        var result = eval('(' + result + ')');
                        if (result.errorMsg) {
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $('#dlg_imei').dialog('close');		// close the dialog
                            $.messager.alert('Info', "Secufity Key has been inserted successfully", 'info');
                        }
                    }
                });
            }

            function removeChannel() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    if ((row.cc_role === "admin" || row.cc_role === "subadmin" || row.cc_role === "manager"))
                        $.messager.alert('Error', "You don't have permission to delete this user!", 'error');
                    else {
                        $.messager.confirm('Confirm', 'Do you really want to delete this user ?', function (r) {
                            if (r) {
                                $.post('delete_channel.php', {id: row.id}, function (result) {
                                    if (result.success) {
                                        $('#dg').datagrid('reload');	// reload the user data
                                    } else {
                                        $.messager.show({// show error message
                                            title: 'Error',
                                            msg: result.errorMsg
                                        });
                                    }
                                }, 'json');
                            }
                        });
                    }
                } else {
                    $.messager.alert('Error', "Please choose an user in advance.", 'error');
                }
            }

            function unblockChannel() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {

                    $.messager.confirm('Confirm', 'Do you really want to unblock this user ?', function (r) {
                        if (r) {
                            $.post('unblock_channel.php', {username: row.cc_code}, function (result) {
                                if (result.success) {
                                    $.messager.alert('Info', "This user is unblocked successfully", 'info');
                                    $('#dg').datagrid('reload');

                                } else {
                                    $.messager.show({// show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                        }
                    });

                } else {
                    $.messager.alert('Error', "Please choose an user in advance.", 'error');
                }


            }

            function resetChannel() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {

                    $.messager.confirm('Confirm', 'Do you really want to reset password for this user ?', function (r) {
                        if (r) {
                            $.post('reset_pass.php', {username: row.cc_code}, function (result) {
                                if (result.success) {
                                    $.messager.alert('Info', "Password is reset successfully", 'info');
                                    $('#dg').datagrid('reload');

                                } else {
                                    $.messager.show({// show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                        }
                    });

                } else {
                    $.messager.alert('Error', "Please choose an user in advance.", 'error');
                }
            }

            function formatMobile(val, row) {
                if (val == 'true') {
                    return '<span style="color:blue;">' + val + '</span>';
                } else {
                    return val;
                }
            }

            function formatBlocked(val, row) {
                if (val == 'true') {
                    return '<span style="color:red;font-weight: bold;">' + val + '</span>';
                } else {
                    return val;
                }
            }


            function addImeiNumber() {
                $('#dlg_imei').dialog('open').dialog('setTitle', 'Add Security Key');
                $('#fm_imei').form('clear');
                url = 'save_imei.php';
            }

            function showExport() {
                $('#dlg_ex').dialog('open').dialog('setTitle', 'Export Excel');
                $('#fm_ex').form('clear');

            }

            function exportUsers() {
                getFile('exportUsers.php', $("#fm_ex").serialize());
            }

            function getFile(address, parameters) {
                if ($('#fm_ex').form('validate')) {
                    $.messager.progress({text: 'Processing. Please wait...'});
                    $.post(address,
                            parameters,
                            function (data) {
                                $.messager.progress('close');
                                if (data.empty) {
                                    $.messager.alert('Info', "There is no data to export on this channel", 'info');
                                } else if (data.link) {
                                    window.location.href = data.link;
                                    $.messager.alert('Info', "Data has been exported successfully", 'info');
                                }

                                //                                var result = eval ("(" + data + ")");
                                console.log("path : " + data.link);
                                //                                window.open(data.link,'_self');
                            }
                    , 'json');
                }
            }

        </script>    


        <script type="text/javascript" language="javascript" class="init">



        </script>
        <style>
            .logo {
                background-image: url("../img/logo.png");
                background-repeat: no-repeat;
                background-size: contain;
                display: block;
                float: left;
                font-family: 'Kaushan Script',cursive;
                font-size: 20px;
                font-weight: 500;
                height: 50px;
                line-height: 50px;
                padding: 0 10px;
                text-align: center;
                width: 220px;
            }
            body > .header {
                max-height: 100px;
                position: relative;
                z-index: 1030;
            }
            body > .header {
                left: 0;
                position: absolute;
                right: 0;
                top: 0;
                z-index: 1030;
            }
        </style>
    </head>

    <body class="dt-example">

        <div class="container">
            <section>
                <a href="../index.php" class="logo">
                    <!-- Add the class icon to your logo image or logo icon to add the margining -->
                    <!--Monitoring System-->
                </a>
                <h2 style="text-align: center;padding-right:217px;">User Management <small><a href="user_setting.php">[Refresh]</a></small></h2>
                <p style="text-align:right;">Hello, <a href="../profile.php"><?php echo $_SESSION['monitoring_username'] ?></a></p>
                <div class="dataTables_wrapper" style="width:900px; height:600px;">

                    <table id="dg" title="User Management" class="easyui-datagrid" style="width:100%;height:100%"
                           url="server_processing.php"
                           toolbar="#toolbar"
                           rownumbers="true" data-options="singleSelect:true, method:'post',queryParams:{role:'<?php
                           if (strlen($_SESSION['monitoring_userrole']) > 0)
                               echo $_SESSION['monitoring_userrole'];
                           else
                               echo "admin";
                           ?>', id:<?php echo $_SESSION['userid'] ?>}" fitColumns="true" singleSelect="true" pagination="true" pageSize="50">
                        <thead>
                            <tr>
                                <th field="cc_code" width="50" sortable="true">CC Code</th>
                                <th field="channel" width="50" sortable="true">Channel</th>
                                <th field="province" width="40" sortable="true">Province</th>
                                <th field="pos_code" width="50" sortable="true">Pos Code</th>
                                <th field="pos_name" width="50" sortable="true">Pos Name</th>
                                <th field="cc_name" width="80" sortable="true">CC Name</th>
                                <th field="cc_role" width="40" sortable="true">CC Role </th>
                                <th field="blocked" width="35" sortable="true" formatter="formatBlocked">Blocked </th>
                                <th field="is_android" width="40" sortable="true" formatter="formatMobile">Mobile App</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="toolbar">
<?php if ($_SESSION['monitoring_userrole'] != "teamleader") { ?>    
                            <a id="new_data" href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newChannel()">New</a>
                            <a id="modify_data" href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editChannel()">Edit</a>
                            <a id="delete_data" href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeChannel()">Remove</a>
                            <a id="add_imei" href="#" class="easyui-linkbutton" iconCls="icon-imei" plain="true" onclick="addImeiNumber()">Add SecurityKey</a>
                            <a id="export_excel" href="#" class="easyui-linkbutton" iconCls="icon-export" plain="true" onclick="showExport()">Export to Excel</a>

<?php } ?>   
                        <a id="unblock_data" href="#" class="easyui-linkbutton" iconCls="icon-upload" plain="true" onclick="unblockChannel()">Unblock</a>
                        <a id="reset_data" href="#" class="easyui-linkbutton" iconCls="icon-reset" plain="true" onclick="resetChannel()">Reset Password</a>
                        <span style="padding-left:20px;">Filter:</span>
                        <input id="filter_id" style="line-height:24px;border-radius: 5px;border:1px solid #ccc">
                        <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>
                    </div>
                    <!--                                <div id="pp" class="easyui-pagination" style="background:#efefef;border:1px solid #ccc;"
                                                        data-options="pageSize:50">
                                                    </div>-->
                    <div id="dlg" class="easyui-dialog" style="width:400px;height:490px;"
                         closed="true" buttons="#dlg-buttons">
                        <!--                                <div class="ftitle">Abbreviation</div>-->
                        <form id="fm" method="post" novalidate>
                            <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                                <label style="float: left;">CC Code:</label>
                                <input name="cc_code" class="easyui-textbox" data-options="required:true">
                            </div>
                            <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                                <label style="float: left;">Channel:</label>
                                <select id="combo_channel" class="easyui-combobox" name="channel" data-options="required:true,validType:'ChannelCheck'">
                                    <option value="All">All</option>
                                    <option value="DSNTB">DSNTB</option>
                                    <option value="KGK">KGK</option>
                                    <option value="POS-CDL">POS-CDL</option>
                                    <option value="RBA">RBA</option>
                                    <option value="RBC">RBC</option>
                                    <option value="RBD">RBD</option>
                                    <option value="RBK">RBK</option>
                                    <option value="TELE-NTB">TELE-NTB</option>
                                    <option value="TELE-TOPUP">TELE-TOPUP</option>
                                    <option value="TTU">TTU</option>
                                    <option value="POS">POS</option>
                                    <option value="DGT">DGT</option>

                                </select>
                            </div>
                            <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                                <label style="float: left;">Province:</label>
                                <input name="province" class="easyui-textbox" >
                            </div>
                            <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                                <label style="float: left;">Pos Code:</label>
                                <input name="pos_code" class="easyui-textbox" >
                            </div>
                            <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                                <label style="float: left;">Pos Name:</label>
                                <input name="pos_name" class="easyui-textbox" >
                            </div>
                            <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                                <label style="float: left;">CC Name:</label>
                                <input name="cc_name" class="easyui-textbox" data-options="required:true">
                            </div>                                    
                            <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                                <label style="float: left;">CC Role:</label>
                                <select class="easyui-combobox" name="cc_role"  data-options="required:true,validType:'CCRoleCheck'">
                                    <!--                                                        <option value="admin">admin</option>-->
                                    <option value="cc">cc</option>
                                    <!--                                                        <option value="subadmin">subadmin</option>-->
                                    <option value="teamleader">teamleader</option>
                                    <!--                                                        <option value="manager">manager</option>-->
                                    <?php if ($_SESSION['monitoring_userrole'] != "teamleader") { ?>
                                        <option value="supervisor">supervisor</option>
<?php } ?>

                                </select>
                            </div>

<?php if ($_SESSION['monitoring_username'] == "admin" || $_SESSION['monitoring_userrole'] == "supervisor" || $_SESSION['monitoring_userrole'] == "subadmin") { ?>

                                <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                                    <label style="float: left;">Supervisor/TL:</label>
                                    <input id="parent_channel" style="width:200px" class="easyui-combobox" name="parent_channel" required="true"
                                           data-options="valueField:'id',textField:'parent_channel',validType:'ParentChannelCheck', url:'get_parent_channel.php',filter: function(q,row){
                                           if (row.parent_channel == null) 
                                           return false;
                                           var cc_code =  row.parent_channel.toLowerCase().substring(row.parent_channel.toLowerCase().lastIndexOf('\(')+1,row.parent_channel.toLowerCase().lastIndexOf('\)'));                            
                                           if ((row.parent_channel.toLowerCase().substring(0, q.toLowerCase().length).trim().localeCompare(q.toLowerCase().trim()) == 0   || cc_code.trim().indexOf(q.toLowerCase().trim()) !== -1 )) 
                                           return true;
                                           else return false;    
                                           }"></div>
<?php } ?>                   
                            <div class="fitem" style="padding-top: 20px; padding-left: 10px; ">
                                <label style="float: left;">Mobile App:</label>
                                <input id="mobile_checkbox" name="is_android" type="checkbox" class="easyui-checkbox">
                            </div>
                            <!--                                    <div id="device_imei" class="fitem hidden" style="padding-top: 20px; padding-left: 10px;">
                                                                            <label style="float: left;">Device IMEI:</label>
                                                                            <input name="device_imei" class="easyui-textbox" >
                                                                </div>                                    -->
                        </form>
                    </div>
                    <div id="dlg-buttons">
                        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveChannel()" style="width:90px">Save</a>
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
                    </div>


                </div> 
                <!-- Add imei number for mobile -->

                <div id="dlg_imei" class="easyui-dialog" style="width:350px;height:250px;"
                     closed="true" buttons="#dlg-buttons-im">
                    <form id="fm_imei" method="post" novalidate>
                        <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                            <label style="float: left;">CC Code</label>
                            <input name="device_model" class="easyui-textbox" style="width:100px;" data-options="required:true">
                        </div>

                        <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                            <label style="float: left;">Security Key:</label>
                            <input id="im_no" name="device_imei" class="easyui-textbox" maxlength="10" data-options="required:true,validType:'minLength[10]'">
                        </div>
                        <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                            <label style="float: left;">Description:</label>
                            <input name="notes" class="easyui-textbox" >
                        </div>


                    </form>
                </div>
                <div id="dlg-buttons-im">
                    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveImei()" style="width:90px">Save</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_imei').dialog('close')" style="width:90px">Cancel</a>
                </div>

                <!-- Export excel -->
                <div id="dlg_ex" class="easyui-dialog" style="width:300px;height:150px;"
                     closed="true" buttons="#dlg-buttons-ex">
                    <form id="fm_ex" method="post" novalidate>
                        <div class="fitem" style="padding-top: 20px; padding-left: 10px;">
                            <label style="float: left;">Channel:</label>
                            <select id="combo_channel" class="easyui-combobox" name="channel_ex" data-options="required:true,validType:'ChannelExportCheck'">
                                <option value="All">All</option>
                                <option value="DSNTB">DSNTB</option>
                                <option value="KGK">KGK</option>
                                <option value="POS-CDL">POS-CDL</option>
                                <option value="RBA">RBA</option>
                                <option value="RBC">RBC</option>
                                <option value="RBD">RBD</option>
                                <option value="RBK">RBK</option>
                                <option value="TELE-NTB">TELE-NTB</option>
                                <option value="TELE-TOPUP">TELE-TOPUP</option>
                                <option value="TTU">TTU</option>
                                <option value="POS">POS</option>
                                <option value="DGT">DGT</option>

                            </select>
                        </div>

                    </form>
                </div>
                <div id="dlg-buttons-ex">
                    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="exportUsers()" style="width:120px">Export to Excel</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_ex').dialog('close')" style="width:90px">Cancel</a>
                </div>
            </section>
        </div>
    </body>
</html>
<?php }