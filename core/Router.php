<?php

require_once('../src/Route/Routes.php');
class Router
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $this->routes = Routes::getRoutes();

        if (!empty($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        } else {
            $url = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['params'] !== null) {

                $this->params = $route['params'];
                foreach ($route['params'] as $key => $value) {
                    $newParttern = str_replace(":{$key}", $value,  $route['pattern']);
                    $route['pattern'] = $newParttern;
                }
                debug(array($url, $this->params));
                die();
                if ($url === $route['pattern']) {
                    $this->controller = "{$route['path'][0]}";
                    $this->method = $route['path'][1];
                } else {
                    $this->controller = 'ErrorController';
                    $this->method = 'pageNotFound';
                    $this->params = [];
                }
            }

            if ($url === $route['pattern'] && $route['params'] === null) {
                $this->controller = "{$route['path'][0]}";
                $this->method = $route['path'][1];
            }
        }
        if (file_exists("../src/controllers/{$this->controller}.php")) {
            require_once("../src/controllers/{$this->controller}.php");
            $this->controller = new $this->controller;
        }
        if (method_exists($this->controller, $this->method)) {
            $this->method = $this->method;
        }
        call_user_func_array(array($this->controller, $this->method), $this->params);
    }
}
