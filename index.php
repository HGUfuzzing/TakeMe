<?php

require 'vendor/autoload.php';
require 'core/bootstrap.php';

session_start();


require Router::load('routes.php')
    ->direct(Request::uri(), Request::method());
