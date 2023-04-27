$(document).ready(function() {
    openFirstCheckedOption();

    $('#registered_email_wishes').bind('keyup', function(e) {
        document.getElementById('registered_email_currentLength').innerHTML = $(this).val().length;
   });

   $('#other_email_wishes').bind('keyup', function(e) {
        document.getElementById('other_email_currentLength').innerHTML = $(this).val().length;
    });

    $(document).on('click', '#registered_email', function(e) {
		registeredEmailManageSettings();
	});

    $(document).on('click', '#other_email', function(e) {
		otherEmailManageSettings();
        
	});

    $(document).on('click', '#sms', function(e) {
		smsManageSettings();
	});
} )

function openFirstCheckedOption()
{
    if ($('#registered_email:checked').length > 0) {
        $('#registered_email_form').slideDown('slow');
    }
    if ($('#other_email:checked').length > 0) {
        $('#other_email_form').slideDown('slow');

        $('#other_email_address').attr('required', 'required');
    }
    if ($('#sms:checked').length > 0) {
        $('#sms_form').slideDown('slow');

        $('#sms_phone_number').attr('required', 'required');
    }
}

function registeredEmailManageSettings()
{
    $('#registered_email_form').slideDown('slow');
    $('#other_email_form').slideUp('fast');
    $('#sms_form').slideUp('fast');

    $('#other_email_address').removeAttr('required');
    $('#sms_phone_number').removeAttr('required');
}

function otherEmailManageSettings()
{
    $('#other_email_form').slideDown('slow');
    $('#registered_email_form').slideUp('fast');
    $('#sms_form').slideUp('fast');

    $('#other_email_address').attr('required', 'required');
    $('#sms_phone_number').removeAttr('required');
}

function smsManageSettings()
{
    $('#sms_form').slideDown('slow');
    $('#other_email_form').slideUp('fast');
    $('#registered_email_form').slideUp('fast');

    $('#sms_phone_number').attr('required', 'required');
    $('#other_email_address').removeAttr('required');
}