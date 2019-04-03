<?php
/**
 * Check if the request is authorized
 */
class AccessController
{
    private static $instance = null;
    private $authorizedCoordinatesKeys = null;
  
    private function __construct()
    {
        $authorizedCoordinatesKeysJsonFile = file_get_contents("autorizedCoordinates.json");
        $authorizedCoordinatesKeys = json_decode($authorizedCoordinatesKeysJsonFile, true);
    }
 
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new AccessController();
        }

        return self::$instance;
    }
}