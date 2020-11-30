<?php

class FormController
{
    public static string $alert;

    public static function form_message($message, $type, $location): string
    {
        static::$alert = '<div class="alert ' . $type . '" role="alert">' . $message . '</div>';
        header("Refresh: 1; url=" . PageController::url($location) . "");
        return static::$alert;
    }
}