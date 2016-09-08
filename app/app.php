<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    session_start();

    if (empty($_SESSION['inventory'])) {
        $_SESSION['inventory'] = array();
        $lexus = new Car("2000 Lexus F41", 60000, 50000, "img/lexus.jpg");
        $ford = new Car("1996 Ford Classic", 5000, 150000, "img/ford.jpg");
        $bmw = new Car("2016 BMW M5", 90000, 1000, "img/bmw.jpg");
        $honda = new Car("2010 Honda Flight", 30000, 45000, "img/honda.jpg");
        array_push($_SESSION['inventory'], $lexus, $ford, $bmw, $honda);
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('main.html.twig', array('inventory' => $_SESSION['inventory']));
    });

    $app->post("/search", function() use ($app) {

        $cars_matching_search = array();

        foreach ($_SESSION['inventory'] as $car) {
            if ($car->worthBuyingPrice($_POST['price']) && $car->worthBuyingMiles($_POST['miles'])) {
                array_push($cars_matching_search, $car);
            }
        }
        return $app['twig']->render('search_results.html.twig', array('results' => $cars_matching_search));
    });

    $app->post("/new_car", function() use ($app) {
        return $app['twig']->render('new_car.html.twig');
    });

    $app->post("/update_inventory", function() use ($app) {
        $newcar = new Car($_POST['make_model'], $_POST['selling_price'], $_POST['selling_miles'], " ");
        array_push($_SESSION['inventory'], $newcar);
        return $app['twig']->render('main.html.twig', array('inventory' => $_SESSION['inventory']));
    });


    return $app;
?>
