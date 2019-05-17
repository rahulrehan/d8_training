<?php
namespace Drupal\d8_custom\Plugin\Block;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class D8UserEmail
 * @package Drupal\d8_custom\Plugin\Block
 *
 * @Block(
 *   id = "d8_user_email",
 *   admin_label = @Translation("D8 User Email Block")
 * )
 */

class D8UserEmail extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * @var AccountProxy
   */
  private $account;

  /**
   * D8UserEmail constructor.
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param AccountProxy $account
   */
  public function __construct(array $configuration, 
                              $plugin_id, 
                              $plugin_definition, 
                              AccountProxy $account) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->account = $account;
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
    return [
      '#markup' => $this->account->getEmail(),
      '#cache' => [
        'contexts' => ['session', 'user'],
      ],
    ];
  }

  /**
   * Creates an instance of the plugin.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container to pull out services used in the plugin.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   *
   * @return static
   *   Returns an instance of this plugin.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }


}