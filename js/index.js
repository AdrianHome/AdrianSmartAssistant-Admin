

function showAddValuesForm(type, languageId)
{
    var addValueForm = '<div class="add_value_form add_form">' +
        '<div class="cross"><i class="fa fa-times fa-1" aria-hidden="true"></i></div>' +
        'Add new ' + type +
        '<br><br>' +
        '<form action="includes/add_new_value.php?' +
        'value_type=' + type + '&' +
        'language_id=' + languageId +
        '" method="post">' +
        '<input type="text" name="value" value="">' +
        '<br><br>' +
        '<input type="submit" value="Add">' +
    '</form>' +
    '</div>';

    $(addValueForm).appendTo('body');
}


function showAddLanguageForm()
{
    var addValueForm = '<div class="add_value_form add_form">' +
        '<div class="cross"><i class="fa fa-times fa-1" aria-hidden="true"></i></div>' +
        'Add new language' +
        '<br><br>' +
        '<form action="includes/add_new_language.php" method="post">' +
        '<input type="text" name="value" value="">' +
        '<br><br>' +
        '<input type="submit" value="Add">' +
    '</form>' +
    '</div>';

    $(addValueForm).appendTo('body');
}


function showAddModuleFunctionForm()
{
    var addValueForm = '<div class="add_module_function_form add_form">' +
        '<div class="cross"><i class="fa fa-times fa-1" aria-hidden="true"></i></div>' +
        'Add new module function' +
        '<br><br>' +
        '<form action="includes/add_new_module_function.php" method="post">' +
        '<input type="text" name="description" value="Description" data-value="Description">' +
        '<br><br>' +
        '<input type="text" name="module" value="Module Name" data-value="Module Name">' +
        '<br><br>' +
        '<input type="text" name="function" value="Function Name" data-value="Function Name">' +
        '<br><br>' +
        '<input type="text" name="params" value="Parameters (JSON)" data-value="Parameters (JSON)">' +
        '<br><br>' +
        '<input type="submit" value="Add">' +
        '</form>' +
        '</div>';

    $(addValueForm).appendTo('body');
}



$(document).ready(function(){


    // redirect the user when they select a language
    $('#language_select').on('change', function() {

        location.href = '?language-id=' + $(this).val();
    });


    // deal with adding any new values into the db
    $(".icon-plus-sign").click(function() {

        var type         = $(this).attr('data-value');
        var languageId   = $('body').attr('data-language-id');

        switch(type) {

            case "location":
            case "object":
            case "method":
            case "action":
            case "description":
                var functionName = "showAddValuesForm";
                break;

            case "language":
                var functionName = "showAddLanguageForm";
                break;

            case "module_function":
                var functionName = "showAddModuleFunctionForm";
                break;

            default:
                console.log('no value received');
        }

        window[functionName](type, languageId);
    });


    // close form if cross is clicked
    $(document).on("click",".cross",function() {

        $('.add_form').remove();
    });


    // close form if cross is clicked
    $(document).on("click","input",function() {

        if($(this).val() == $(this).attr('data-value')){

            $(this).val("");
        }
    });

});