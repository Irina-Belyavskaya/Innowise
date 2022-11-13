<?php

namespace core;

require_once 'vendor/autoload.php';
class View
{
    public string $path;
    public array $route;
    private $twig;

    public function __construct($route) {
        $this->route = $route;
        $this->path = $this->route['controller'].'/'. $this->route['action'];

        // Load twig
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $this->twig = new \Twig\Environment($loader);
    }

    public function render($vars = []) {
        try {
            $path = $this->path.'.html';
            echo $this->twig->render($path, $vars);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function redirect($url) {
        header('location: ' . $url);
        exit;
    }

    public static function errorCode($code) {
        http_response_code($code);
        $path = 'views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
        exit;
    }


}