<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();
    $DB = new PDO('pgsql:host=localhost;dbname=food');
    // $app ['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.twig', array('cuisine' => Cuisine::getAll()));
    });

    $app->get('/cuisine/{id}', function($id) use ($app) {
        $cuisine = Cuisine::findCuisine($id);
        return $app['twig']->render('cuisine.twig', array('cuisine' => $cuisine, 'restaurant' => $cuisine->getRestaurants()));
    });

    $app->post('/index', function() use ($app) {
        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();
        return $app['twig']->render('index.twig', array('cuisine' => Cuisine::getAll()));
    });

    $app->post('/cuisine', function() use ($app) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $cuisine_id = $_POST['cuisine_id'];
        $restaurant = new Restaurant($name, $location, $id = null, $cuisine_id);
        $restaurant->save();
        $cuisine = Cuisine::findCuisine($cuisine_id);
        return $app['twig']->render('cuisine.twig', array('cuisine' => $cuisine, 'restaurant' => $cuisine->getRestaurants()));
    });

    $app->post('/delete_types', function() use ($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.twig');
    });

    $app->post('/delete_res', function() use ($app) {
        Restaurant::deleteAll();
        return $app['twig']->render('cuisine.twig');
    });

    $app->get('/cuisine/{id}/edit', function($id) use ($app) {
        $cuisine = Cuisine::findCuisine($id);
        return $app['twig']->render('cuisine_edit.twig', array('cuisine' => $cuisine));
    });

    $app->patch('/cuisine/{id}', function($id) use ($app) {
        $type = $_POST['type'];
        $cuisine = Cuisine::findCuisine($id);
        $cuisine->update($type);
        return $app['twig']->render('cuisine.twig', array('cuisine' => $cuisine, 'restaurant' => $cuisine->getRestaurants()));
    });

    return $app;
?>
