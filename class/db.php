<?php

/*
 * database stuff
 * 
 * @author oli
 * 
 * 
 * CREATE TABLE `songcontest`.`contestant` (
  `cId` INT NOT NULL AUTO_INCREMENT,
  `cName` VARCHAR(45) NOT NULL,
  `cPrefGenre` VARCHAR(45) NULL,
  `cTimestamp` DATETIME NOT NULL,
  PRIMARY KEY (`cId`),
  UNIQUE INDEX `cId_UNIQUE` (`cId` ASC) VISIBLE);
 * 
 * CREATE TABLE `songcontest`.`judges` (
  `jId` INT NOT NULL AUTO_INCREMENT,
  `jName` VARCHAR(45) NULL,
  `jPrefGenre` VARCHAR(45) NULL,
  `judgescol` VARCHAR(45) NULL,
  `jTimestamp` DATETIME NULL,
  PRIMARY KEY (`jId`),
  UNIQUE INDEX `jId_UNIQUE` (`jId` ASC) VISIBLE);

 */

class Db {
    
    
  private $dbName = "songcontest";
  private $dbHost = "localhost";
  private $dbUser = "root";
  private $dbPass = "l0c4lh05t";
  private $dbPort = 3306;
  
  private $connection;
  /**
  * Sets the connection credentials to connect to your database.
  *
  * @param boolean $autoconnect
  */
  function __construct($autoconnect) {
      
    $autoconnect ? $this->open() : false;
  }
  
  /**
  * Open the connection to your database.
  */
  function open() {
    $this->connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName, $this->dbPort);
  }
  
  /**
  * Close the connection to your database.
  */
  function close() {
    $this->connection->close();
  }
  
  /**
  *
  * Execute your query
  *
  * @param string $query - your sql query
  * @return the result of the executed query 
  */
  function query($query) {
    return $this->connection->query($query);
  }
  
  /**
  * escape
  *
  * @param string
  * @return string
  */
  function escape($string) {
    return $this->connection->escape_string($string);
  }
}
?>
