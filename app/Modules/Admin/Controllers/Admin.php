<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index(): string
    {
        $router = service('router');
        $currentController = strtolower(class_basename($router->controllerName()));
        $currentMethod = $router->methodName();
        
        return view('admin', [
            'controller' => $currentController,
            'method' => $currentMethod
        ]);
    }

}
