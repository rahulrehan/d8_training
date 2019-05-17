<?php

namespace Drupal\d8custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 

/**
 * Provides a 'Fetch User' Block.
 *
 * @Block(
 *   id = "fetch_user_data_block",
 *   admin_label = @Translation("Fetch User Data Block"),
 *   category = @Translation("Custom"),
 * )
 */
class FetchUserDataBlock extends BlockBase implements ContainerFactoryPluginInterface{

  private $fetchUserDataManager;

  // Override the block base constructor
  // Added $fetch_user_data_manager by own in the below constructor to get our service instance
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxy $fetch_user_data_manager) {

    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->fetchUserDataManager = $fetch_user_data_manager;
	
  }

  public function build() {
    return array (
      '#markup' => $this->fetchUserDataManager->getEmail(),
      '#cache' => array(
        'tags' => array(
          'node_list',
        ),
        'contexts' => array(
          'user',
        )
      )
    );
  }

  // This is the inbuild function in the 'ContainerFactoryPluginInterface' required to fetch the data from Service mention in it and providing further it to the constructor above that we are overriding.
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static (
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user') //from service name in service.yml
    );
  }
}

