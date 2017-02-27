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
        $result = "hi";

        return $app['twig']->render("index.html.twig", ["result" => $result]);
    });

    return $app;
?>
