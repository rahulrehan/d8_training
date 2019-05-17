<?php
namespace Drupal\d8_custom\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;

class D8CustomController extends ControllerBase {

  public function staticContent() {
    return [
      '#markup' => "Hello world",
    ];
  }

  public function dynamicContent($arg) {
    return [
      '#markup' => $this->t("Dynamic arg passed: @arg", [ '@arg' => $arg ]),
    ];
  }

  public function entityContent(Node $node) {
    return [
      '#markup' => $node->getTitle(),
    ];
  }

  public function entityContentMultiple(Node $node1, Node $node2) {
    return [
      '#markup' => $node1->getTitle() . '====' . $node2->getTitle(),
    ];
  }

  public function anotherStaticContent() {
    return [
      '#markup' => "Hello world from another world!",
    ];
  }

  public function entityAccessCheck(Node $node,
                                    AccountInterface $account) {
    return AccessResult::allowedIf($node->getOwnerId() == $account->id());
  }
}
