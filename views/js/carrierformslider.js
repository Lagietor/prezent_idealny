$(document).ready(function() {
    document.getElementById("demo").innerHTML = "dupa";
    if ($('#registered_email:checked').length > 0) {
        $('#registered_email_form').slideDown('slow');
    }
} )