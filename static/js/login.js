loginValidation = {
    addValidation: function () {
        var fields = {
            username: {validators: {notEmpty: {}, }},
            password: {validators: {
                    notEmpty: {},
                    stringLength: {min: 6, max: 15, },
                    regexp: {regexp: /^[a-zA-Z0-9_@$\.]+$/, },
                }
            }
        };
        if ($("input[name='action']").val() === 'forgotPwd') {
            fields['cnfpwd'] = {validators: {
                    notEmpty: {},
                    stringLength: {min: 6, max: 15, },
                    regexp: {regexp: /^[a-zA-Z0-9_@$\.]+$/, },
                    identical: {field: 'password', }
                }
            }
        }
        $('#edit-form').bootstrapValidator({
            fields: fields
        });
    }
}


$(document).ready(function () {
    loginValidation.addValidation();
});