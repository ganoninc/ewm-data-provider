<?php
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

// Must point to composer's autoload file.
require 'vendor/autoload.php';

//echo $_SERVER['HTTP_ORIGIN'];
//if($_SERVER['HTTP_ORIGIN'] == "http://localhost") {

// Load parameters
$parameter_array = parse_ini_file("parameter.ini", true);
$openWeatherMapAPIKey = $parameter_array['open_weather_map']['key'];

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Create OpenWeatherMap object. 
// Don't use caching (take a look into Examples/Cache.php to see how it works).
$owm = new OpenWeatherMap($openWeatherMapAPIKey);

try {
    $weather = $owm->getWeather('Paris', $units, $lang);
} catch(OWMException $e) {
    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
} catch(\Exception $e) {
    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
}

echo $weather->temperature;