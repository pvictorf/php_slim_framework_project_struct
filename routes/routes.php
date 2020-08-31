<?php
//Inicialize App
use Slim\Http\Response;
use Slim\Http\Request;
use Boot\Bootstrap;

//Middlewares
use App\Middlewares\JwtAuth;
use App\Middlewares\JwtCheckToken;

//Controllers
use App\Controllers\SigninController;
use App\Controllers\SignupController;
use App\Controllers\UserController;


$boot = new Bootstrap();

$app  = new \Slim\App( $boot() );

//==========================================================================


//Router base
$app->get('/', function(Request $request, Response $response, array $args) {
   //Send response with JSON data
   //return $response->withJson(['name' => 'paulo']);
   
   //Send response with Redirect
   //return $response->withRedirect('/signin');

   //Send response with View HTML page
   $data = [
      'name' => 'pvictorf',
      'names' => ['<script>alert("Victor")</script>', 'Ronaldo', 'Angelin']
   ];
   return $this->view->render('home', $data);
});



//Router signin with template view method
$app->post('/signin', SigninController::class . ':signin');


//Router Post to generate a new User with token JWT
$app->post('/signup', SignupController::class . ':signup');


//Router Group protected with Middleware
$app->group('/v1', function() use($app) {

   $app->get('/users', UserController::class . ':index');
   $app->get('/posts', PostController::class . ':index');

//This middleware invokes JWT and check if the token on request is valid   
})->add(new JwtCheckToken)->add((new JwtAuth)());


//==========================================================================

$app->run();
