<?php

namespace App;

use AltoRouter;

class Router
{
    private string $views_dir;
    private AltoRouter $router;

    public function __construct(string $views_dir)
    {
        $this->views_dir = $views_dir;
        $this->router = new AltoRouter();
    }

    /**
     * Base directory of all routes is "views"
     * @param ?string $filepath This variable describes the path to get to the viewfile.
     * It contains no slashes at the beginning or the end.
     * 
     * Example: admin/example/example/login
     */
    public function get(string $route, string $file, string $name, ?string $filepath = ''): void
    {

        $this->router->map('GET', $route, function () use ($file, $filepath) {
            // By declaring router here, we can access it in any views.
            $router = $this;
            if ($filepath) {
                require "$this->views_dir/$filepath/$file.php";
            } else {
                require "$this->views_dir/$file.php";
            }
        }, $name);
    }
    
    public function post(string $route, string $file, string $name, ?string $filepath = ''): void
    {

        $this->router->map('POST', $route, function () use ($file, $filepath) {
            // By declaring router here, we can access it in any views.
            $router = $this;
            if ($filepath) {
                require "$this->views_dir/$filepath/$file.php";
            } else {
                require "$this->views_dir/$file.php";
            }
        }, $name);
    }



    public function run()
    {

        $match = $this->router->match();
        if ($match) {
            ob_start();
            // we can access router in layout with the line below;
            $router = $this->router;
            $match["target"]();
            $content = ob_get_clean();
            require $this->views_dir . DIRECTORY_SEPARATOR . "components/layout.php";
        } else {
            echo '404 : Page does not exist';
        }
    }

    public function getRoute(string $name, ?array $params = []): string
    {
        return $this->router->generate($name, $params);
    }
}
