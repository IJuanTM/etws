<?php

class UserController
{
    public static function userLogin($email, $password)
    {
        $db = new Database();
        $db->query('SELECT password FROM user WHERE email = :email');
        $db->bind(':email', $email);
        $db->execute();
        if (password_verify($password, $db->single()['password'])) {
            $db->query('SELECT * FROM user WHERE email = :email');
            $db->bind(':email', $email);
            $record = $db->resultset()[0];
            $_SESSION['id'] = $record['user_id'];
            $_SESSION['email'] = $record['email'];
            $_SESSION['product'] = $record['product'];
            $_SESSION['user_role'] = (int)$record['user_role'];
            if ($_SESSION["user_role"] === 0) {
                FormController::form_message('Inlog successvol! Welkom admin.', 'info', 1, 'dashboard');
            } elseif ($_SESSION["user_role"] === 1) {
                FormController::form_message('Inlog successful! Welkom bij uw ETWS systeem!', 'success', 1, 'dashboard');
            } else {
                FormController::form_message('Error! Er is geen rol gedefineerd voor dit account! Neem contact op met een admin!', null, 'error', 'login');
                unset($_SESSION["user_role"]);
            }
        } else {
            FormController::form_message('De ingevoerde gegevens zijn niet juist!', 'warning', null, 'login');
        }
    }
}