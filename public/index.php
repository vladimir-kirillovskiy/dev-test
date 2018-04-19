<?php
require_once '../vendor/autoload.php';
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ServerException;

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, ['debug' => true]);

$data = [];
$error = [];

try {
    //Get the episodes from the API
    $client = new GuzzleHttp\Client(['http_errors' => true]);
    $res = $client->request('GET', 'http://3ev.org/dev-test-api/');
    $data = json_decode($res->getBody(), true);

    //Sort the episodes
    array_multisort(array_keys($data), SORT_ASC, SORT_STRING, $data);
} catch (ServerException $e) {
    $error[] = $e->getMessage();
}

//Render the template
echo $twig->render('page.html', ["episodes" => $data, "errors" => $error]);
