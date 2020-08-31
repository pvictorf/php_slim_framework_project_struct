<?php

namespace App\Middlewares;

use App\Services\authService;
use Slim\Http\Request;
use Slim\Http\Response;


final class JwtCheckToken
{      
   public function __invoke(Request $request, Response $response, $next)
   {

      //Get token decoded from attribute 'JWT' of jwtAuth()
      $decodedToken  = $request->getAttribute('JWT');

      if(!$decodedToken) {
         return $response->withJson(['message' => 'Token is empty!'], 401);
      }

      if(!authService::checkValidateToken($decodedToken)) {
         return $response->withJson(['message' => 'Token is expired or invalid!'], 401);
      }

      return $next($request, $response);
   }
}   