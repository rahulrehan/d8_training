<?php
namespace Drupal\d8custom;

use Drupal\Core\Database\Connection;

class D8CustomDatabaseComms {
  private $database;

  public function __construct(Connection $connection) {
    $this->database = $connection;
  }

  public function dbread($serviceID) {
  $results = $this->database->select('custom_service', 'cs')
    ->fields('cs', ['FirstName', 'Email'])
    ->condition('serviceID', $serviceID, '=')
    ->execute()
    ->fetchAll();

    return array_shift($results);
  }

  public function dbwrite($insert, $email) {
  $fields = array(
    'FirstName' => $insert,
    'Email' => $email,
    'Created' => '000000000',
  );
  $this->database->insert('custom_service')
    ->fields($fields)
    ->execute(); 
  return 'Success';
  }

}

