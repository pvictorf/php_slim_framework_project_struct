<?php

namespace App\Middlewares;

use Tuupola\Middleware\JwtAuthentication;

final class JwtAuth
{
   /**
    * Get the token from request and call the next middeware returning decoded token
    * see: https://github.com/tuupola/slim-jwt-auth
    */
   public function __invoke()
   {
      return new JwtAuthentication([
         'secret' => getenv('JWT_SECRET_KEY'),
         'attribute' => 'JWT',
         "error" => function ($response, $arguments) {
  
            return $response->withJson(['message' => "Invalid token! ({$arguments['message']})"], 401);

         }
      ]); 
   }
}
