<?php
namespace Drupal\d8custom\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

class D8customController extends ControllerBase{
  public function customRender(){
    return array(
      '#markup' => t('I am in the First static controller')
    );
  }

  public function dynamic_route($name){
    return array(
      '#markup' => t('Hello @name', array('@name' => $name))
    );
  }


  public function node_load(Node $node) {

    return array(
     '#markup' => t ('@node', array ('@node' => $node->getTitle ()) )
    );
  } 

  public function content_type_load(User $node1, Node $node2){
    return array(
      '#markup' => t ('@node1 -- @node2', array ('@node1' => $node1->getTitle (), '@node2' => $node2->getTitle ()) )
    );
  }

  public function static_route(){
    return array(
      '#markup' => t('I am in the Second static controller')
    );
  }

  public function settings(){
    return array(
      '#markup' => t('I am in Admin section')
    );
  }


  public function dynamic_routing(Node $node){
    return array(
     '#markup' => t ('@node', array ('@node' => $node->getTitle ()) )
    );
  }

  public function entity_access_check(Node $node, AccountInterface $account) {
    # return AccessResult::allowedIf($node->getOwnerId() == $account->id());
  }
}

