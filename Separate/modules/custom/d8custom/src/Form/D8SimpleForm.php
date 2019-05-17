<?php
namespace Drupal\d8custom\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8custom\DicTableWrapper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

class D8SimpleForm extends FormBase implements ContainerInjectionInterface {

  private $dbWrapper;

  public function __construct(DicTableWrapper $db_wrapper, Request $request) {
    $this->dbWrapper = $db_wrapper;
    $this->request = $request;
  }
  public function getFormId() {
    return 'drupal8_custom_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $db_values = $this->dbWrapper->read();
    $form['FirstName'] = array(
      '#type' => 'textfield',
      '#title' => t('Name:'),
      '#required' => TRUE,
      '#maxlength' => 5,
      '#default_value' => $db_values->name,
    );
    $form['Email'] = array(
      '#type' => 'email',
      '#title' => t('Email:'),
      '#required' => TRUE,
      '#default_value' => '',
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen ( $form_state->getValue ( 'FirstName' ) ) < 5) {
      $form_state->setErrorByName ( 'FirstName', $this->t ( 'Name is too short.' ) );
		}
	}

  public function submitForm(array &$form, FormStateInterface $form_state) {
    #$FirstName = $form_state->getValue ( 'FirstName' );
    #drupal_set_message ( $FirstName .": Learning Drupal 8" );
  } 

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('d8custom.custom_database_comms'),
      $container->get('request')
    );
  }
	 
}
