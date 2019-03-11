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
    function route($route, $action)
    {
        $routes = new Routes();
        $routes->setRoute($route, $action);
    }

    /**
     * Dispatch route
     * @param $action
     * @param $data
     * @return mixed
     */
    function dispatch($action, $data)
    {
        $routes = new Routes();
        $renderUI = new RenderUI();

        $callback = $routes->getRoute($action);

        echo $callback;

        //echo $renderUI->renderSections($callback, $data);

    }


}