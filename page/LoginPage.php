<?php

class LoginPage
{
    public function __construct()
    {
        // Check if all inputs are entered when button is pressed
        if (isset($_POST['submit-login'])) {
            if (!empty($_POST['email-login'])) {
                if (!empty($_POST['password-login'])) {
                    UserController::userLogin($_POST['email-login'], $_POST['password-login']);
                } else {
                    FormController::form_message('Voer een wachtwoord in!', 'warning', null, 'login');
                }
            } else {
                FormController::form_message('Voer een email in!', 'warning', null, 'login');
            }
        }
    }
}