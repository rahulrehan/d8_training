<?php
namespace Drupal\d8_custom\Event;

use Drupal\node\Entity\Node;
use Symfony\Component\EventDispatcher\Event;

class D8NodeInsertEvent extends Event {

  /**
   * Event Name.
   */
  CONST NODE_INSERT = 'node.insert';

  /**
   * @var Node
   */
  private $node;

  /**
   * D8NodeInsertEvent constructor.
   * @param Node $node
   */
  public function __construct(Node $node) {
    $this->node = $node;
  }

  public function getNode() {
    return $this->node;
  }

  /**
   * @param Node $node
   */
  public function setNode(Node $node) {
    $this->node = $node;
  }


}