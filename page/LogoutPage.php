<?php

class LogoutPage
{
    public function __construct()
    {
        unset($_SESSION["user_role"]);
        FormController::form_message('U bent succesvol uitgelogd!', 'success', 1, 'login');
    }
}