<?php

namespace App\Services;
use Monolog\Logger;
use MySQLHandler\MySQLHandler;
use Boot\Bootstrap;

class LogService {
   /**@var MySQLHandler */
   private $dbHandler;
   /**@var Logger */
   private $logger;

   public function __construct($table = "log", $addtionalFields = [], $context = "web") {
      $pdo = (new Bootstrap)->initializePDO();
      $this->dbHandler = new MySQLHandler($pdo, $table, $addtionalFields, \Monolog\Logger::DEBUG);
      $this->logger = new Logger($context);
      $this->logger->pushHandler( $this->dbHandler );
   }

   public function info($menssage = "Log", $context = ["info" => true] ) {
      $this->logger->info($menssage, $context);
   }
}

