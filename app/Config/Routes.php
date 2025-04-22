<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/employee', 'EmployeeController::index');
$routes->get('/employee/view', 'EmployeeController::view');

$routes->post('/employee/save', 'EmployeeController::save');
$routes->post('/employee/check_emp_id', 'EmployeeController::check_emp_id');
