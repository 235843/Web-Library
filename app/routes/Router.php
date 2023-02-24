<?php

namespace Router;

use Auth\Auth;
use Auth\AuthFailed;
use Auth\AuthTypeMismatch;

enum Method
{
    case GET;
    case POST;
    case PUT;
    case DELETE;
    case PATCH;
}

class Route
{
    private string $pattern;
    private string $method;
    private array $auths;

    public function __construct(string $route, Method $method = Method::GET)
    {
        $this->method = $method->name;
        $this->pattern = $this->rout_to_pattern($route);
        $this->auths = [];
    }

    private function rout_to_pattern(string $route): string
    {
        $pieces = explode('/', $route);
        $pieces = array_map(fn ($piece) => str_starts_with($piece, ':') ? '([^\/]*)' : $piece, $pieces);
        $pattern = '/^' . implode('\/', $pieces) . '$/';
        return $pattern;
    }

    public function matches(string $path, string $method): array|false
    {
        $matches = [];
        $path = explode('?', $path)[0];
        if (preg_match($this->pattern, $path, $matches) && $method === $this->method) {
            $this->validate_auth();

            unset($matches[0]);
            return array_values($matches);
        }
        return false;
    }

    private function validate_auth()
    {
        foreach ($this->auths as $auth) {
            if ($auth->validate() === false) {
                throw new AuthFailed("Auth validation failed!");
            }
        }
    }

    public function auth(Auth $auth, ...$auths)
    {
        $this->auths []= $auth;
        foreach ($auths as $auth) {
            if (!$auth instanceof Auth) {
                throw new AuthTypeMismatch("$auth is not of type Auth");
            } else {
                $this->auths []= $auth;
            }
        }
        return $this;
    }
}

class Router
{
    private array $routes = [];

    public function add(string $route, callable $function, Method $method = Method::GET): Route
    {
        $this->routes []= ['route' => new Route(route: $route, method: $method), 'callback' => $function];

        return $this->routes[count($this->routes) - 1]['route'];
    }

    public function start(): ?string
    {
        foreach ($this->routes as $route) {
            $result = $route['route']->matches($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
            if ($result !== false) {
                return $route['callback'](...$result);
            }
        }
        return null;
    }
}
