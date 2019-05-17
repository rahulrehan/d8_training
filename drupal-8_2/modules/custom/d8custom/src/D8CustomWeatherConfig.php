<?php
namespace Drupal\d8custom;

use GuzzleHttp\Client;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Component\Serialization\Json;

class D8CustomWeatherConfig {
  private $client;
  private $configFactory;

  public function __construct($client, $config_factory) {
    $this->client = $client;
    $this->configFactory = $config_factory;
  }

  public function fetchWeatherData($city){
    $ApiKey = $this->configFactory->get('d8custom.weather_configuration')->get('apikey');
    $weatherUrl = "http://localhost/drupal-8_2/weather-".$city.".json";
    /*
    $url = "https://api.openweathermap.org/data/2.5/weather?q=".$city."&appid=".$ApiKey;

    $client = \Drupal::httpClient();
    $res = $client->request('GET', $url);
    echo $res->getStatusCode();
    // "200"
     echo $res->getHeader('content-type')[0];
    // 'application/json; charset=utf8'
    echo $res->getBody();
    */
    $res = $this->client->get($weatherUrl);
    if( $res->getStatusCode() == 200 ) {
      $weatherjson = $res->getBody();
      return $weatherData = Json::decode($weatherjson)['main'];
    }
  }


}

