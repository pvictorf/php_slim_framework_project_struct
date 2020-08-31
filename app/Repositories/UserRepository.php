<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\User;

final class UserRepository {
   
   public function create(User $user): ?User {

      return User::create([
         'uuid' => Str::uuid()->toString(),
         'name' => $user->name,
         'email' => $user->email,
         'password' => $user->password,
      ]);

   }


   public function findByEmail(String $email): ?User {
      return User::where('email', $email)->first();
   }

}