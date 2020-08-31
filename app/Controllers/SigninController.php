<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Repositories\UserRepository;


final class SigninController
{
   private $view;

   public function __construct($container) {
      $this->view = $container->get('view');
   }
 

   public function signin(Request $request, Response $response, array $args) {
      $data = $request->getParsedBody();

      $email = $data['email'] ?? "";
      $password = $data['password'] ?? "";

      $userRepository = new UserRepository();
      $user = $userRepository->findByEmail($email);

      if(!$user || !$user->verifyPassword($password)) {
         return $response->withJson([
            'success' => false,
            'message' => "E-mails or password is invalid! Please try again.",
         ], 400);
      }

      $loggedUser = new User();
      $loggedUser->id = $user->id;
      $loggedUser->name = $user->name;
      $loggedUser->email = $user->email;

      
      return $response->withJson([
         'success' => true,
         'loggedUser' => $loggedUser,
         'message' => "Logged!",
      ]);      
   }
}
