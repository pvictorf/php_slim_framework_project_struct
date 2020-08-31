<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
 
   protected $table = 'users';
   protected $fillable = ['uuid', 'name', 'email', 'password'];

   public function setNameAttribute($value) {
      $names = explode(" ", strtolower(trim($value)));

      $correctName = array_map(function($name) {
         return (in_array($name, ['da', 'de', 'do', 'dos'])) ? $name : ucfirst($name);
      }, $names);

      $this->attributes['name'] = implode(" ", $correctName);
   }


   public function setEmailAttribute($value) {
      $this->attributes['email'] = strtolower(trim($value));
   }


   public function isValid() {
      return $this->checkName()
                  ->checkEmailAndPassword();
   }
   

   private function checkName(): self {
      //Todo: Implement a check if user have numbers or invalid character in your name.
      //if(true) {
      //   throw new \Exception("Invalid name! try remove numbers of invalid character!");
      //}

      return $this;
   }


   private function checkEmailAndPassword(): self {

      if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) || !$this->password) {
        throw new \Exception("E-mail or password is invalid!");
      }

      return $this;
   }


   public function hashPassword(): self {
      $this->password = password_hash($this->password, PASSWORD_ARGON2I);

      return $this;
   }


   public function verifyPassword(String $password): bool {
      return password_verify($password, $this->password);
   }
}