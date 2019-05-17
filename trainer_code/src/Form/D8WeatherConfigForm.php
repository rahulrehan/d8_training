<?php
namespace Drupal\d8_custom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class D8WeatherConfigForm
 * @package Drupal\d8_custom\Form
 */
class D8WeatherConfigForm extends ConfigFormBase {

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return [
      'd8_custom.weather_config',
    ];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'weather_app_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['app_id'] = [
      '#type' => 'textfield',
      '#title' => 'App id',
      '#description' => 'App id for my Openweathermap access.',
      '#default_value' => $this->config('d8_custom.weather_config')->get('app_id'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('d8_custom.weather_config')
      ->set('app_id', $form_state->getValue('app_id'))
      ->save();
    parent::submitForm($form, $form_state);
  }


}