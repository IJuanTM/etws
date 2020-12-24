<?php

class FormController
{
    public static string $alert;

    public static function form_message($message, $type, $refresh, $location): string
    {
        static::$alert = '<div class="alert ' . $type . '" role="alert">' . $message . '</div>';
        header("Refresh:" . $refresh . "; url=" . PageController::url($location) . "");
        return static::$alert;
    }
}