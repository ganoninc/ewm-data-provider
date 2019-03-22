<?php
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

// Must point to composer's autoload file.
require 'vendor/autoload.php';

//echo $_SERVER['HTTP_ORIGIN'];
//if($_SERVER['HTTP_ORIGIN'] == "http://localhost") {

require_once 'Cache.php';

// Load parameters
$parameter_array = parse_ini_file("parameter.ini", true);
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
    $weather = $owm->getWeather('Paris', $units, $lang);
} catch(OWMException $e) {
    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
} catch(\Exception $e) {
    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
}

echo $weather->temperature;