<?php
declare(strict_types=1);

namespace Route;

/** @var \Phalcon\Mvc\Router $router */

$router->addGet(
    '/',
    'index::index'
);
