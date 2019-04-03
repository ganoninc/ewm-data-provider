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
        $authorizedCoordinatesKeysJsonFile = file_get_contents("authorizedCoordinatesKeys.json");
        $this->authorizedCoordinatesKeys = json_decode($authorizedCoordinatesKeysJsonFile, true);
    }
 
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new AccessController();
        }

        return self::$instance;
    }

    public function isAuthorized($key)
    {
        return in_array($key, $this->authorizedCoordinatesKeys);
    }
}