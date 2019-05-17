<?php
namespace Drupal\d8_custom;

use Drupal\Core\Database\Connection;

class DicTableWrapper {

  /**
   * @var Connection
   */
  private $database;

  /**
   * DicTableWrapper constructor.
   * @param Connection $connection
   */
  public function __construct(Connection $connection) {
    $this->database = $connection;
  }

  /**
   * Helper function to read 1 record from the DIC table.
   * @return string
   */
  public function read() {
    return $this->database->select('d8_form_dic', 'dfd')
      ->fields('dfd', ['name'])
      ->range(0, 1)
      ->execute()->fetchField();
  }

  /**
   * Helper function to write data back to DIC table.
   *
   * @param string $name
   * @throws \Exception
   */
  public function write($name) {
    $this->database->insert('d8_form_dic')
      ->fields(['name'], [$name])
      ->execute();
  }

}
