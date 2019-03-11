<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-03-11
 * Time: 12:56
 */

namespace PCC_EPE\Frontend;


class Routes
{

    private $routes = [];

    public function __construct() {
        return $this->routes;
    }

    public function setRoute($action,$callback) {
        $this->routes[$action] = $callback;
    }

    public function getRoute($action) {
        return $this->routes[$action];
    }

}