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
$upType = "HOSOBOSUNG";
$newApp = 'HOSOMOI';
$QDE = 'HOSOBOSUNG';
$product_type;
$sub_type;
if (isset($_GET['idF1'])) {
    $idF1 = $_GET['idF1'];
    $_SESSION['idF1'] = $idF1;
    $cus_id = $_GET['cus_id'];
    $_SESSION['cus_id'] = $cus_id;
    $cus_name = $_GET['cus_name'];
    $cus_name = str_replace('_', ' ', $cus_name);
    $_SESSION['cus_name'] = $cus_name;
    $product_type = $_GET['prod_type'];
    $_SESSION['prod_type'] = $product_type;
    $sub_type = $_GET['sub_type'];
    $date = date("Y-m-d") . " " . "00:00:00";
    $uploadPerDay = $vpBank->countUploadPerDay($ccCode, $date, $upType);
    $ticketList = $vpBank->getListTicketByID($idF1);
    //$uploadPerDay = intval($uploadPerDay[0]);
    $uploadPerDay = (int) $uploadPerDay[0] + 1;
    //echo $uploadPerDay;die;
    //var_dump($uploadPerDay);die; 
}

if (isset($_POST['uploadQDE'])) {
    if ($ccCode === "") {
        ?>
        <script>
            window.location = "login.php";
        </script>
        <?php
    } else if ($_SESSION['idF1'] != NULL) {
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
            try {
                //throw exception if can't move the file
                if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target_path . $upType . '/' . $ccChannel . "/" . $ccCode . "/" . $_FILES['uploadFile']['name'])) {
                    throw new Exception('Could not move file');
                }
                $vpBank->insertQDE($ccCode, basename($_FILES['uploadFile']['name']), $_SESSION['idF1'], $_SESSION['cus_id'], $_SESSION['cus_name'], $_POST['reason'], $_SESSION['prod_type'], $_POST['ErrorCode']);
//
//        echo "The file " . basename($_FILES['uploadFile']['name']) .
//        " has been uploaded";
                echo( "<script type='text/javascript'>           
                alert('The file has been uploaded');
				window.location = 'http://fec.saigonbpo.vn:8080';
                </script> ");

            } catch (Exception $e) {
                die('File did not upload: ' . $e->getMessage());
            }
        } else {

            $test = $vpBank->insertQDE($ccCode, '', $_SESSION['idF1'], $_SESSION['cus_id'], $_SESSION['cus_name'], $_POST['reason'], $_SESSION['prod_type'], $_POST['ErrorCode']);
            if ($test == 1) {
                echo( "<script type='text/javascript'>           
                alert('Success!');
				window.location = 'http://fec.saigonbpo.vn:8080';
                </script> ");

            } else {
                echo( "<script type='text/javascript'>           
                alert('Not success!');
                </script> ");
            }
        }

        unset($_SESSION['idF1']);
    } else {
        echo( "<script type='text/javascript'>           
                alert('Not success! You must choose app to QDE again!');
                window.location = 'http://fec.saigonbpo.vn:8080';
                </script> ");
    }
}
?>

<?php
if (!isset($_SESSION['monitoring_username']) || $_SESSION['monitoring_username'] == null) {
    ?>
    <script>
        window.location = "login.php";
    </script>
    <?php
} else {
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
            <title>SAIGON BPO HELP DESK</title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
            <!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
            <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <!--<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
            <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <!-- Ionicons -->
            <!--<link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
            <!--<link href="css/ionic.min.css" rel="stylesheet" type="text/css" />-->
            <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
            <!-- Morris chart -->
            <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
            <!-- jvectormap -->
            <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
            <!-- Date Picker -->
            <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
            <!-- Daterange picker -->
            <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
            <!-- bootstrap wysihtml5 - text editor -->
            <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
            <!-- Theme style -->
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
            <!-- DATA TABLES -->
            <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
            <!--<link href="css/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css" />-->
            <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
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
                    color: #2A88AD;
                    margin-bottom: 0px;
                }
                .form-style-10 .section span {
                    background: #2A88AD;
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
                    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
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
                <aside class="left-side sidebar-offcanvas">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                            </div>
                            <div class="pull-left info">
                                <p>Hello, <?php echo $_SESSION['monitoring_username']; ?></p>

                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>
                        <!-- /.search form -->
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <li>
                                <a href="index.php">
                                    <i class="fa fa-dashboard"></i> <span> Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.php">
                                    <i class="fa fa-dashboard"></i> <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="listqde.php">
                                    <i class="fa fa-dashboard"></i> <span>QDE History</span>
                                </a>
                            </li>     
                            <li class="active">
                                <a href="listticket.php">
                                    <i class="fa fa-dashboard"></i> <span>My Ticket</span>
                                </a>
                            </li>
                            <li>
                                <a href="upload_newapp.php">
                                    <i class="fa fa-dashboard"></i> <span>Upload New App</span>
                                </a>
                            </li>                           
                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>

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
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs" style="background:#fff;">
                                        <li class="active"><a href="#tab_communication" data-toggle="tab">Communication</a></li>                                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_communication">                                       
                                            <div class="muform">
                                                <table style="width: 900px; margin: 0px auto 50px auto; border: 1px #ccc solid; background: #fff; font-size: 11px; font-family: verdana, sans-serif;" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2" style="word-wrap: break-word; border:0px;padding: 9px; color: #fff; background: #3C8DBC;">
                                                                <h2 style="margin-bottom:0px;">App ID: <?php echo $idF1; ?>   |   <?php echo $cus_name; ?> </h1>
                                                                <!--<p style="color: #ccc;margin-top:0px;margin-bottom:0px;font-style: italic;">Our ticket management system for tracking IT issues.</p>-->
                                                            </td>
                                                        </tr>
                                                        <tr style="padding: 10px;">
                                                            <td style="width: 900px; padding: 15px 0px 25px 25px; vertical-align: top;">                                                                 
                                                                <?php
                                                                if (count($ticketList) > 0)
                                                                    foreach ($ticketList as $key => $value) {
                                                                        ?>
                                                                        <table style="table-layout: fixed; width: 900px; margin-top: 10px; border: 1px #ccc solid; background: #eee; font-size: 11px; font-family: verdana, sans-serif;">
                                                                            <tr>
                                                                                <td word-wrap: break-word;>
                                                                                    <div style="margin: 9px;">
                                                                                        <h2 style="margin-bottom:5px; margin-top:10px; font-size:12px; color: <?php
                                                                                        if ($value['post_from'] === 'vpbank')
                                                                                            echo '#0000ff';
                                                                                        else
                                                                                            echo '#008000';
                                                                                        ?>"> <strong><?php echo $value['post_actor'] ?> </b></strong></h2>

                                                                                        <p style="margin-bottom: 10px;"><strong>Post date: </strong><?php echo $value['post_date'] . ' ' . $value['post_time']; ?></p>

                                                                                        <p style="margin-bottom: 10px;"><strong>Post content:</strong></p><?php echo $value['content_request']; ?>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table> 
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <form id="commuForm">
                                                                    <div id = "myNicPanel" style = "width: 900px; margin-top: 30px;" ></div>
                                                                    <div id = "myInstance1" style = "font-size: 16px; background-color: #FFF; padding: 3px; width: 900px;"></div>
                                                                    <div class = "button-section">
                                                                        <input type = "button" id = "postRequest" name = "postRequest" value = "Post Request" onclick = "validateCommu()"/>
                                                                    </div>
                                                                </form>

                                                                </div>
                                                            </td>

                                                    <!--                                                            <td style = "width: 240px; vertical-align: top; padding: 10px 18px 10px 6px">
                                                                                                                    <div style = "margin:15px 8px 0px 10px;padding: 9px; border: 1px #ccc solid; font-size: 10px;">
                                                                                                                        <strong>TICKET #</strong><?php ?>
                                                                                                                        <hr style = "height: 1px; color: #ccc;" />
                                                                                                                        <strong>Date:</strong> {{ticket.created_at | date_sw}}<br />
                                                                                                                        <br />

                                                                                                                        <strong>Creator:</strong> <a style = "color:#FF6600; text-decoration: none;" href = "mailto:{{ticket.creator.email}}?subject={{ticket.ref}} {{ticket.summary}}">{{ticket.creator.full_name_or_email}}</a><br />
                                                                                                                        <strong>Department:</strong> {{ticket.creator.department}}<br>
                                                                                                                        <strong>Office Phone:</strong> {{ticket.creator.office_phone}}<br>
                                                                                                                        <strong>Cell Phone:</strong> {{ticket.creator.cell_phone}}<br>
                                                                                                                    </div>
                                                                                                                </td>-->
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
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
            <!-- daterangepicker -->
            <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

            <!-- AdminLTE App -->
            <script src="js/AdminLTE/app.js" type="text/javascript"></script>

            <!-- AdminLTE for demo purposes -->
            <script src="js/AdminLTE/demo.js" type="text/javascript"></script>

            <!-- DATA TABES SCRIPT -->
            <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
            <!--<script src="js/plugins/datatables/jquery.dataTables_2.js" type="text/javascript"></script>-->
            <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

            <script src="js/nicEdit.js"></script>
            <script src="js/timeout.js" type="text/javascript"></script>

            <script type="text/javascript">
                                                                            var myNicEditor = new nicEditor();
                                                                            bkLib.onDomLoaded(function () {
                                                                                myNicEditor.setPanel('myNicPanel');
                                                                                myNicEditor.addInstance('myInstance1');
                                                                            });
            </script>            
            <script>
                var username = '<?php echo $_SESSION['monitoring_username']; ?>';
                $(document).ready(function () {
                    setInterval(function () {
                        // Update active time every 5 minutes
                        $.ajax({
                            type: "POST",
                            url: "updateActiveTime.php",
                            async: true,
                            data: {
                                username: username
                            },
                            cache: false,
                            success: function (result) {

                            },
                            error: function (xhr, status, error) {

                                console.log("Error");
                                console.log(error);

                            }
                        }); //ajax
                    }, 1000 * 60 * 5); // where X is your every 5 minutes
                });
                function validateCommu() {
                    var contentHtml = myNicEditor.instanceById('myInstance1').getContent();
                    $.ajax({
                        url: 'ajax/communication.php',
                        type: 'POST',
                        cache: false,
                        data: "idF1=" + <?php echo $idF1; ?> + "&content=" + contentHtml,
                        success: function (string) {
                            alert(string);
                            location.reload();

                            //                                if (string === "1")
                            //                                    //$("#tab_communication").load(location.href+" #tab_communication>*","");
                            //                                    location.reload();
                            //                                    //    alert(string);
                            //                                else
                            //                                    alert('Cannot post request!');
                        }});

                }

                function validateQDE() {
                    var err_value = document.getElementById("ErrorCode").value;
                    if (err_value == 'errorcode') {
                        alert('You must choose error code to continue!');
                        return false;
                    }
                    var reason = document.getElementById("reason").value;
                    var uploadfile_el = document.getElementById('uploadFile');
                    if (uploadfile_el) {
                        var fullFileName = uploadfile_el.value;
                        var uploadFile = fullFileName.substr(fullFileName.lastIndexOf("\\") + 1, fullFileName.length);
                    }
                    var uploadTime = <?php echo json_encode($uploadPerDay); ?>;
                    var realccCode = <?php echo json_encode($ccCode); ?>;

                    if (reason == null || reason == "") {
                        alert('You must enter the reason for QDE');
                        return false;
                    }

                    if (uploadFile != null && uploadFile != "") {
                        var filename = uploadFile.split(".");
                        var subStr = filename[0];
                        var filetype = filename[1];
                        if (filetype != 'zip' && filetype != 'rar') {
                            alert('You must upload ZIP file or RAR file!');
                            return false;
                        }

                        var file_name_valid = subStr.split("_");
                        if (file_name_valid.length === 4) {
                            var qde = file_name_valid[0];
                            var ccCode = file_name_valid[1];
                            var yyyymmdd = file_name_valid[2];
                            var upTime = file_name_valid[3];
                            //alert(upTime); return false;
                            //alert(parseInt("10", upTime)); return false;
                            var msg = "";
                            if (qde !== "QDE") {
                                msg += "Name of this folder must begin with \"QDE\", \n";
                            }
                            if (ccCode.length == 8) {
                                if (ccCode !== realccCode) {
                                    msg += "your correct id must be " + realccCode + ", /n";
                                }
                            } else {
                                msg += "your id must be 8 charater, \n";
                            }
                            if (!yyyymmdd.match(/^\+?(0|[1-9]\d*)$/) || !(yyyymmdd.length == 8)) {
                                msg += "upload date must be NUMERIC and follow rule yyyymmdd (ex: 20150505), \n";
                            }
                            if (isNaN(upTime)) {
                                msg += "the number of your upload per day must be NUMERIC , \n";
                            }
                            if (upTime.length != 2) {
                                msg += "the number of upTime must 2 charater (ex: 01, 12) \n";
                            }
                            if (upTime !== "01" && upTime !== "1") {
                                if (parseInt("10", upTime) !== parseInt("10", uploadTime)) {
                                    msg += "the real number of your upload per day is\"" + uploadTime + "\"" + "\n";
                                }
                            }else{
                                if (parseInt(upTime) !== parseInt(uploadTime)) {
                                    msg += "the real number of your upload per day is\"" + uploadTime + "\"" + "\n";
                                }                                
                            }
                            if (msg != "") {
                                alert(msg);
                                return false;
                            }
                        } else {
                            alert('Wrong file name, do not follow the rule \'QDE_YOUR ID_YYYYMMDD_TIME UP PER DAY\'');
                            return false;
                        }
                    }
                    return true;
                }
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