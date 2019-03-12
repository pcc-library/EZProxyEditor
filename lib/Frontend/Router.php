<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-11
 * Time: 12:46
 */

namespace PCC_EPE\Frontend;

class Router
{

    public $routes;
    public $renderUI;

    /**
     * Holds the registered routes
     *
     * @var array $routes
     */

    /**
     * Register a new route
     *
     * @param $action string
     * @param $route string
     */
    public function route($route, $action)
    {
        $this->routes = new Routes();
        $this->routes->setRoute($route, $action);
    }

    /**
     * Dispatch route
     * @param $action | string
     * @param $data
     * @return mixed
     */
    public function dispatch($action, $data)
    {
        $this->routes = new Routes();
        $this->renderUI = new RenderUI();

        $callback = $this->routes->getRoute($action);

        return $this->renderUI->renderSections($callback, $data);

    }


}