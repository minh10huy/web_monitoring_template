$(document).ready(function () {
    $("#customerForm :input").prop("disabled", true);
});
$(document).ready(function () {
    $("#customerForm :input").prop("disabled", true);
    $("#save_topup").prop("disabled", true);
});

$('.nav-tabs li:eq(1) a').click(function () {
    console.log('right');
            var mana_id =  $("#management_id").val();
            $("#file_catgory").load('appfile.php', {mana_id: mana_id});
});