installValidation = {
    addValidation: function () {
        $('#edit-form').bootstrapValidator({
            fields: {
                username: {
                    validators: {
                        notEmpty: {},
                        stringLength: {min: 6, max: 30, },
                        regexp: {regexp: /^[a-zA-Z0-9_\.]+$/, }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {},
                        stringLength: {min: 6, max: 15, },
                        regexp: {regexp: /^[a-zA-Z0-9_@$\.]+$/, }
                    }
                },
                cnfpwd: {
                    validators: {
                        notEmpty: {},
                        stringLength: {min: 6, max: 15, },
                        regexp: {regexp: /^[a-zA-Z0-9_@$\.]+$/, },
                        identical: {field: 'password', }
                    }
                },
                email: {validators: {notEmpty: {}, emailAddress: {}}
                },
                phone: {
                    validators: {
                        notEmpty: {},
                        regexp: {regexp: /^[0-9]+$/, },
                        stringLength: {min: 10, max: 10, },
                    }
                },
                dbType: {validators: {notEmpty: {}}},
                dbHost: {validators: {notEmpty: {}, }},
                dbName: {validators: {notEmpty: {}, }},
                dbUser: {validators: {notEmpty: {}, }},
            }
        });


    }
}


$(document).ready(function () {
    installValidation.addValidation();
});