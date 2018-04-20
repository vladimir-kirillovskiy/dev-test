<?php
require_once '../vendor/autoload.php';

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, ['debug' => true]);

//Get the episodes from the API
$client = new GuzzleHttp\Client();
$res = $client->request('GET', 'http://3ev.org/dev-test-api/');
$data = json_decode($resgit ->getBody(), true);

$season_list = [];
// Filter by season
if (isset($_GET['season']) && $_GET['season'] != 0) {
    $season = $_GET['season'];
    $temp_arr = [];

    // make a new array and make a list of all seasons
    foreach($data as $val) {
        $season_list[] = $val['season'];

        if ($val['season'] == $season) {
            $temp_arr[] = $val;
        }
    }

    $data = $temp_arr;
    unset($temp_arr);
} else {
    // make a list of all seasons
    foreach($data as $val) {
        $season_list[] = $val['season'];
    }
}


//Sort the episodes
array_multisort(array_keys($data), SORT_ASC, SORT_STRING, $data);
// sort list of seasons and leave only unique ones
$season_list = array_unique($season_list);
asort($season_list);

//Render the template
echo $twig->render('page.html', ["episodes" => $data, "season_list" => $season_list]);
