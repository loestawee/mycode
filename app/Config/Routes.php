<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/employee', 'EmployeeController::index');
$routes->get('/employee/view', 'EmployeeController::view');
