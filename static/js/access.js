accessValidation = {
    addValidation: function () {
        var fieldsToValidate = {
            cmodule: {validators: {notEmpty: {}, }
            },
        };
        $('#edit-form').bootstrapValidator({
            fields: fieldsToValidate
        });
    }
}


$(document).ready(function () {
    var action = $("input[name='action']").val();
    switch (action) {
        case 'save':
            accessValidation.addValidation();
            break;
        case 'remove':
            //dont do anything
            break;
        default:
            common.getListviewData();

    }
});
