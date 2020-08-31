<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;
use App\Models\User;


final class AuthController {
   private $view;

   public function __construct($container) {
      $this->view = $container->get('view');
   }
 

   public function signin(Request $request, Response $response): Response {
      $this->view->render($response, 'signin.php');

      return $response;
   }


   public function signup(Request $request, Response $response, array $args) {
      $data = $request->getParsedBody();

      $email = $data['email'] ?? false;
      $password = $data['password'] ?? false;

      if(!$email || !$password) {
         return $response->withJson([
            'success' => false,
            'message' => "E-mail and password is required!",
         ], 400);
      }

      $user = new User();
      $user->email = $email;
      $user->password = $password;
      $user->token = $this->generateToken($user);

      return $response->withJson([
         'success' => true,
         'message' => "User {$user->email} was created successfully!",
         'token'   => $user->token,
      ]);
   }


   private function generateToken(User $user) {
      $expired_at = (new \DateTime())->modify('+4 days')->format('Y-m-d H:i:s');

      $tokenPayload = [
         'sub' => uniqid(),
         'email'=> $user->email,
         'expired_at' => $expired_at,
      ];

      $newToken = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));

      return $newToken;
   }
}