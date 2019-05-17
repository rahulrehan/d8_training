<?php
namespace Drupal\d8_custom\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8_custom\DicTableWrapper;
use Symfony\Component\DependencyInjection\ContainerInterface;

class D8SimpleForm extends FormBase {

  /**
   * @var DicTableWrapper
   */
  private $dbWrapper;

  /**
   * D8SimpleForm constructor.
   * @param DicTableWrapper $db_wrapper
   */
  public function __construct(DicTableWrapper $db_wrapper) {
    $this->dbWrapper = $db_wrapper;
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
    return 'd8_simple_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => 'Enter your Name',
      '#description' => 'Name must have at least 5 characters',
      '#default_value' => $this->dbWrapper->read(),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Validate First Name',
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    if (strlen($form_state->getValue('name')) < 5) {
      $form_state->setErrorByName('name', 'Name must be at least 5 characters long!');
    }
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->dbWrapper->write($form_state->getValue('name'));
    drupal_set_message('Name value submitted successfully: ' . $form_state->getValue('name'));
  }

  /**
   * @param ContainerInterface $container
   * @return FormBase|void
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('d8_custom.dic_table_wrapper')
    );
  }


}