<?php

namespace  Drupal\d8custom\Event;
use Symfony\Component\EventDispatcher\Event;
use Drupal\node\Entity\Node;

class D8NodeInsertEvent extends Event {
  CONST NODE_INSERT = 'node.insert';

  private $node;

  public function __construct(Node $node) {
    $this->node = $node;
  }

  public function getNode() {
    return $this->node;
  }

  public function setNode() {
    $this->node = $node;
  }
}
