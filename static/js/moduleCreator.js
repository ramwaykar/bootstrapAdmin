sgValidation = {
    addValidation: function () {
        var fieldsToValidate = {
            name: {validators: {notEmpty: {}, }},
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
            sgValidation.addValidation();
            break;
        case 'remove':
            //dont do anything
            break;
        default:
            common.getListviewData();

    }
});
