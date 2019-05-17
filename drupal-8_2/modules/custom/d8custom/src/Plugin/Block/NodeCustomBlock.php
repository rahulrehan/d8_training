<?php

namespace Drupal\d8custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8custom\D8NodeCustomBlock;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 

/**
 * Provides a 'Node Custom' Block.
 *
 * @Block(
 *   id = "node_custom_block",
 *   admin_label = @Translation("Node Custom Block"),
 *   category = @Translation("Custom"),
 * )
 */
class NodeCustomBlock extends BlockBase implements ContainerFactoryPluginInterface{

  private $nodeCustomManager;

  // Override the block base constructor
  // Added $nodeCustom_manager by own in the below constructor to get our service instance
  public function __construct(array $configuration, $plugin_id, $plugin_definition, D8NodeCustomBlock $nodeCustom_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->nodeCustomManager = $nodeCustom_manager;	
  }

  public function build() {
    return array (
      '#markup' => $this->nodeCustomManager->fetchNode(),
    );
  }

  // This is the inbuild function in the 'ContainerFactoryPluginInterface' required to fetch the data from Service mention in it and providing further it to the constructor above that we are overriding.
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static (
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('d8custom.node_custom_block_service') //from service name in service.yml
    );
  }
}

