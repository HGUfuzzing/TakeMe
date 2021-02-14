<?php

App::bind('config', require 'private/config.php');

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));