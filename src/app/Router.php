<?php
namespace App;

use App\Models\User;
use Exception;

class Router
{
    private $routes = [];
    private $authRoutes = [];
    private $lastAddedRoute;
    private $loginRouteUri = "/login";

    public function checkAuth(){
        if( session_status() !== PHP_SESSION_ACTIVE ){
            throw new Exception('Session not started');
        }
        if(!array_key_exists('user_id', $_SESSION)){
            header("Location: $this->loginRouteUri");
        }
        $currentUser = User::where('id', $_SESSION['user_id'])->first();
        if(!$currentUser)
        {
            header("Location: $this->loginRouteUri");
        }
        $_SESSION['user'] = $currentUser;
    }

    public function register(string $uri, callable|array $action){
        $this->routes[$uri] = $action;
        $this->lastAddedRoute = $uri;
        return $this;
    }
    
    public function protect(){
        $this->authRoutes[] = $this->lastAddedRoute; 
    }

    public function resolve($full_uri){
        $uri = explode("?", $full_uri)[0];
        if( in_array($uri, $this->authRoutes) ){
            $this->checkAuth();
        }
        
        if(!array_key_exists($uri, $this->routes)){
            throw new Exception('Not found');
        }
        
        if(is_callable($this->routes[$uri])){
            return call_user_func($this->routes[$uri]);
        }

        if(is_array($this->routes[$uri])){
            [$class, $action] = $this->routes[$uri];
            if(class_exists($class)){
                $object = new $class();
                if(method_exists($object, $action)){
                    return call_user_func([$object, $action]);
                }
            }
        }
        throw new Exception('Not found');
    }
}