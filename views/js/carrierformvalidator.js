var emailValid;
var dateValid;
var phoneNumberValid;

$(document).ready(function() {
    // EMAIL VALIDATION
    if (!isEmail($('#other_email_address').val()) && $('#other_email_address').val() !== '') {
        styleInvalidFocusOut('other_email_address');
        emailValid = 0;
    } else if (isEmail($('#other_email_address').val())) {
        styleValidFocusOut('other_email_address');
        emailValid = 1;
    }

    $('#other_email_address').focus(function () {
        if (emailValid == 1) {
            styleValidFocus('other_email_address')
        } else if (emailValid == 0) {
            styleInvalidFocus('other_email_address')
        }
    })

    $('#other_email_address').focusout(function () {
        if (isEmail($('#other_email_address').val())) {
            styleValidFocusOut('other_email_address');
            emailValid = 1;
        } else {
            styleInvalidFocusOut('other_email_address');
            emailValid = 0;
        }

        if (emailValid == 1) {
            styleValidFocusOut('other_email_address');
        } else if (emailValid == 0) {
            styleInvalidFocusOut('other_email_address');
        }
    })

    // DATE VALIDATION
    if (!isDate($('#other_email_datetime').val()) && $('#other_email_datetime').val() !== '') {
        styleInvalidFocus('other_email_datetime')
        dateValid = 0;
    } else if (isDate($('#other_email_datetime').val())) {
        styleValidFocusOut('other_email_datetime');
        dateValid = 1;
    }

    $('#other_email_datetime').focus(function () {
        if (dateValid == 1) {
            styleValidFocusOut('other_email_datetime');
        } else if (dateValid == 0) {
            styleInvalidFocus('other_email_datetime')
        }
    })

    $('#other_email_datetime').focusout(function () {
        if (isDate($('#other_email_datetime').val())) {
            styleValidFocusOut('other_email_datetime');
            dateValid = 1;
        } else {
            styleInvalidFocusOut('other_email_datetime');
            dateValid = 0;
        }

        if (dateValid == 1) {
            styleValidFocusOut('other_email_datetime');
        } else if (dateValid == 0) {
            styleInvalidFocusOut('other_email_datetime');
        }
    })

    // SMS VALIDATION

    if (!isPhoneNumber($('#sms_phone_number').val()) && $('#sms_phone_number').val() !== '') {
        styleInvalidFocusOut('sms_phone_number');
        phoneNumberValid = 0;
    } else if (isPhoneNumber($('#sms_phone_number').val())) {
        styleValidFocusOut('sms_phone_number');
        phoneNumberValid = 1;
    }

    $('#sms_phone_number').focusout(function () {
        if (!isPhoneNumber($('#sms_phone_number').val()) && $('#sms_phone_number').val() !== '') {
            styleInvalidFocusOut('sms_phone_number');
            phoneNumberValid = 0;
        } else if (isPhoneNumber($('#sms_phone_number').val())) {
            styleValidFocusOut('sms_phone_number');
            phoneNumberValid = 1;
        }

        if (phoneNumberValid == 1) {
            styleValidFocusOut('sms_phone_number');
        } else if (phoneNumberValid == 0) {
            styleInvalidFocusOut('sms_phone_number');
        }
    })

    $('#sms_phone_number').focus(function () {
        if (phoneNumberValid == 1) {
            styleValidFocus('sms_phone_number')
        } else if (phoneNumberValid == 0) {
            styleInvalidFocus('sms_phone_number')
        }
    })

})

function styleValidFocus(fieldId)
{
    $('#' + fieldId).css("outline", "none");
    $('#' + fieldId).css("border", "3px solid #53d572");
    $('#' + fieldId).css("transition", "0.5s");
    $('#' + fieldId).css("background-color", "#b8f2b3");
    $('#' + fieldId + '_error_message').hide();
}

function styleInvalidFocus(fieldId)
{
    $('#' + fieldId).css("outline", "none");
    $('#' + fieldId).css("border", "3px solid #f59990");
    $('#' + fieldId).css("transition", "0.5s");
    $('#' + fieldId).css("background-color", "#f7bdb7");
    $('#' + fieldId + '_error_message').show();
    $('#' + fieldId + '_error_message').css("color", "red");
}

function styleValidFocusOut(fieldId)
{
    $('#' + fieldId).css("outline", "none");
    $('#' + fieldId).css("border", "3px solid #53d572");
    $('#' + fieldId).css("transition", "0.5s");
    $('#' + fieldId).css("background-color", "#cbf2d4");
    $('#' + fieldId + '_error_message').hide();
}

function styleInvalidFocusOut(fieldId)
{
    $('#' + fieldId).css("outline", "none");
    $('#' + fieldId).css("border", "3px solid #f59990");
    $('#' + fieldId).css("transition", "0.5s");
    $('#' + fieldId).css("background-color", "#f2dede");
    $('#' + fieldId + '_error_message').show();
    $('#' + fieldId + '_error_message').css("color", "red");
}

function isEmail(s)
{
    var reg = /^[a-z\p{L}0-9!#$%&'*+\/=?^`{}|~_-]+[.a-z\p{L}0-9!#$%&'*+\/=?^`{}|~_-]*@[a-z\p{L}0-9]+[._a-z\p{L}0-9-]*\.[a-z\p{L}0-9]+$/i;
	return reg.test(s);
}

function isPhoneNumber(s)
{
    var reg = /^[+0-9. ()-]+$/;
	return (reg.test(s) && s.length == 9);
}

function isDate(s)
{
    currentDate = new Date();
    deliveryDate = new Date(s);
    deliveryDate.setDate(deliveryDate.getDate() + 1);

    return (deliveryDate > currentDate);
}