$(document).ready(function() {
    openFirstCheckedOption();

    $(document).on('click', '#registered_email', function(e){
		registeredEmailSlide();
        $('#registered_email_wishes').bind('keyup', function(e){
            document.getElementById('registered_email_currentLength').innerHTML = $(this).val().length;
       });
	});

    $(document).on('click', '#other_email', function(e){
		otherEmailSlide();
        $('#other_email_wishes').bind('keyup', function(e){
            document.getElementById('other_email_currentLength').innerHTML = $(this).val().length;
        });
	});

    $(document).on('click', '#sms', function(e){
		smsSlide();
	});
} )

function openFirstCheckedOption()
{
    if ($('#registered_email:checked').length > 0) {
        $('#registered_email_form').slideDown('slow');
    }
    if ($('#other_email:checked').length > 0) {
        $('#other_email_form').slideDown('slow');
    }
    if ($('#sms:checked').length > 0) {
        $('#sms_form').slideDown('slow');
    }
}

function registeredEmailSlide()
{
    $('#registered_email_form').slideDown('slow');
    $('#other_email_form').slideUp('fast');
    $('#sms_form').slideUp('fast');
}

function otherEmailSlide()
{
    $('#other_email_form').slideDown('slow');
    $('#registered_email_form').slideUp('fast');
    $('#sms_form').slideUp('fast');
}

function smsSlide()
{
    $('#sms_form').slideDown('slow');
    $('#other_email_form').slideUp('fast');
    $('#registered_email_form').slideUp('fast');
}