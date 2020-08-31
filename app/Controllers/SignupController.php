<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\authService; 

final class SignupController {

   public function signup(Request $request, Response $response, array $args) {
      $data = $request->getParsedBody();

      $user = new User();
      $user->name  = $data['name'] ?? "";
      $user->email = $data['email'] ?? "";
      $user->password = $data['password'] ?? "";

      $userRepository = new UserRepository();

      try {   

         if($userRepository->findByEmail($user->email)) {
            return $response->withJson([
               'success' => false,
               'message' => "User already exists!",
            ]);
         }
         
         $user->isValid();
         $user->hashPassword();
         
         $newUser = $userRepository->create($user);
         $token = authService::generateToken($newUser->id, $newUser->name, $newUser->email);

      } catch(\Exception $err) {

         return $response->withJson([
            'success' => false,
            'message' => $err->getMessage(),
         ], 400);

      }

      return $response->withJson([
         'success' => true,
         'message' => "User {$newUser->email} was created successfully!",
         'uuid'    => $newUser->uuid,
         'token'   => $token,
      ]);
   }
}   