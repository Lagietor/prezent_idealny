<?php

class WishValidate
{
    public static function isDate(string $date)
    {
        $currentDate = new DateTime("now");
        $date = new DateTime($date);

        date_add($date, date_interval_create_from_date_string("1 day"));

        return ($date > $currentDate);
    }

    public static function isEmail(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isPhoneNumber(string $phoneNumber)
    {
        return (Validate::isPhoneNumber($phoneNumber) && strlen($phoneNumber) == 9);
    }
}
