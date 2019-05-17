<?php
namespace Drupal\d8custom\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Access\AccessResult;

class D8EntityAccessCheck implements AccessInterface {
  public function access(Node $node, AccountInterface $account) {
    return AccessResult::allowedIf($node->getOwnerId() == $account->id());
  }
}

