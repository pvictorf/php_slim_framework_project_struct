<?php

namespace App\Services;

use Firebase\JWT\JWT;

final class authService {

   public static function generateToken(int $id, String $name, String $email): String {
      $expired_at = (new \DateTime())->modify('+4 days')->format('Y-m-d H:i:s');

      $tokenPayload = [
         'sub' => uniqid($id),
         'name'=> $name,
         'email'=> $email,
         'expired_at' => $expired_at,
      ];

      return JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));
   }


   public static function checkValidateToken(array $decodedToken): bool {

      //Convert expired_at to date
      $expired_at = new \DateTime($decodedToken['expired_at']);

      //Get actually time
      $now = new \DateTime();

      //Check date validity
      return ($expired_at < $now);
   }

}