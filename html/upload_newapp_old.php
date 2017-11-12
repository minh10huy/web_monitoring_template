<?php
header("Content-Type: text/html;charset=UTF-8");
// Start the session
session_start();
?>
<?php
require_once 'lib/dao/VPBankDAO.php';
$vpBank = new VPBankDAO();
$ccChannel = $_SESSION['monitoring_userchannel'];
$ccCode = $_SESSION['monitoring_username'];
$upType = "HOSOMOI";
$newApp = 'HOSOMOI';
$QDE = 'HOSOBOSUNG';
$product_type;
$sub_type;
$userrole = $_SESSION['monitoring_userrole'];
$date = date("Y-m-d") . " " . "00:00:00";
$uploadPerDay = $vpBank->countUploadPerDay($ccCode, $date, "newapp");
//$uploadPerDay = intval($uploadPerDay[0]);
$uploadPerDay = (int) $uploadPerDay[0] + 1;
//echo $uploadPerDay;die;


if (isset($_POST['uploadNewApp'])) {
    if ($ccCode === "") {
        ?>
        <script>
            window.location = "login.php";</script>
        <?php
    } else {
        $target_path = "uploads/";
        if (!is_dir($target_path . $newApp)) {
            mkdir($target_path . $newApp);
        }
        if (!is_dir($target_path . $QDE)) {
            mkdir($target_path . $QDE);
        }
        if (!is_dir($target_path . $newApp . '/' . $ccChannel)) {
            mkdir($target_path . $newApp . '/' . $ccChannel);
        }
        if (!is_dir($target_path . $QDE . '/' . $ccChannel)) {
            mkdir($target_path . $QDE . '/' . $ccChannel);
        }

        if (!is_dir($target_path . $newApp . '/' . $ccChannel . '/' . $ccCode)) {
            mkdir($target_path . $newApp . '/' . $ccChannel . '/' . $ccCode);
        }
        if (!is_dir($target_path . $QDE . '/' . $ccChannel . '/' . $ccCode)) {
            mkdir($target_path . $QDE . '/' . $ccChannel . '/' . $ccCode);
        }
        if (basename($_FILES['uploadFile']['name']) != null && basename($_FILES['uploadFile']['name']) != "") {
            //echo($target_path . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . $_FILES['uploadFile']['tmp_name']);die;
            try {
                //throw exception if can't move the file
                if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target_path . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . basename($_FILES['uploadFile']['name']))) {
                    echo( "<script type='text/javascript'> alert('Can not upload file. Please contact admin system!'); </script> ");
                    throw new Exception('Could not move file');
                } else {
                    $vpBank->insertUploadInfo($ccCode, $_FILES['uploadFile']['name'], $upType, $ip);
                    echo( "<script type='text/javascript'> alert('The file has been uploaded'); window.location = document.URL; </script> ");
                }
//
//        echo "The file " . basename($_FILES['uploadFile']['name']) .
//        " has been uploaded";
            } catch (Exception $e) {
                die('File did not upload: ' . $e->getMessage());
            }
        }
    }
}
?>

<?php
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    header("Location: login.php");
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
            <title>UPLOAD NEWAPP</title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
            <!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
            <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <!--<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
            <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

            <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />      
            <style>
                /*BACK TO TOP*/
                #bttop{border:1px solid #4adcff;background:#24bde2;text-align:center;padding:5px;position:fixed;bottom:35px;right:10px;cursor:pointer;display:none;color:#fff;font-size:11px;font-weight:900;}
                #bttop:hover{border:1px solid #ffa789;background:#ff6734;}
                /**/
            </style>
            <style type="text/css">  
                .muform {
                    display: flex;
                    flex-direction: row;
                    flex-wrap: wrap;
                    justify-content: center;
                    align-items: center;
                }
            </style>            
            <style type="text/css">
                .form-style-10{
                    width:450px;
                    padding:0px;
                    margin: auto;
                    background: #FFF;
                    border-radius: 10px;
                    -webkit-border-radius:10px;
                    -moz-border-radius: 10px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
                    -moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
                    -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
                }
                .form-style-10 .inner-wrap{
                    padding: 30px;
                    background: #F8F8F8;
                    border-radius: 6px;
                    margin-bottom: 0px;
                }
                .form-style-10 h1{
                    background: #2A88AD;
                    padding: 20px 30px 15px 30px;
                    margin: -30px -30px 30px -30px;
                    border-radius: 10px 10px 0 0;
                    -webkit-border-radius: 10px 10px 0 0;
                    -moz-border-radius: 10px 10px 0 0;
                    color: #fff;
                    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
                    font: normal 30px 'Bitter', serif;
                    -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                    -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                    box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                    border: 1px solid #257C9E;
                }
                .form-style-10 h1 > span{
                    display: block;
                    margin-top: 2px;
                    font: 13px Arial, Helvetica, sans-serif;
                }
                .form-style-10 label{
                    display: block;
                    font: 13px Arial, Helvetica, sans-serif;
                    color: #888;
                    margin-bottom: 15px;
                }
                .form-style-10 input[type="text"],
                .form-style-10 input[type="date"],
                .form-style-10 input[type="datetime"],
                .form-style-10 input[type="email"],
                .form-style-10 input[type="number"],
                .form-style-10 input[type="search"],
                .form-style-10 input[type="time"],
                .form-style-10 input[type="url"],
                .form-style-10 input[type="password"],
                .form-style-10 textarea,
                .form-style-10 select {
                    display: block;
                    box-sizing: border-box;
                    -webkit-box-sizing: border-box;
                    -moz-box-sizing: border-box;
                    width: 100%;
                    padding: 8px;
                    border-radius: 6px;
                    -webkit-border-radius:6px;
                    -moz-border-radius:6px;
                    border: 2px solid #ccc;
                    box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
                    -moz-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
                    -webkit-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
                }

                .form-style-10 .section{
                    font: normal 20px 'Bitter', serif;
                    color: #F9A11B;
                    margin-bottom: 0px;
                }
                .form-style-10 .section span {
                    background: #F9A11B;
                    padding: 5px 10px 5px 10px;
                    position: absolute;
                    border-radius: 50%;
                    -webkit-border-radius: 50%;
                    -moz-border-radius: 50%;
                    border: 4px solid #fff;
                    font-size: 14px;
                    margin-left: -45px;
                    color: #fff;
                    margin-top: -3px;
                }
                .form-style-10 input[type="button"],
                .form-style-10 input[type="submit"]{
                    background: #2A88AD;
                    padding: 8px 20px 8px 20px;
                    border-radius: 5px;
                    -webkit-border-radius: 5px;
                    -moz-border-radius: 5px;
                    color: #fff;
                    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
                    font: normal 30px 'Bitter', serif;
                    -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                    -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                    box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
                    border: 1px solid #257C9E;
                    font-size: 15px;
                }
                .form-style-10 input[type="button"]:hover,
                .form-style-10 input[type="submit"]:hover{
                    background: #2A6881;
                    -moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
                    -webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
                    box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
                }
                .form-style-10 .privacy-policy{
                    float: right;
                    width: 250px;
                    font: 12px Arial, Helvetica, sans-serif;
                    color: #4D4D4D;
                    margin-top: 10px;
                    text-align: right;
                }
            </style>  
            <style type="text/css">
                #myInstance1 {
                    border: 2px dashed #0000ff;
                    min-height: 100px;
                }
                .nicEdit-selected {
                    border: 2px solid #0000ff !important;
                }

                .nicEdit-panel {
                    background-color: #fff !important;
                }

                .nicEdit-button {
                    background-color: #fff !important;
                }
            </style>            

        </head>
        <body class="skin-blue" style="min-height:100%;" onload="StartTimers();" onmousemove="ResetTimers();">
            <!-- header logo: style can be found in header.less -->
            <header class="header">
                <a href="index.php" class="logo">
                    <!-- Add the class icon to your logo image or logo icon to add the margining -->
                    <!--Monitoring System-->
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <div class="navbar-center">
                        <ul class="sidebar-menu">
                            <li>
                                <a href="index.php">
                                    <i class="fa fa-dashboard"></i> <span> Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="listqde.php">
                                    <i class="fa fa-dashboard"></i> <span>QDE History</span>
                                </a>
                            </li>     
<!--                            <li>
                                <a href="listticket.php">
                                    <i class="fa fa-dashboard"></i> <span>My Ticket</span>
                                </a>
                            </li>-->
                            <li class="active">
                                <a href="upload_newapp.php">
                                    <i class="fa fa-dashboard"></i> <span>Upload New App</span>
                                </a>
                            </li>                           
                            <?php if ($userrole != 'cc') { ?>
                                <li>
                                    <a href="UserSetting/user_setting.php">
                                        <i class="fa fa-dashboard"></i> <span>User Settings</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($userrole == 'admin' || $userrole == 'subadmin') { ?>
                                <li>
                                    <a href="report/report_tat.php">
                                        <i class="fa fa-dashboard"></i> <span>Report TAT</span>
                                    </a>
                                </li>                           
                            <?php } ?> 
                        </ul>                        
                    </div>
                    <div class="navbar-right">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <span><?php echo $_SESSION['monitoring_username']; ?> <i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header bg-green">
                                        <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo $_SESSION['monitoring_username']; ?>
                                            <small></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="wrapper row-offcanvas row-offcanvas-left">
                <!-- Left side column. contains the logo and sidebar -->

                <!-- Right side column. Contains the navbar and content of the page -->
                <aside class="right-side">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">

                        <ol class="breadcrumb">
                            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                            <!--<li class="active">Dashboard</li>-->
                        </ol>                            
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <!-- Main row -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <div class="tab-content">
                                    <div class = "tab-pane active" id = "tab_qde">
                                        <div class = "muform">
                                            <table style="width: 900px; margin: 0px auto 50px auto; border: 1px #ccc solid; background: #fff; font-size: 11px; font-family: verdana, sans-serif;" align="center">
                                                <tbody>
                                                    <tr style="padding: 10px;">
                                                        <td style="width: 900px; padding: 15px 0px 25px 25px; vertical-align: top;">
                                                            <div class = "form-style-10" style="width: 800px">
                                                                <form id="adeForm" enctype = "multipart/form-data" action = "upload_newapp.php" method = "POST"> <!--onsubmit = "return validateNewApp()"-->
                                                                    <div id="step1">
                                                                        <div class="section"><span>1</span>Choose File</div>
                                                                        <div class="inner-wrap">                                                                                                                                                      
                                                                            <input name="uploadFile" id="uploadFile" type="file" accept=".zip"/>   
                                                                            <div id="error_block" class="alert alert-danger hidden">
                                                                                You will need a recent browser to use this function :(
                                                                            </div>

                                                                            <div id="result_block" class="hidden">
                                                                                <div id="result"></div>
                                                                            </div>                                                                           
                                                                        </div>                                                                        
                                                                    </div>
                                                                    <div id="step2" hidden="true">
                                                                        <div class="section" ><span>2</span>Upload</div>
                                                                        <div class="inner-wrap">  
                                                                            <div class="button-section">
                                                                                <input type="submit" id="uploadNewApp" class="bg-saigonbpo" name="uploadNewApp" value="Upload New App"/> 
                                                                            </div>                                                                            
                                                                        </div>
                                                                    </div>
                                                                </form>       
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>                                      
                                </div>                                                                
                            </div><!-- /.col -->
                        </div>

                        <div class="row">
                            <div id='bttop'>BACK TO TOP ^</div>
                        </div>
                    </section><!-- /.content -->
                </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->


            <!--[if lt IE 9]>
                <script src="js/jquery-1.11.2.min.js"></script>
            <![endif]-->
            <!--[if gte IE 9]>
                <script src="js/jquery-1.11.2.min.js"></script>
            <!--<![endif]-->

            <script src="js/jquery-1.11.2.min.js"></script>
            <script src="js/bootstrap.min.js"></script>            

            <!-- AdminLTE App -->
            <script src="js/AdminLTE/app.js" type="text/javascript"></script>

            <!-- AdminLTE for demo purposes -->
            <script src="js/AdminLTE/demo.js" type="text/javascript"></script>
            <script type="text/javascript" src="ziplib/dist/jszip.js"></script>
            <script src="js/timeout.js" type="text/javascript"></script>
            <script src="js/moment.js" type="text/javascript"></script>

            <script>
            var username = '<?php echo $_SESSION['monitoring_username']; ?>';
            //                $(document).ready(function () {
            //                    setInterval(function () {
            //                        // Update active time every 5 minutes
            //                        $.ajax({
            //                            type: "POST",
            //                            url: "updateActiveTime.php",
            //                            async: true,
            //                            data: {
            //                                username: username
            //                            },
            //                            cache: false,
            //                            success: function (result) {
            //
            //                            },
            //                            error: function (xhr, status, error) {
            //
            //                                console.log("Error");
            //                                console.log(error);
            //
            //                            }
            //                        }); //ajax
            //                    }, 1000 * 60 * 5); // where X is your every 5 minutes
            //                });            
            (function () {
                
                if (!window.FileReader || !window.ArrayBuffer) {
                    $("#error_block").removeClass("hidden").addClass("show");                    
                    return;
                }

                $("#uploadFile").on("change", function (evt) {
                    $("#step2").show();
                    var username = <?php echo json_encode($_SESSION ['monitoring_username']); ?>;
                    var user_channel = <?php echo json_encode($_SESSION ['monitoring_userchannel']); ?>;
                    var uploadTime = <?php echo json_encode($uploadPerDay); ?>;
                    var currentDate = moment(new Date()).format('YYYYMMDD');
                    var $title;
                    var $fileContent;
                    var $result = $("#result");
                    $result.html("");
                    // be sure to show the results
                    $("#result_block").removeClass("hidden").addClass("show");
                    // Closure to capture the file information.

                    function handleFile(f) {
                        //                        $title = $("<h4>", {
                        //                            text: f.name
                        //                        });
                        $fileContent = $("<ul>");
                        $result.append($title);
                        $result.append($fileContent);
                        validate_zipName(f.name, 'zip');
                        read_zipname(f);
                    }

                    function validate_zipName(zipname, type) {
                        var zipnameArray = zipname.split("_");
                        var totalError = 0;
                        if (zipnameArray.length === 3) {
                            var ccCode = zipnameArray[0];
                            var yyyymmdd = zipnameArray[1];
                            var upTime = zipnameArray[2];
                            if (type === 'zip') {
                                $fileContent.append($("<li>", {
                                    text: 'Validating zip name ...'
                                }));
                            } else {
                                $fileContent.append($("<li>", {
                                    text: 'Validating root folder name ...'
                                }));
                            }
                            if (username !== ccCode) {
                                $fileContent.append($("<li>", {
                                    text: 'Your ID: Not OK, must be ' + '"' + username + '"'
                                }));
                                totalError++;
                            }
                            if (!yyyymmdd.match(/^\+?(0|[1-9]\d*)$/) || !(yyyymmdd.length == 8)) {
                                $fileContent.append($("<li>", {
                                    text: 'upload date must be NUMERIC and follow rule yyyymmdd (ex: 20150505)'
                                }));
                                totalError++;
                            }
                            if (yyyymmdd !== currentDate) {
                                $fileContent.append($("<li>", {
                                    text: 'current date must be ' + '"' + currentDate + '"'
                                }));
                                totalError++;
                            }
                            if (parseInt(upTime) !== parseInt(uploadTime) && parseInt("10", upTime) !== parseInt("10", uploadTime)) {
                                $fileContent.append($("<li>", {
                                    text: 'the real number of your upload per day is\"' + uploadTime + '\"'
                                }));
                                totalError++;
                            }
                        } else {
                            if (type === 'zip') {
                                $fileContent.append($("<li>", {
                                    text: '"' + zipname + ' :"' + 'Zip name do not follow rule \"YOUR ID_YYYYMMDD_TIME UP PER DAY\" '
                                }));
                                totalError++;
                            } else {
                                $fileContent.append($("<li>", {
                                    text: '"' + zipname + ' :"' + 'Root folder name do not follow rule \"YOUR ID_YYYYMMDD_TIME UP PER DAY\" '
                                }));
                                totalError++;
                            }
                        }
                        if (totalError > 0) {
                            $("#step2").hide();
                        } else {
                            $fileContent.append($("<li>", {
                                text: 'OK'
                            }));
                        }
                    }

                    function read_zipname(f) {
                        //var dateBefore = new Date();
                        var folderArray = new Array();
                        JSZip.loadAsync(f)
                                .then(function (zip) {
                                    //                                    var dateAfter = new Date();
                                    //                                    $title.append($("<span>", {
                                    //                                        text: " (loaded in " + (dateAfter - dateBefore) + "ms)"
                                    //                                    }));
                                    var totalError = 0;
                                    zip.forEach(function (relativePath, zipEntry) {
                                        var tempName = relativePath.toUpperCase();
                                        if (relativePath.indexOf(".") <= 0) {
                                            folderArray.push(relativePath);
                                        } else if (!(tempName.split('.').pop() === ("PDF")) && !(tempName.split('.').pop() === ("JPG")) && tempName.indexOf("THUMBS") <= 0) {
                                            $fileContent.append($("<li>", {
                                                text: '"' + zipEntry.name + '"' + ' cannot upload to server'
                                            }));
                                            $("#step2").hide();
                                        }
                                    });
                                    if (folderArray.length === 0) {
                                        $fileContent.append($("<li>", {
                                            text: 'Folder structure do not follow the rule'
                                        }));
                                        $("#step2").hide();
                                        return;
                                    }
                                    for (var i = 0; i < folderArray.length; i++) {
                                        var temp = folderArray[i];
                                        var tempName = temp.split("/");
                                        if (tempName.length === 2) {
                                            validate_zipName(tempName[0], 'folder');
                                        } else if (tempName.length === 3) {
                                            validate_subfolder(tempName[1], f);
                                        } else {
                                            $fileContent.append($("<li>", {
                                                text: '"' + temp + ' :"' + 'Zip name do not follow the rule.'
                                            }));
                                            totalError++;
                                        }
                                    }
                                    if (totalError > 0) {
                                        $("#step2").hide();
                                    }
                                }, function (e) {
                                    $fileContent = $("<div>", {
                                        "class": "alert alert-danger",
                                        text: "Error reading " + f.name + " : " + e.message
                                    });
                                });
                    }

                    function validate_subfolder(subFolderName, f) {
                        $fileContent.append($("<li>", {
                            text: 'Validating folder: "' + subFolderName + '" ...'
                        }));
                        var totalError = 0;
                        var sub_folder_name = subFolderName.split("_");
                        if (sub_folder_name.length === 3) {
                            var cus_name = sub_folder_name[0];
                            var cus_id = sub_folder_name[1];
                            var channel = sub_folder_name[2];
                            if (cus_name !== cus_name.toUpperCase()) {
                                $fileContent.append($("<li>", {
                                    text: 'name of customer must be UPERCASE '
                                }));
                                totalError++;
                            }
                            if (!cus_id.match(/^\+?(0|[0-9]\d*)$/) || ((cus_id.length !== 9) && (cus_id.length !== 8) && (cus_id.length !== 12))) {
                                $fileContent.append($("<li>", {
                                    text: 'customer ID must be NUMERIC and 8||9||12 character '
                                }));
                                totalError++;
                            }
                            if (channel !== user_channel) {
                                $fileContent.append($("<li>", {
                                    text: 'your channel must be: ' + '"' + user_channel + '"'
                                }));
                                totalError++;
                            }
                            validate_subfolder_file(subFolderName, f);
                        } else {
                            $fileContent.append($("<li>", {
                                text: '"' + subFolderName + '"' + 'do not follow rule \"CUSTOMER NAME_CUSTOMER ID_CHANNEL\"'
                            }));
                            totalError++;
                        }
                        if (totalError > 0) {
                            $("#step2").hide();
                        } else {
                            $fileContent.append($("<li>", {
                                text: 'OK'
                            }));
                        }
                    }

                    function validate_subfolder_file(subFolderName, f) {
                        JSZip.loadAsync(f)
                                .then(function (zip) {
                                    var checkDN = false;
                                    var checkHK = false;
                                    var checkID = false;
                                    var totalError = 0;
                                    zip.forEach(function (relativePath, zipEntry) {
                                        if (relativePath.indexOf(subFolderName) > 0 && relativePath.indexOf(".") > 0) {
                                            if (relativePath.split('.').pop() === ("pdf") || relativePath.split('.').pop() === ("jpg") || relativePath.split('.').pop() === ("PDF") || relativePath.split('.').pop() === ("JPG") || rerelativePath.indexOf("thumbs") > 0 || rerelativePath.indexOf("THUMBS") > 0) {
                                                if (zipEntry._data.uncompressedSize > 15000000) {
                                                    $fileContent.append($("<li>", {
                                                        text: '"' + zipEntry.name + '" ' + 'large than 15Mb'
                                                    }));
                                                    totalError++;
                                                }
                                                var temp_uppercase = relativePath.toUpperCase();
                                                if (temp_uppercase.indexOf("DN.PDF") > 0) {
                                                    checkDN = true;
                                                }
                                                if (temp_uppercase.indexOf("HK.PDF") > 0) {
                                                    checkHK = true;
                                                }
                                                if (temp_uppercase.indexOf("ID.PDF") > 0) {
                                                    checkID = true;
                                                }
                                            } else {
                                                $fileContent.append($("<li>", {
                                                    text: '"' + zipEntry.name + '"' + 'cannot upload to server'
                                                }));
                                                totalError++;
                                            }
                                        } else {

                                        }
                                    });
                                    if (!checkDN) {
                                        $fileContent.append($("<li>", {
                                            text: 'Folder: \"' + subFolderName + '\"' + '  missing file: DN , '
                                        }));
                                        totalError++;
                                    }
                                    if (!checkHK) {
                                        $fileContent.append($("<li>", {
                                            text: 'Folder: \"' + subFolderName + '\"' + '  missing file: HK , '
                                        }));
                                        totalError++;
                                    }
                                    if (!checkID) {
                                        $fileContent.append($("<li>", {
                                            text: 'Folder: \"' + subFolderName + '\"' + '  missing file: ID , '
                                        }));
                                        totalError++;
                                    }
                                    if (totalError > 0) {
                                        $("#step2").hide();
                                    }
                                }, function (e) {
                                    $fileContent = $("<div>", {
                                        "class": "alert alert-danger",
                                        text: "Error reading " + f.name + " : " + e.message
                                    });
                                });
                    }

                    var files = evt.target.files;                    
                    for (var i = 0, f; f = files[i]; i++) {                
                        if (f.name.toUpperCase().split('.').pop() === 'ZIP') {                                                        
                            handleFile(f);
                        } else {
                            $("#step2").hide();
                            alert(f.name + ' is not ZIP file, can not upload this file.');
                            window.location = document.URL;
                        }
                    }

                });
            })();
            // BACK TO TOP
            $(function () {
                $(window).scroll(function () {
                    if ($(this).scrollTop() !== 0) {
                        $('#bttop').fadeIn();
                    } else {
                        $('#bttop').fadeOut();
                    }
                });
                $('#bttop').click(function () {
                    $('body,html').animate({scrollTop: 0}, 800);
                });
            });
            //If window is small enough, enable sidebar push menu
            if ($(window).width() <= 1500) {
                $('.row-offcanvas').toggleClass('active');
                $('.left-side').removeClass("collapse-left");
                $(".right-side").removeClass("strech");
                $('.row-offcanvas').toggleClass("relative");
            } else {
                //Else, enable content streching
                $('.left-side').toggleClass("collapse-left");
                $(".right-side").toggleClass("strech");
            }
            </script>
        </body>
    </html>
    <?php
}
?>