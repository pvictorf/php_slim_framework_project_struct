<?php

namespace Boot;

use Slim\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use League\Plates\Engine;


final class Bootstrap
{

   public function __invoke(): \Slim\Container
   {

      //Inject dependencies in container
      $settings = $this->setDefaultSettings();
      $container = new \Slim\Container($settings);
      

      //Init database driver, by default Eloquent ORM
      $container['db'] = $this->initializeEloquent($settings);
      #$container['db'] = $this->initializePDO($settings);


      //Init view template engine, by default LeaguePlates
      $container['view'] = $this->initializeLeaguePlates();
      #$container['view'] = $this->initializeTwigTemplates(new Container());

      return $container;
   }

   /**
    * Set default settings to App
    */
   private function setDefaultSettings()
   {
      //Php Configuration
      date_default_timezone_set(getenv('DEFAULT_TIMEZONE'));

      //Slim Configuration
      $config = [
         'settings' => [
            'displayErrorDetails' => getenv('DISPLAY_ERROS_DETAILS'),
            'determineRouteBeforeAppMiddleware' => false,
            'db' => [
               'driver'   => 'mysql',
               'host'     => getenv('MYSQL_HOST'),
               'database' => getenv('MYSQL_DBNAME'),
               'username' => getenv('MYSQL_USER'),
               'password' => getenv('MYSQL_PASS'),
               'charset'  => 'utf8',
               'collation'=> 'utf8_unicode_ci',
               'prefix'   => '',
            ],
            /* Uncoment if you want use monolog */
            /*
            'logger' => [
              'name' => 'slim-app',
              'level' => \Monolog\Logger::DEBUG,
              'path' => __DIR__ . '/../logs/app.log',
            ],
            */
         ],
      ];

      return $config;
   }

   /**
    * Initializes ORM Eloquent at app boot
    */
   private function initializeEloquent($settings): Capsule
   {
      $capsule = new Capsule();
      $capsule->addConnection($settings['settings']['db']);
      $capsule->setAsGlobal();
      $capsule->bootEloquent();

      return $capsule;
   }

   /**
   * Initializes PDO driver to database
   */
   private function initializePDO($config) {
      $settings = $config['settings'];
 
      $driver = $settings['db']['driver'];
      $host   = $settings['db']['host'];
      $database = $settings['db']['database'];
      $username = $settings['db']['username'];
      $password = $settings['db']['password'];
      $charset = $settings['db']['charset'];
      $collation = $settings['db']['collation'];

      $dsn = "$driver:host=$host;dbname=$database;charset=$charset";
      $options = [
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
          \PDO::ATTR_PERSISTENT => false,
          \PDO::ATTR_EMULATE_PREPARES => false,
          \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
          \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset COLLATE $collation"
      ];
  
      return new \PDO($dsn, $username, $password, $options);
   }

   /**
    * Initializes League/Plates to generate Views templates
    */
   private function initializeLeaguePlates() {
      // Create new Plates instance
      $templates = Engine::create(getenv('PATH_VIEWS_TEMPLATE'), "php");
      $templates->addFolder('partials', getenv('PATH_PARTIALS_TEMPLATE'));
      $templates->addFolder('emails', getenv('PATH_VIEWS_TEMPLATE') . '/emails');
   
      return $templates;
   }

   /**
    * Initializes Twig to generate Views templates
    */
   private function initializeTwigTemplates(Container $container): \Slim\Views\Twig
   {
      $view = new \Slim\Views\Twig(getenv('PATH_VIEWS_TEMPLATE'), [
         // Enable cache to improve performace
         //'cache' => getenv('PATH_VIEWS_CACHE')
      ]);

      // Instantiate and add Slim specific extension
      $router = $container->get('router');
      $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
      $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

      // Add another base url
      $view['BASE_URL'] = getenv('PATH_BASE_URL');

      return $view;
   }

}
