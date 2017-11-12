<?php
header("Content-Type: text/html;charset=UTF-8");
session_start();

//if ($_POST['mana_id'] === NULL) {
//    die("Problems? Did you perchance attempt to reload the page and resubmit?");
//}

require_once 'lib/dao/VPBankDAO.php';
$vpBank = new VPBankDAO();
$mana_id = $_POST['mana_id'];
$appfile = $vpBank->getAppFileNTB($mana_id);
?>
<link rel="stylesheet" href="plugins/bootstrap-table/bootstrap-table.css">
<!DOCTYPE html>
<div class="row">
    <div class="box box-primary">
        <table id="filetable" data-click-to-select="true" data-single-select="true">
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="id" data-align="center">ID</th>
                    <th data-field="filename" data-align="left">Tên File</th>
                    <th data-field="upload_time" data-align="left">Thời gian upload</th>
                    <th data-field="filepath" data-align="left">Đường dẫn</th>
                </tr>
            </thead>
        </table>    

        <div class="box box-info">
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">                    
                            <button id="viewpdf" class="btn btn-info" type="button"><i class="fa  fa-plus-square-o"></i>Xem File</button>
                        </div>
                    </div>            
                    <div class="col-md-3">
                        <div class="form-group">                    
                            <button id="add-more" class="btn btn-info" type="button"><i class="fa  fa-plus-square-o"></i>Thêm</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">                    
                            <button id="delete" class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i>Xóa</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">                    
                            <button id="update" class="btn btn-warning" type="button"><i class="fa fa-refresh"></i>Cập nhật</button>
                        </div>
                    </div> 
                </div>
            </div>
        </div>    
    </div>
</div>
<script src="plugins/bootstrap-table/bootstrap-table.js"></script>
<script>
    $(document).ready(function () {
        var $table = $('#filetable');
        var data = <?php echo json_encode($appfile) ?>;
        $table.bootstrapTable({
            data: data
        });
        $table.bootstrapTable('hideColumn', 'filepath');
//        $table.bootstrapTable('hideColumn', 'id');
        $table.bootstrapTable('hideColumn', 'upload_time');
    });
    var arr;
    $('#viewpdf').click(function () {
        var mana_id = $('#filetable').find('[type="checkbox"]:checked').map(function () {
            return $(this).closest('tr').find('td:nth-child(2)').text();
        }).get();
        $.ajax({
            url: 'content_pages/dataPost.php',
            type: 'POST',
            data: {mana_id: mana_id},
            success: function (data) {
                window.open('viewpdf.php');
            },
            async: false
        });
        //window.open('viewpdf.php?file=' + arr);
    });
    $('#add-more').click(function () {
        var arr = $('#filetable').find('[type="checkbox"]:checked').map(function () {
            return $(this).closest('tr').find('td:nth-child(5)').text();
        }).get();
        console.log(arr);
        alert('Version test không thực hiện được chức năng này');
    });
    $('#delete').click(function () {
        var arr = $('#filetable').find('[type="checkbox"]:checked').map(function () {
            return $(this).closest('tr').find('td:nth-child(3)').text();
        }).get();
        alert('Version test không thực hiện được chức năng này');
    });
    $('#update').click(function () {
        var arr = $('#filetable').find('[type="checkbox"]:checked').map(function () {
            return $(this).closest('tr').find('td:nth-child(3)').text();
        }).get();
        alert('Version test không thực hiện được chức năng này');
    });
</script>