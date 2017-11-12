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


(function () {

    if (!window.FileReader || !window.ArrayBuffer) {
        $("#error_block").removeClass("hidden").addClass("show");
        return;
    }

    $("#uploadFile").on("change", function (evt) {
        $("#step2").show();
        var username = $("#cc_code").val();
        var user_channel = $("#cc_channel").val();
        var uploadTime = $("#upload_per_day").val();
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

    $("#uploadNewApp").click(function () {
        waitingDialog.show('Đang tải hồ sơ...');
        var form_data = new FormData();
        var file_data = $('#uploadFile').prop('files')[0];
        form_data.append('file', file_data);
        console.log(file_data);
        $.ajax({
            type: "POST",
            url: "upload_file_ntb.php",
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (result) {
                waitingDialog.hide();
                alert(result);
                window.location.reload(true);
            },
            error: function (xhr, status, error) {
                waitingDialog.hide();
                alert(result);
                window.location.reload(true);
            }
        });
    });
})();