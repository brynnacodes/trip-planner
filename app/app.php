<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/City.php";
    require_once __DIR__."/../src/Flight.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=trip_planner';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use($app) {

        return $app['twig']->render("index.html.twig", ["cities" => City::getAll(), "tasks" => Flight::getAll()]);
    });

    $app->get("/cities", function() use($app) {
        return $app['twig']->render('cities.html.twig', ["cities" => City::getAll()]);
    });

    $app->get("/flights", function() use($app) {
        return $app['twig']->render('flights.html.twig', ["flights" => Flight::getAll()]);
    });

    $app->post("/cities", function() use($app) {
        $name = $_POST['name'];
        $city = new City($name);
        $city->save();
        return $app['twig']->render('cities.html.twig', ["cities" => City::getAll()]);
    });

    $app->get("/cities/{id}", function($id) use($app) {
        $city = City::find($id);
        return $app['twig']->render('city.html.twig', ['city' => $city, 'flights' => $city->getFlights(), 'all_flights' => Flight::getAll()]);
    });

    $app->post("/flights", function() use($app) {
        $departure_time = $_POST['departure_time'];
        $status = $_POST['status'];
        $flight = new Flight($departure_time, $status);
        $flight->save();
        return $app['twig']->render('flights.html.twig', ['flights' => Flight::getAll()]);
    });

    $app->get("/flights/{id}", function($id) use($app) {
        $flight = Flight::find($id);
        return $app['twig']->render('flight.html.twig', ["flight" => $flight, "cities" => $flight->getCities(), "all_cities" => City::getAll()]);
    });

    $app->post("/add_cities", function() use($app) {
        $flight = Flight::find($_POST['flight_id']);
        $city = City::find($_POST['city_id']);
        $flight->addCity($city);
        return $app['twig']->render('flight.html.twig', ['flight' => $flight, "flights" => Flight::getAll(), 'cities' => $flight->getCities(), 'all_cities' => City::getAll()]);
    });

    $app->post("/add_flights", function() use($app) {
        $city = City::find($_POST['city_id']);
        $flight = Flight::find($_POST['flight_id']);
        $city->addFlight($flight);
        return $app['twig']->render('city.html.twig', ['city' => $city, "cities" => City::getAll(), 'flights' => $city->getFlights(), 'all_flights' => Flight::getAll()]);
    });

    $app->post("/delete_cities", function() use($app) {
        City::deleteAll();
        return $app['twig']->render("cities.html.twig");
    });

    $app->post("/delete_flights", function() use($app) {
        Flight::deleteAll();
        return $app['twig']->render("flights.html.twig");
    });

    return $app;
?>
