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
   $output = '';
   $result = $this->database->select('node_field_data', 'nfd') 
     ->fields('nfd', array('title')) 
     ->execute() 
     ->fetchAll();
   foreach($result as $value) {
     $output .= '|' . $value->title;
   }

   return $output;
  }

}

