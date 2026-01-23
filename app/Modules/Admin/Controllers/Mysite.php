<?php

namespace App\Controllers;

class Mysite extends BaseController
{
    public function index(): string
    {
        $router = service('router');
        // $currentController = $router->controllerName(); // Returns 'App\Controllers\Home'

        // Option 1 - Most recommended (clean & safe)
        // $currentController = class_basename($router->controllerName());
        // → "Home"

        // Option 2 - Using basename + str_replace
        // $currentController = basename(str_replace('\\', '/', $router->controllerName()));
        // → "Home"

        // Option 3 - explode + last piece
        // $parts = explode('\\', $router->controllerName());
        // $currentController = end($parts);
        // → "Home"

        // Option 4 - If you want lowercase too
        $currentController = strtolower(class_basename($router->controllerName()));
        // → "home"

        $currentMethod = $router->methodName(); // Returns 'index'
        
        return view('mysite', [
            'controller' => $currentController,
            'method' => $currentMethod
        ]);
    }

}
