<?php
namespace Drupal\d8custom;

use Drupal\Core\Database\Connection;

class D8NodeCustomBlock {
  private $database;

  public function __construct(Connection $connection) {
    $this->database = $connection;
  }

  public function fetchNode() {
   $build = [];
   $result = $this->database->select('node_field_data', 'nfd') 
     ->fields('nfd', array('nid', 'title')) 
     ->execute() 
     ->fetchAll();
   foreach($result as $value) {
     $output['markup'] .= '|' . $value->title;
     $output['tags'] .= 'node'.$value->nid;
   }

   return $output;
  }

}

