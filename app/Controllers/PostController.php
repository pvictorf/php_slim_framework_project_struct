<?php
namespace App\Controllers;

use App\Models\Post;

final class PostController {

   public function index() {

      $posts = Post::all();

      foreach($posts as $post) {
         var_dump($post);
      }

   }

}