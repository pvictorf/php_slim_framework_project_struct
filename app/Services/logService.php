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

   public function __contruct($context = "web") {
      $pdo = (new Bootstrap)->initializePDO();
      $this->dbHandler = new MySQLHandler($pdo, "log", array('username', 'userid'), \Monolog\Logger::DEBUG);
      $this->logger = new Logger($context);
      $this->logger->pushHandler( $this->dbHandler );
   }

   public function info($menssage = "Log", $context = [] ) {
      $this->logger->info($menssage, $context);
   }
}

