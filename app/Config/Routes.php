<?php

namespace Config;

use CodeIgniter\Routing\RouteCollection;
use Config\Services;

$routes = Services::routes();

$routes->get('/', 'Welcome::index');
$routes->get('admin/login', 'Admin::login');
$routes->post('api/login', 'Api::login');
