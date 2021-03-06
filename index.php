<?php

//Start a session
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Required file
require_once('vendor/autoload.php');
require_once('model/validate.php');

//Instantiate Fat-Free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define arrays
$f3->set('meals', array('breakfast', 'lunch', 'dinner'));
$f3->set('condiments', array('ketchup', 'mustard', 'mayonnaise'));
$f3->set('drinks', array('Coke', 'Pepsi', 'water'));

//Define a default route
$f3->route('GET /', function() {

    echo "<h1>Welcome to my Food Site</h1>";
    echo "<a href='order'>Place an Order</a>";
});

//Define an order route
$f3->route('GET|POST /order', function($f3) {

    $selectedCondiments = array();

    //If form has been submitted, validate
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Get data from form
        $food = $_POST['food'];
        $qty = $_POST['qty'];
        $meal = $_POST['meal'];
        $drink = $_POST['drink'];
        if (!empty($_POST['condiments']))
            $selectedCondiments = $_POST['condiments'];

        //Add data to hive
        $f3->set('food', $food);
        $f3->set('qty', $qty);
        $f3->set('meal', $meal);
        $f3->set('beverage', $drink);
        $f3->set('selectedCondiments', $selectedCondiments);

        //If data is valid
        if (validForm()) {

            //Write data to Session
            $_SESSION['food'] = $food;
            $_SESSION['qty'] = $qty;
            $_SESSION['meal'] = $meal;
            $_SESSION['condiments'] = $selectedCondiments;
            $_SESSION['beverage'] = $drink;

            //Redirect to Summary
            $f3->reroute('/summary');
        }
    }

    //Display order form
    $view = new Template();
    echo $view->render('views/order-form.html');
});

//Define a summary route
$f3->route('GET /summary', function() {

    //Display summary
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run Fat-Free
$f3->run();