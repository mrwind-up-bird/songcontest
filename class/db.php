<?php

/*
 * database stuff
 * 
 * @author oli
 * 
 * 
CREATE TABLE `songcontest`.`history` (
  `history_id` INT NOT NULL AUTO_INCREMENT,
  `contest` VARCHAR(50) NOT NULL,
  `name` VARCHAR(45) NULL,
  `score` INT NULL,
  `ts` TIMESTAMP DEFAULT CURRENT TIMESTAMP,
  PRIMARY KEY (`history_id`),
  UNIQUE INDEX `history_id_UNIQUE` (`history_id` ASC) VISIBLE);

 */

class Db {
    
    
  private $dbName;
  private $dbHost;
  private $dbUser;
  private $dbPass;
  private $dbPort = 3306;
  
  private $connection;
  private $resultSet;
  /**
  * Sets the connection credentials to connect to your database.
  *
  * @param boolean $autoconnect
  */
  public function __construct($credentials, $autoconnect = true) {
    
    $this->dbHost = $credentials->dbHost;
    $this->dbName = $credentials->dbName;
    $this->dbPass = $credentials->dbPass;
    $this->dbUser = $credentials->dbUser;
    $this->dbPort = $credentials->dbPort;

    $autoconnect ? $this->open() : false;
  }
  
  /**
  * Open the connection to your database.
  */
  public function open() {
    $this->connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName, $this->dbPort);
  }
  
  /**
  * Close the connection to your database.
  */
  public function close() {
    $this->connection->close();
  }
  
  /**
  *
  * Execute your query
  *
  * @param object $query - your sql query
  * @return the result of the executed query 
  */
  function query($query) {
    return $this->resultSet = $this->connection->query($query);
  }
  
  /**
   * the result
   * 
   * @return array
   */
  public function getResult() : array {
      return mysqli_fetch_all($this->resultSet,MYSQLI_ASSOC);
  }
  
  /**
   * execute query
   * 
   */
  public function execute() {
      mysqli_execute($this->resultSet);
  }
  
  
  
  /**
  * escape
  *
  * @param string
  * @return string
  */
  public function escape($string) : string {
    return $this->connection->escape_string($string);
  }
}
?>
