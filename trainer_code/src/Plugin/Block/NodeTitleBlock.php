<?php

namespace Drupal\d8_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Provides a 'NodeTitleBlock' block.
 *
 * @Block(
 *  id = "node_title_block",
 *  admin_label = @Translation("Node title block"),
 * )
 */
class NodeTitleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * Constructs a new NodeTitleBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param Connection $database
   *   The database connection object.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    Connection $database
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = $tags = [];
    $output = '';

    $query = $this->database->select('node_field_data', 'nfd')
      ->fields('nfd', ['nid', 'title'])
      ->range(0,3)
      ->orderBy('nid', 'DESC')
      ->execute();

    $results = $query->fetchAll();

    foreach ($results as $result) {
      $output .= '|' . $result->title;
      $tags[] = 'node:' . $result->nid;
    }

    $build['node_title_block']['#markup'] = $output;
    $build['node_title_block']['#cache']['tags'] = array_merge($tags, ['node_list']);

    return $build;
  }

}
