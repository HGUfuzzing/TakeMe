<?php

class Router
{
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->routes[$requestType][$uri];
        }
        else if(preg_match("/^@[0-9a-zA-Z가-힣-]+$/u", $uri)) {  //domain.com/@{keyword} 모양이면 
            $_GET['keyword'] = substr($uri, 1);
            return $this->routes[$requestType]['@{keyword}'];
        }
        else {
            die('"' . $_SERVER['HTTP_HOST'] . '/' . $uri . '" 에 대한 페이지를 찾을 수 없습니다');
        }

        throw new Exception('No route defined for this URI.');
    }
}