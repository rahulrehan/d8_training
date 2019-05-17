<?php

namespace Drupal\d8custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8custom\D8CustomWeatherConfig;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 

/**
 * Provides a 'Weather' Block.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("Weather Block"),
 *   category = @Translation("Custom"),
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface{
  private $weatherManager;

  // Added $weather_manager by own in the below constructor to get our service instance
  public function __construct(array $configuration, $plugin_id, $plugin_definition, D8CustomWeatherConfig $weather_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weatherManager = $weather_manager;	
  }
  public function build() {
    $cityWeatherData = $this->weatherManager->fetchWeatherData($this->configuration['city']);
	
    return array (
      '#theme' => 'weather_info',
      '#temp' => $cityWeatherData['temp'],
      '#pressure' => $cityWeatherData['pressure'],
      '#humidity' => $cityWeatherData['humidity'],
      '#temp_min' => $cityWeatherData['temp_min'],
      '#temp_max' => $cityWeatherData['temp_max'],
      '#attached' => [
        'library' => 'd8custom/weather-widget',
      ],
    );
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter city'),
      '#default_value' => isset($config['city']) ? $config['city'] : 'mumbai',
    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('city', $form_state->getValue('city'));
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static (
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('d8custom.weather_configuration_service') //from service name in service.yml
    );
  } 
}

