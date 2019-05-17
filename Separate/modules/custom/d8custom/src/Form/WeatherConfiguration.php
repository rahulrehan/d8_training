<?php
namespace Drupal\d8custom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class WeatherConfiguration extends ConfigFormBase  {

  protected function getEditableConfigNames(){
    return [
      'd8custom.weather_configuration',
    ];
  }

  public function getFormId() {
    return 'weather_configuration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['apikey'] = array(
      '#type' => 'textfield',
      '#title' => t('API Key'),
      '#required' => TRUE,
      '#default_value' => $this->config('d8custom.weather_configuration')->get('apikey'),
    );
    return parent::buildform ($form, $form_state);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (empty( $form_state->getValue ( 'apikey' ) )) {
      $form_state->setErrorByName ( 'apikey', $this->t ( "API Key shouldn't be empty" ) );
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('d8custom.weather_configuration')
         ->set('apikey', $form_state->getValue('apikey'))
         ->save();
    return parent::submitForm ($form, $form_state);
  }
}
