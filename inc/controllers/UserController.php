<?php

class UserController
{
    public static function userLogin($email, $password)
    {
        $db = new Database();
        $db->query('SELECT password, email FROM user WHERE email = :email');
        $db->bind(':email', $email);
        $db->execute();
        if (!empty($db->single()['email'])) {
            if (password_verify($password, $db->single()['password'])) {
                $db->query('SELECT * FROM user WHERE email = :email');
                $db->bind(':email', $email);
                $record = $db->resultset()[0];
                $_SESSION['id'] = $record['user_id'];
                $_SESSION['company'] = $record['company'];
                $_SESSION['product'] = $record['product'];
                $_SESSION['email'] = $record['email'];
                $_SESSION['date'] = $record['join_date'];
                $_SESSION['firstname'] = $record['firstname'];
                $_SESSION['insertion'] = $record['insertion'];
                $_SESSION['lastname'] = $record['lastname'];
                $_SESSION['birthdate'] = $record['birthdate'];
                $_SESSION['phone'] = $record['phone'];
                $_SESSION['country'] = $record['country'];
                $_SESSION['province'] = $record['province'];
                $_SESSION['city'] = $record['city'];
                $_SESSION['zipcode'] = $record['zipcode'];
                $_SESSION['street'] = $record['street'];
                $_SESSION['number'] = $record['streetnumber'];
                $_SESSION['user_role'] = (int)$record['user_role'];
                if ($_SESSION["user_role"] === 0) FormController::form_message('Inlog successvol! Welkom admin.', 'info', 1, 'dashboard');
                elseif ($_SESSION["user_role"] === 1) FormController::form_message('Inlog successful! Welkom bij uw ETWS systeem!', 'success', 1, 'dashboard');
                else {
                    FormController::form_message('Error! Er is geen rol gedefineerd voor dit account! Neem contact op met een admin!', null, 'error', 'login');
                    unset($_SESSION["user_role"]);
                }
            } else FormController::form_message('De ingevoerde gegevens zijn niet juist!', 'warning', null, 'login');
        } else FormController::form_message('Dit email is niet bij ons bekend!', 'warning', null, 'login');
    }
}