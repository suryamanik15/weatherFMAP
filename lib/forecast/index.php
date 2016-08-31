<?php
/**
 * The Weather class provides the current weather forecast for the next 5 days
 * 
 * -- FREE REGISTER --
 * Register to get your key to access the API in: 
 * http://developer.worldweatheronline.com/member/register/
 * 
 */
// The Weather class
require_once 'WeatherForecast.class.php';

// Defines the API key provided to register his candidacy
$weather = new WeatherForecast('YOUR_API_KEY');

// Defines the name of the city, the country and the number of days of forecast (between 1 and 5)
$weather->setRequest('New York', 'United States Of America', 5);

// Defines the US unit of measurement
$weather->setUSMetric(true);

// Defines enabling caching of requests and optionally the lifetime of cache file in seconds
#$weather->setCaching(true, 3600);

// Defines the display of the error message on failure
#$weather->setDisplayError(false);
?>
<html> 
    <head>
        <title>Weather Forecast</title>
        <link rel="stylesheet" href="screen.css" media="screen" />
    </head>
    <body>
        <?php
        // API call
        $response = $weather->getLocalWeather();

        if ($weather::$has_response) {
            ?>

            <h1><?php echo $response->locality; ?></h1>

            <h2>The Weather Today at <?php echo $response->weather_now['weatherTime']; ?></h2>

            <div class="weather_now">
                <span style="float:right;"><img src="<?php echo $response->weather_now['weatherIcon']; ?>" /></span>
                <strong>DESCRIPTION:</strong> <?php echo $response->weather_now['weatherDesc']; ?><br />
                <strong>TEMPERATURE:</strong> <?php echo $response->weather_now['weatherTemp']; ?><br />
                <strong>WIND SPEED:</strong> <?php echo $response->weather_now['windSpeed']; ?><br />
                <strong>PRECIPITATION:</strong> <?php echo $response->weather_now['precipitation']; ?><br />
                <strong>HUMIDITY:</strong> <?php echo $response->weather_now['humidity']; ?><br />
                <strong>VISIBILITY:</strong> <?php echo $response->weather_now['visibility']; ?><br />
                <strong>PRESSURE:</strong> <?php echo $response->weather_now['pressure']; ?><br />
                <strong>CLOUD COVER:</strong> <?php echo $response->weather_now['cloudcover']; ?><br />
            </div>

            <h3>Weather Forecast</h3>

            <?php
            foreach ($response->weather_forecast as $weather) {
                ?>
                <div class="weather_forecast">
                    <div class="block block1">
                        <span class="icon"><img src="<?php echo $weather['weatherIcon']; ?>" /></span>
                    </div>
                    <div class="block block2">
                        <span class="wday"><?php echo $weather['weatherDay']; ?></span>
                        <span class="date"><?php echo $weather['weatherDate']; ?> </span>
                        <span class="desc"><?php echo $weather['weatherDesc']; ?></span>
                        <span class="wind">Wind: <?php echo $weather['windDirection']; ?> at <?php echo $weather['windSpeed']; ?></span>
                    </div>
                    <div class="block block3">
                        <span class="tmax"><?php echo $weather['tempMax']; ?></span>
                        <span class="tmin"><?php echo $weather['tempMin']; ?></span>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </body>
</html>