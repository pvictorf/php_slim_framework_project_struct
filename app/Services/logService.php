<?php

namespace App\Services;
use Monolog\Logger;
use MySQLHandler\MySQLHandler;
use Boot\Bootstrap;

class Log {
   /**@var MySQLHandler */
   private $dbHandler;
   /**@var Logger */
   private $logger;

   public function __contruct($context = "web", $table = "log", $addtionalFields = ['user_id', 'user_email']) {
      $pdo = (new Bootstrap)->initializePDO();
      $this->dbHandler = new MySQLHandler($pdo, $table, $addtionalFields, \Monolog\Logger::DEBUG);
      $this->logger = new Logger($context);
      $this->logger->pushHandler( $this->dbHandler );
   }

   public function info($menssage = "Log", $context = [] ) {
      $this->logger->info($menssage, $context);
   }
}

