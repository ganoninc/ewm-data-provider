<?php
/**
 * A Cache implementation based on https://github.com/cmfcmf/OpenWeatherMap-PHP-Api/blob/master/Examples Cache.php
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of
 * OpenWeatherMap before using this class:
 *
 * @see http://www.OpenWeatherMap.org
 * @see http://www.OpenWeatherMap.org/terms
 * @see http://openweathermap.org/appid
 */

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\AbstractCache;

/**
 * Cache weather data to avoid unnecessary calls of OpenWeatherMap API
 *
 * @ignore
 */
class Cache extends AbstractCache
{
    protected $tmp;

    public function __construct()
    {
        $this->tmp = sys_get_temp_dir();
    }

    private function urlToPath($url)
    {
        $dir = $this->tmp . DIRECTORY_SEPARATOR . "OpenWeatherMapPHPAPI";
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $path = $dir . DIRECTORY_SEPARATOR . md5($url);

        return $path;
    }

    /**
     * @inheritdoc
     */
    public function isCached($url)
    {
        $path = $this->urlToPath($url);
        if (!file_exists($path) || filectime($path) + $this->seconds < time()) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getCached($url)
    {
        return file_get_contents($this->urlToPath($url));
    }

    /**
     * @inheritdoc
     */
    public function setCached($url, $content)
    {
        file_put_contents($this->urlToPath($url), $content);
    }

    /**
     * @inheritdoc
     */
    public function setTempPath($path)
    {
        if (!is_dir($path)) {
            mkdir($path);
        }
        
        $this->tmp = $path;
    }
}