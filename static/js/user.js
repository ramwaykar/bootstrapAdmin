userValidation = {
    addValidation: function () {
        var fieldsToValidate = {
            fName: {validators: {notEmpty: {}, }},
            lName: {validators: {notEmpty: {}, }},
            email: {validators: {notEmpty: {}, emailAddress: {}}},
            phone: {validators: {
                    notEmpty: {},
                    regexp: {regexp: /^[0-9]+$/, },
                    stringLength: {min: 10, max: 10, },
                }
            },
            securityGroupId: {validators: {notEmpty: {}, }},
        };
        if ($("input[name='id']").val() === '') {
            fieldsToValidate['username'] = {validators: {
                    notEmpty: {},
                    stringLength: {min: 6, max: 30},
                    regexp: {regexp: /^[a-zA-Z0-9_\.]+$/, }
                }
            };
        }
        if ($("input[name='id']").val() === '' || $("input[name='action']").val() === 'changePassword') {
            fieldsToValidate['password'] = {
                validators: {
                    notEmpty: {},
                    stringLength: {min: 6, max: 15, },
                    regexp: {regexp: /^[a-zA-Z0-9_@$\.]+$/, }
                }
            };
            fieldsToValidate['cnfpwd'] = {
                validators: {
                    notEmpty: {},
                    stringLength: {min: 6, max: 15, },
                    regexp: {regexp: /^[a-zA-Z0-9_@$\.]+$/, },
                    identical: {field: 'password', }
                }
            };
        }


        $('#edit-form').bootstrapValidator({
            fields: fieldsToValidate
        });


    }
}

$(document).ready(function () {
    var action = $("input[name='action']").val();
    switch (action) {
        case 'save':
        case 'changePassword':
            userValidation.addValidation();
            break;
        case 'remove':
            //dont do anything
            break;
        default:
            common.getListviewData();

    }
});