<?php

/**
 * The WeatherForecast class allows you to access current weather conditions and the next 5 days of accurate and reliable weather forecast. 
 * The Local Weather API returns weather elements such as temperature, precipitation (rainfall), weather description, weather icon and wind speed.
 * 
 * Credits to World Weather Online <http://www.worldweatheronline.com>
 * 
 * @author Giovanni Ramos <giovannilauro@gmail.com>
 * @copyright 2012-2013, Giovanni Ramos
 * @since 2012-10-08
 * @link http://github.com/giovanniramos/WeatherForecast
 * @category Weather Forecast
 * @version 1.2
 * 
 * */
class WeatherForecast
{
    /**
     * API call
     * 
     * @access private static
     * @var array
     * 
     * */
    private static $request = array(
        'local' => 'http://api.worldweatheronline.com/free/v1/weather.ashx'
    );

    /**
     * US metric
     * 
     * @access private static
     * @var boolean
     * 
     * */
    private static $us_metric = true;

    /**
     * Display error status
     * 
     * @access private static
     * @var boolean
     * 
     * */
    private static $display_error = true;

    /**
     * Enable caching of the requests
     * 
     * @access private static
     * @var boolean
     * 
     * */
    private static $caching = true;

    /**
     * Lifetime of the cache file
     * 
     * @access private static
     * @var int
     * 
     * */
    private static $cache_life = 3600;

    /**
     * API Key
     * 
     * @access private static
     * @var string
     * 
     * */
    private static $key;

    /**
     * Stores the return request
     * 
     * @access private static
     * @var object
     * 
     * */
    private static $doc;

    /**
     * City name
     * 
     * @access private static
     * @var string
     * 
     * */
    private static $city;

    /**
     * Country name
     * 
     * @access private static
     * @var string
     * 
     * */
    private static $country;

    /**
     * Number of days to display
     * 
     * @access private static
     * @var int
     * 
     * */
    private static $num_of_days;

    /**
     * If the request has a weather forecast, is set to TRUE
     * 
     * @access public static
     * @var boolean
     * 
     * */
    public static $has_response = false;

    /**
     * Register to get your Key to access the API in:
     * http://developer.worldweatheronline.com/member/register/
     *
     * @param string $key API Key
     */
    public function __construct($key = null)
    {
        if ($key == 'YOUR_API_KEY')
            exit('You have not defined an API key to get climate data.');

        self::setKey($key);
    }

    /**
     * Defines the API Key
     * 
     * @param string $key API Key
     */
    private static function setKey($key)
    {
        self::$key = (string) $key;
    }

    /**
     * Returns the API Key
     * 
     * @return string
     */
    private static function getKey()
    {
        return self::$key;
    }

    /**
     * Defines the US unit of measurement
     * 
     * @param boolean $us_metric US metric (default: TRUE)
     */
    public static function setUSMetric($us_metric = true)
    {
        self::$us_metric = (boolean) $us_metric;
    }

    /**
     * Defines the display of the error message on failure
     * 
     * @param boolean $display_error Display error status (default: TRUE)
     */
    public static function setDisplayError($display_error = true)
    {
        self::$display_error = (boolean) $display_error;
    }

    /**
     * Defines enabling caching of requests
     * 
     * @param boolean $caching Enable caching (default: TRUE)
     * @param int $cache_life Lifetime of the cache in seconds (default: 1 HOUR = 3600)
     */
    public static function setCaching($caching = true, $cache_life = 3600)
    {
        self::$caching = (boolean) $caching;
        self::$cache_life = (int) $cache_life;
    }

    /**
     * Defines the name of the city
     * 
     * @param string $city City name
     */
    private static function setCity($city)
    {
        self::$city = (string) self::slug($city);
    }

    /**
     * Defines the name of the country
     * 
     * @param string $country Country name
     */
    private static function setCountry($country)
    {
        self::$country = (string) self::slug($country);
    }

    /**
     * Defines the number of days to display
     * 
     * @param int $num_of_days Number of days
     */
    private static function setNumOfDays($num_of_days)
    {
        self::$num_of_days = (int) $num_of_days;
    }

    /**
     * Defines the request parameters
     * 
     * @param string $city City name
     * @param string $country Country name
     * @param int $num_of_days Number of days to display: 1 to 5
     */
    public static function setRequest($city = null, $country = null, $num_of_days = 1)
    {
        // Sets the request parameters
        self::setCity($city);
        self::setCountry($country);
        self::setNumOfDays($num_of_days);
    }

    /**
     * Returns data from the weather
     * 
     * @param string $type_of_request Type of the URL of the request
     * @return SimpleXMLIterator Object
     */
    private function getRequest($type_of_request = 'local')
    {
        // Gets the unique key of the API
        $key = self::getKey();
        if (empty($key)) {
            exit('The API key is missing.');
        }

        // Gets the City name
        $city = self::$city;

        // Gets the Country name
        $country = self::$country ? ',' . self::$country : null;

        // Gets the Number of days to display
        $num_of_days = self::$num_of_days;

        // Checks if has been set the city
        if (empty($city)) {
            exit('You can specify the location for any of these options: City and Town Name, IP Address, UK Postcode, Canada Postal Code, US Zipcode and Latitude and Longitude (in decimal).');
        }

        // Stores the request URL
        $request = self::$request[$type_of_request] . '?q=' . $city . $country . '&format=xml&num_of_days=' . $num_of_days . '&key=' . $key;

        // Caching disabled
        if (self::$caching == false) {
            $doc = simplexml_load_file($request, 'SimpleXMLElement', LIBXML_NOCDATA);

            if ($doc === FALSE) {
                exit('Data could not be retrieved for location: <strong>' . self::$city . '-' . self::$country . '</strong>.');
            }

            // Stops the script if there errors
            if (isset($doc->error)) {
                $msg = !empty($doc->error->msg) ? $doc->error->msg : 'Data could not be retrieved.';

                if (self::$display_error) {
                    exit('<strong style="color:red;">' . $msg . '</strong>');
                }
            }

            self::$has_response = true;

            return self::$doc = $doc;
        } else {
            // Cache file
            $cache_file = 'cache/cached-' . (substr($key, 0, 8) . '-' . $city . $country) . '.xml';

            // Generates the cache file if it does not exist or has expired life time
            $filemtime = @filemtime($cache_file);
            if (!$filemtime || (time() - $filemtime >= self::$cache_life)) {
                // Starts the request to cache
                $contents = @file_get_contents($request);

                // Reads the request and checks for errors
                $doc = simplexml_load_string($contents);

                // Does not make the file cache on error
                if (isset($doc->error)) {
                    $msg = !empty($doc->error->msg) ? $doc->error->msg : 'Data could not be retrieved.';

                    if (self::$display_error) {
                        exit('<strong style="color:red;">' . $msg . '</strong>');
                    }
                } else {
                    file_put_contents($cache_file, $contents);
                }
            }

            // Initiates the request
            if (filesize($cache_file) > 0) {
                $doc = simplexml_load_file($cache_file);

                self::$has_response = true;

                return self::$doc = $doc;
            } else {
                return null;
            }
        }
    }

    /**
     * Returns the request
     * 
     * @return mixed
     */
    public function getLocalWeather()
    {
        $doc = self::getRequest('local');

        // Displays a message if no data returned
        if (!isset($doc->request)) {
            exit('The weather conditions were not found.');
        }

        $locality = $doc->request->query;
        $current = $doc->current_condition;

        $new_doc = new stdClass();
        $new_doc->locality = (string) $locality . ' Weather in ' . date('d/m/Y', time());
        $new_doc->weather_now = array(
            "weatherTime" => (string) $current->observation_time,
            "weatherTemp" => (self::$us_metric ? $current->temp_F : $current->temp_C) . '&#176',
            "weatherDesc" => (string) $current->weatherDesc,
            "weatherCode" => (string) $current->weatherCode,
            "weatherIcon" => (string) $current->weatherIconUrl,
            "windDirection" => (string) $current->winddir16Point,
            "windSpeed" => (self::$us_metric ? $current->windspeedMiles . ' mph' : $current->windspeedKmph . 'km/h'),
            "precipitation" => (string) $current->precipMM, // Precipitation in millimetres
            "humidity" => (string) $current->humidity . '%', // Humidity in percentage
            "visibility" => (string) $current->visibility, // Visibility in kilometres
            "pressure" => (string) $current->pressure, // Atmospheric pressure in millibars
            "cloudcover" => (string) $current->cloudcover // Cloud cover in percentage
        );

        foreach ($doc->weather as $weather) {
            $ndate = strtotime($weather->date);
            $year = date('Y', $ndate);
            $month = date('M', $ndate);
            $day = date('d', $ndate);

            $weather_date = $month . ' ' . $day;
            $weather_day = mb_strtoupper(date('l', $ndate));
            $weather_desc = (string) $weather->weatherDesc;
            $weather_code = (string) $weather->weatherCode;
            $weather_icon = (string) $weather->weatherIconUrl;
            $weather_wdir = (string) $weather->winddir16Point;
            $weather_wind = (self::$us_metric ? $weather->windspeedMiles . ' mph' : $weather->windspeedKmph . 'km/h');
            $weather_max = (self::$us_metric ? $weather->tempMaxF : $weather->tempMaxC) . '&#176';
            $weather_min = (self::$us_metric ? $weather->tempMinF : $weather->tempMinC) . '&#176';

            $arr_weather[] = array(
                "weatherDate" => $weather_date,
                "weatherDay" => $weather_day,
                "weatherDesc" => $weather_desc,
                "weatherCode" => $weather_code,
                "weatherIcon" => $weather_icon,
                "windDirection" => $weather_wdir,
                "windSpeed" => $weather_wind,
                "tempMax" => $weather_max,
                "tempMin" => $weather_min
            );

            $new_doc->weather_forecast = (object) $arr_weather;
        }

        return $new_doc;
    }

    /**
     * Converts a string of special characters
     * 
     * @param string $term The input string
     * @return string
     */
    protected static function normalize($term)
    {
        if (is_array($term)) {
            foreach ($term as $value) {
                return normalize($value);
            }
        }

        $chars = array(
            'a' => '/à|á|â|ã|ä|å|æ/',
            'e' => '/è|é|ê|ë/',
            'i' => '/ì|í|î|ĩ|ï/',
            'o' => '/ò|ó|ô|õ|ö|ø/',
            'u' => '/ù|ú|û|ű|ü|ů/',
            'A' => '/À|Á|Â|Ã|Ä|Å|Æ/',
            'E' => '/È|É|Ê|Ë/',
            'I' => '/Ì|Í|Î|Ĩ|Ï/',
            'O' => '/Ò|Ó|Ô|Õ|Ö|Ø/',
            'U' => '/Ù|Ú|Û|Ũ|Ü|Ů/',
            '_' => '/`|´|\^|~|¨|ª|º|©|®/',
            'c' => '/ć|ĉ|ç/',
            'C' => '/Ć|Ĉ|Ç/',
            'd' => '/ð/',
            'D' => '/Ð/',
            'n' => '/ñ/',
            'N' => '/Ñ/',
            'r' => '/ŕ/',
            'R' => '/Ŕ/',
            's' => '/š/',
            'S' => '/Š/',
            'y' => '/ý|ŷ|ÿ/',
            'Y' => '/Ý|Ŷ|Ÿ/',
            'z' => '/ž/',
            'Z' => '/Ž/',
        );

        return preg_replace($chars, array_keys($chars), $term);
    }

    /**
     * Filters a string into a "friendly" string for use in URL's
     * 
     * @param string $term The input string
     * @return string
     */
    protected static function slug($term)
    {
        $term = mb_strtolower($term, 'UTF-8');
        $term = preg_replace('~[\s]+~', '+', $term);
        $term = self::normalize($term);

        return $term;
    }

    /**
     * Converts a string from Fahrenheit to Celsius
     * 
     * @param string $term The input string
     * @return string
     */
    protected function convertFtoC($term)
    {
        $term = ceil((($term - 32) / 9) * 5);

        return $term;
    }

}
