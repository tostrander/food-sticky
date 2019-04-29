<?php

//Start a session
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');

//Instantiate Fat-Free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function($f3) {

    echo "<h1>Welcome to my Food Site</h1>";
    echo "<a href='order'>Place an Order</a>";
});

//Define an order route
$f3->route('GET /order', function() {

    //Display order form
    $view = new Template();
    echo $view->render('views/order-form.html');
});

//Define a summary route
$f3->route('POST /summary', function() {

    print_r($_POST);

    //Display summary
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run Fat-Free
$f3->run();