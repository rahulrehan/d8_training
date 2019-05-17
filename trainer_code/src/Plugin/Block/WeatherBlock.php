<?php
namespace Drupal\d8_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\d8_custom\WeatherManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class WeatherBlock
 * @package Drupal\d8_custom\Plugin\Block
 *
 * @Block(
 *   id = "d8_custom_weather_block",
 *   admin_label = @Translation("Weather Block"),
 *   category = @Translation("Custom")
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var WeatherManager
   */
  private $weatherManager;

  /**
   * @inheritDoc
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, WeatherManager $weather_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weatherManager = $weather_manager;
  }

  /**
   * Builds and returns the renderable array for this block plugin.
   *
   * If a block should not be rendered because it has no content, then this
   * method must also ensure to return no content: it must then only return an
   * empty array, or an empty array with #cache set (with cacheability metadata
   * indicating the circumstances for it being empty).
   *
   * @return array
   *   A renderable array representing the content of the block.
   *
   * @see \Drupal\block\BlockViewBuilder
   */
  public function build() {
    $city_weather_data = $this->weatherManager->fetchWeatherData($this->configuration['city']);
    return [
      '#theme' => 'weather_info',
      '#temp' => $city_weather_data['temp'],
      '#pressure' => $city_weather_data['pressure'],
      '#humidity' => $city_weather_data['humidity'],
      '#temp_min' => $city_weather_data['temp_min'],
      '#temp_max' => $city_weather_data['temp_max'],
      '#attached' => [
        'library' => 'd8_custom/weather-widget',
      ],
    ];
  }

  /**
   * @inheritDoc
   */
  public function blockForm($form, FormStateInterface $form_state) {
    return [
      'city' => [
        '#type' => 'textfield',
        '#title' => 'City config for this block',
        '#default_value' => $this->getConfiguration()['city'],
      ],
    ];
  }

  /**
   * @inheritDoc
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('city', $form_state->getValue('city'));
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('d8_custom.weather_manager')
    );
  }

}
