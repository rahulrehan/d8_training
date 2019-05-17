<?php
namespace Drupal\d8_custom;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactory;
use Exception;
use GuzzleHttp\Client;
use JsonSchema\Exception\ResourceNotFoundException;

/**
 * Class WeatherManager
 * @package Drupal\d8_custom
 */
class WeatherManager {
  /**
   * @var ConfigFactory
   */
  private $configFactory;

  /**
   * @var Client
   */
  private $client;

  /**
   * WeatherManager constructor.
   * @param Client $client
   * @param ConfigFactory $config_factory
   */
  public function __construct(Client $client, ConfigFactory $config_factory) {
    $this->client = $client;
    $this->configFactory = $config_factory;
  }

  /**
   * Helper function to fetch weather data based on the city name.
   *
   * @param $city
   * @return mixed
   */
  public function fetchWeatherData($city) {
    $app_id = $this->configFactory->get('d8_custom.weather_config')->get('app_id');
    $url_string = "https://api.openweathermap.org/data/2.5/weather?q=" . $city . "&appid=" . $app_id;
    try {
      $res = $this->client->get($url_string);
      return Json::decode($res->getBody()->getContents())['main'];
    }
    catch (Exception $e) {
      return 'An error occured while fetching data';
    }
  }

}
