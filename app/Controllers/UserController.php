<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;

final class UserController {

   public function index(Request $request, Response $response) {

      //Get all users from your mysql database with Eloquent
      //$users = User::all();

      //Simulate users
      $users = [
         ['email' => 'pvictor@gmail.com'],
         ['email' => 'nathan@gmail.com'],
         ['email' => 'fred@gmail.com'],
         ['email' => 'ronaldin@gmail.com']
      ];

      return $response->withJson([
         'users' => $users
      ]);

   }

}