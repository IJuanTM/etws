<?php
spl_autoload_register(function ($className) {
    $filename = 'inc';
    if (str_contains($className, 'Controller')) {
        $filename .= '/controllers/';
    } elseif (str_contains($className, 'Model')) {
        $filename .= '/models/';
    } elseif (str_contains($className, 'Page')) {
        $filename = 'page/';
    } else {
        $filename .= '/lib/';
    }
    $filename .= $className . '.php';
    if (file_exists($filename)) {
        // Require the page
        require_once $filename;
    } else {
        // Load the error 404 page when no page is found
        require_once ERROR_404_PAGE;
    }
});