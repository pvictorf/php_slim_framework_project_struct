<?php

namespace App\Services;
use Monolog\Logger;
use MySQLHandler\MySQLHandler;
use Boot\Bootstrap;

/*
 CREATE TABLE `log` (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    channel VARCHAR(255), 
    level INTEGER, 
    user_id VARCHAR(40), 
    origin_id VARCHAR(40), 
    message LONGTEXT, 
    record LONGTEXT,
    time INTEGER UNSIGNED, 
    INDEX(channel) USING HASH, 
    INDEX(level) USING HASH, 
    INDEX(time) USING BTREE
 ); 
 */

class LogService {
   /**@var MySQLHandler */
   private $dbHandler;
   /**@var Logger */
   private $logger;
   /**@var array|null */
   private $record;

   public function __construct($table = "log", $addtionalFields = ['user_id', 'origin_id'], $context = "web") {

      $pdo = (new Bootstrap)->initializePDO();
      $this->dbHandler = new MySQLHandler($pdo, $table, $addtionalFields, \Monolog\Logger::INFO);
     
      $this->logger = new Logger($context);
      $this->logger->pushHandler( $this->dbHandler );
      $this->record = implode('; ', [
         "HTTP_HOST=" . $_SERVER["HTTP_HOST"],
         "REQUEST_URI=" . $_SERVER["REQUEST_URI"],
         "REQUEST_METHOD=" . $_SERVER["REQUEST_METHOD"],
         "HTTP_USER_AGENT=" . $_SERVER["HTTP_USER_AGENT"],
         "REMOTE_ADDR=" . $_SERVER["REMOTE_ADDR"],
      ]);
   }

   public function getRecord() {
      return $this->record;
   }

   public function getLogger() {
      return $this->logger;
   }

   /**
     * This method created a new info log on database
     *
     * @param string $message The log message
     * @param array  $context The log context
     */
   public function info($menssage = "", $context = []) {
      $this->logger->info($menssage, $context);
   }
}

