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
   private $context;

   public function __construct($table = "log", $addtionalFields = ['record'], $context = "web") {
      $pdo = (new Bootstrap)->initializePDO();
      $this->dbHandler = new MySQLHandler($pdo, $table, $addtionalFields, \Monolog\Logger::DEBUG);
     
      $this->logger = new Logger($context);
      $this->logger->pushHandler( $this->dbHandler );
      $this->logger->pushProcessor(function($record) {
         $record["extra"]["HTTP_HOST"] = $_SERVER["HTTP_HOST"];
         $record["extra"]["REQUEST_URI"] = $_SERVER["REQUEST_URI"];
         $record["extra"]["REQUEST_METHOD"] = $_SERVER["REQUEST_METHOD"];
         $record["extra"]["HTTP_USER_AGENT"] = $_SERVER["HTTP_USER_AGENT"];
         $record["extra"]["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"];

         return $record;
      });

      $this->context = $this->logger->getProcessors();
   }

   public function info($menssage = "Log") {
      
      $this->logger->info($menssage, ['record' => $this->context]);
   }
}

