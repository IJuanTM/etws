<?php

use JetBrains\PhpStorm\Pure;

class PageController extends PageModel
{
    public $pageObj;

    public function __construct()
    {
        // Parse the url
        $this->parse_url();

        // Load the given page
        $this->load_page();
    }

    private function parse_url()
    {
        // Load the required page from the url
        $varStr = explode('/', rtrim($_REQUEST['__uri'], '/'));

        // Cut the url in 3 parts, the baseUrl: your domain, the pagename: the page you're searching for and the pageVars, the subpage of the metioned pagename.
        $urlArr['baseUrl'] = rtrim(str_replace($_REQUEST['__uri'], '', $_SERVER['REQUEST_URI']), '/');
        $urlArr['pagename'] = array_shift($varStr);
        $urlArr['pageVars'] = $varStr;

        // Set the urlArr
        $this->set_urlArr($urlArr);
    }

    private function load_page()
    {
        // Set the pagename at load
        $page = $this->urlArr['pagename'];

        // Set to home if none given
        if (empty($page)) $page = 'login';

        // Load the needed PHP class that corresponds with the page
        $objName = ucfirst(strtolower($page)) . 'Page';
        if (class_exists($objName)) $this->pageObj = new $objName($this->urlArr);
        else {
            require_once ERROR_404_PAGE;
            header("Refresh: 2; url=" . PageController::url('login') . "");
            exit();
        }

        // Get start of HTML and the HEAD
        $this->get_part('header');

        // Get the content of the BODY -> SECTION
        if (file_exists(VIEW . $page . '.phtml')) require VIEW . $page . '.phtml';
        else {
            require_once ERROR_404_PAGE;
            header("Refresh: 2; url=" . PageController::url('login') . "");
            exit();
        }

        // Get the footer part and end of HTML
        $this->get_part('bottom');
    }

    public static function url($sub_url = ''): string
    {
        // Make a static variable $baseurl
        static $baseurl;

        // Check if http or https, then take the host, root directory and the base directory and return a complete url path
        if (!$baseurl) $baseurl = "http" . (!empty($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . preg_replace('@^' . preg_quote(rtrim(realpath($_SERVER['DOCUMENT_ROOT']), '/')) . '@', '', BASEDIR);
        $url = trim($baseurl, '/') . '/' . ltrim($sub_url, '/');
        if (is_file(rtrim(BASEDIR, '/') . '/' . $sub_url)) $url = self::add_param($url, ['_' => filemtime(rtrim(BASEDIR, '/') . '/' . $sub_url)]);
        else $url = rtrim($url, '/') . '/';

        // Return the url
        return $url;
    }

    #[Pure] public static function add_param($url, $parameters): string
    {
        // Add parameter
        list($page, $fragment) = explode('#', $url . '#', 2);
        $c = (false === strpos($page, '?')) ? '?' : '&';
        $page .= $c . http_build_query($parameters);
        return $page . ($fragment ? '#' . $fragment : '');
    }

    public function get_part($name)
    {
        // Load the part
        $file = PARTS . $name . '.phtml';
        if (file_exists($file)) require $file;
        else var_dump($file);
    }

    public static function get_part_string($name, array $vars = array()): bool|string
    {
        // Get subpages
        $file = PARTS . $name . '.phtml';
        if (file_exists($file)) {
            ob_start();
            require $file;
            $return = ob_get_contents();
        } else {
            $return = false;
        }
        ob_end_clean();
        return $return;
    }
}