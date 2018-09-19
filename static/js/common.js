/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

common = {
    config: function () {
        var conf = new Array();
        conf['domainUrl'] = 'http://localhost/bootstrapAdmin/';
        return conf;
    },
    redirect: function () {
        var conf = common.config();
        var newModule = 'login';
        var module = $("input[name='module']").val();
        switch (module) {
            case 'install':
                newModule = 'login';
                break;
            case 'login':
                newModule = 'home';
                break;
            default:
                newModule = module;
        }
        window.location = conf['domainUrl'] + 'views/' + newModule;
    },
    save: function () {
        $('#edit-form').data('bootstrapValidator').resetForm();
        $('#edit-form').data('bootstrapValidator').validate();
        if ($('#edit-form').data('bootstrapValidator').isValid()) {
            common.postData();
        }
    },
    postData: function () {
        var formData = $('#edit-form').serialize();
        var conf = common.config();
        $.ajax({
            url: conf['domainUrl'] + 'commonFiles/submit.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                if (response) {
                    response = JSON.parse(response);
                    if (response === 'true' || response === true) {
                        common.redirect();
                    } else if (($.type(response) === 'array' || $.type(response) === 'object') && 'errors' in response) {
                        common.displayServerErrors(response);
                    } else {
                        common.displayCommonError();
                    }
                }
            },
            error: function () {
                common.displayCommonError();
            }
        });
    },
    displayCommonError: function () {
        alert('Something went wrong, please try again');
    },
    displayServerErrors: function (response) {
        var module = $("input[name='module']").val();
        switch (module) {
            case 'login':
                for (var key in response['errors']) {
                    if (key === 'status') {
                        key = 'username';
                    }
                    $('#edit-form').data('bootstrapValidator').updateMessage(key, 'notEmpty', response['errors'][key]);
                    $('#edit-form').data('bootstrapValidator').updateStatus(key, 'INVALID');
                }
                break;
            case 'user':
                for (var key in response['errors']) {
                    if (key === 'user_exist') {
                        $('#edit-form').data('bootstrapValidator').updateMessage('username', 'notEmpty', response['errors'][key]);
                        $('#edit-form').data('bootstrapValidator').updateStatus('username', 'INVALID');
                    } else if (key === 'pwd_not_matched') {
                        $('#edit-form').data('bootstrapValidator').updateMessage('cnfpwd', 'identical', response['errors'][key]);
                        $('#edit-form').data('bootstrapValidator').updateStatus('cnfpwd', 'INVALID');
                    } else {
                        $('#edit-form').data('bootstrapValidator').updateStatus(key, 'NOT_VALIDATED').validateField(key);
                    }
                }
                break;
            case 'access':
                for (var key in response['errors']) {
                    if (key === 'already_exists') {
                        $('#edit-form').data('bootstrapValidator').updateMessage('cmodule', 'notEmpty', response['errors'][key]);
                        $('#edit-form').data('bootstrapValidator').updateStatus('cmodule', 'INVALID');
                    } else {
                        $('#edit-form').data('bootstrapValidator').updateStatus(key, 'NOT_VALIDATED').validateField(key);
                    }
                }
                break;
            case 'securityGroup':
                for (var key in response['errors']) {
                    if (key === 'name') {
                        $('#edit-form').data('bootstrapValidator').updateMessage('name', 'notEmpty', response['errors'][key]);
                        $('#edit-form').data('bootstrapValidator').updateStatus('name', 'INVALID');
                    } else {
                        $('#edit-form').data('bootstrapValidator').updateStatus(key, 'NOT_VALIDATED').validateField(key);
                    }
                }
                break;
            case 'moduleCreator':
                for (var key in response['errors']) {
                    if (key === 'name') {
                        $('#edit-form').data('bootstrapValidator').updateMessage('name', 'notEmpty', response['errors'][key]);
                        $('#edit-form').data('bootstrapValidator').updateStatus('name', 'INVALID');
                    } else {
                        $('#edit-form').data('bootstrapValidator').updateStatus(key, 'NOT_VALIDATED').validateField(key);
                    }
                }
                break;
            default:
            for (var key in response['errors']) {
                $('#edit-form').data('bootstrapValidator').updateStatus(key, 'NOT_VALIDATED').validateField(key);
            }
        }
    },
    getListviewData: function () {
        var currentURl = window.location.href;
        var temp = currentURl.split('/');
        var conf = common.config();
        $('#dataTable').DataTable({
            searching: false,
            lengthChange: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: conf['domainUrl'] + 'commonFiles/submit.php',
                type: "POST",
                data: {
                    module: temp[temp.length - 2],
                    action: 'getListData'
                }
            },
            columnDefs: [{
                    "targets": ($("#dataTable thead th").length - 1),
                    "orderable": false
                }
            ]
        });
    },
    logout: function () {
        var conf = common.config();
        $.ajax({
            url: conf['domainUrl'] + 'commonFiles/submit.php',
            method: 'POST',
            data: {
                module: 'user',
                action: 'logout'
            },
            success: function (response) {
                window.location = conf['domainUrl'] + 'views/login';
            }
        });
    },
    delete: function () {
        var formData = $('#delete-form').serialize();
        var conf = common.config();
        $.ajax({
            url: conf['domainUrl'] + 'commonFiles/submit.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                if (response) {
                    response = JSON.parse(response);
                    if (($.type(response) === 'array' || $.type(response) === 'object') && 'errors' in response) {
                        common.displayServerErrors(response);
                    } else if (response === 'true' || response === true) {
                        common.redirect();
                    }
                }
            }
        });
    },
    changeStatus: function () {
        var formData = $('#status-form').serialize();
        var conf = common.config();
        $.ajax({
            url: conf['domainUrl'] + 'commonFiles/submit.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                if (response) {
                    response = JSON.parse(response);
                    if (($.type(response) === 'array' || $.type(response) === 'object') && 'errors' in response) {
                        common.displayServerErrors(response);
                    } else if (response === 'true' || response === true) {
                        common.redirect();
                    }
                }
            }
        });
    },
    search: function () {
        var formData = $('#search-form').serialize();
        var temp = formData.split('&');
        var data = new Array();
        for (var i = 0; i < temp.length; i++) {
            var tmp = temp[i].split('=');
            data[tmp[0]] = tmp[1];
        }
        var conf = common.config();
        $('#dataTable').DataTable({
            destroy: true,
            searching: false,
            lengthChange: false,
            serverSide: true,
            processing: true,
            ajax: {
                url: conf['domainUrl'] + 'commonFiles/submit.php',
                type: "POST",
                data: data
            },
            columnDefs: [{
                    "targets": ($("#dataTable thead th").length - 1),
                    "orderable": false
                }
            ]
        });
    },
    clearSearch: function () {
        $('#search-form input,#search-form select').each(function () {
            if ($(this).attr('type') !== 'button' && $(this).attr('name') !== 'module' && $(this).attr('name') !== 'action') {
                $(this).val('');
            }
        });
        $('#search-form select').each(function () {
            $(this).val('');
        });
        common.search();
    },
};

$(document).ready(function () {
    $("#submit-form,.submit-form").click(function () {
        common.save();
    });
    $("#logout").click(function () {
        common.logout();
    });
    $("#delete-record").click(function () {
        common.delete();
    });
    $("#change-status-record").click(function () {
        common.changeStatus();
    });
    $(".search-form").click(function () {
        common.search();
    });
    $(".clear-search-form").click(function () {
        common.clearSearch();
    });
    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });
});