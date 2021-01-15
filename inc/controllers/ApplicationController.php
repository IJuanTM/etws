<?php

use JetBrains\PhpStorm\Pure;

class ApplicationController extends ApplicationModel
{
    public function __construct()
    {
        // Load the page
        new PageController();
    }

    public static function load_img($name, $ext): bool|string
    {
        // A image loader
        $file = BASEDIR . IMG . imagecreatefromjpeg($name) . $ext;
        return file_get_contents($file);
    }

    public static function load_svg($name): bool|string
    {
        // A clever svg loader
        $file = BASEDIR . SVG . $name . '.svg';
        if (file_exists($file)) return file_get_contents($file);
        else {
            echo $file;
            exit();
        }
    }

    #[Pure] public static function sanitize($raw_data): string
    {
        // Clean input from a form
        $data = htmlspecialchars($raw_data);
        $data = self::escape($data);
        return $data;
    }

    #[Pure] public static function escape($value): string
    {
        // Sanitize characters
        $return = '';
        for ($i = 0; $i < strlen($value); ++$i) {
            $char = $value[$i];
            $ord = ord($char);
            if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126) $return .= $char;
            else $return .= '\\x' . dechex($ord);
        }
        return $return;
    }
}