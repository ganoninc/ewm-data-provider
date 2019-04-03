<?php
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

// Must point to composer's autoload file.
require 'vendor/autoload.php';

require_once 'Cache.php';
require_once 'AccessController.php';

// Load parameters
$parameter_array = parse_ini_file('parameter.ini', true);
$openWeatherMapAPIKey = $parameter_array['open_weather_map']['key'];

// Language of data (try your own language here!):
$lang = 'en';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Create OpenWeatherMap object. 
// Don't use caching (take a look into Examples/Cache.php to see how it works).
$owm = new OpenWeatherMap($openWeatherMapAPIKey);

// Example 1: Use your own cache implementation. Cache for 10 seconds only in this example.
$cache = new Cache();
$cache->setTempPath(__DIR__.'/temps');
$owm = new OpenWeatherMap($openWeatherMapAPIKey, null, $cache, 3600);

try {
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];
    if(empty($latitude) && empty($longitude)) {
        echo 'Missing or wrong parameter. Please provide correct coordinates.';
    } else {
        $key = $latitude.$longitude;
        if(AccessController::getInstance()->isAuthorized($key)) {
            $weather = $owm->getWeather(array('lat' => floatval($latitude), 'lon' => floatval($longitude)), $units, $lang);
            //var_dump($weather);
            echo $weather->weather->icon;
        } else {
            echo 'These coordinates are not authorized.';
        }

    }
} catch(OWMException $e) {
    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
} catch(\Exception $e) {
    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
}

