<?php

function url (String $uri = null): String {
   $root = getenv("PATH_BASE_URL");

   return ($uri) ? $root . "/{$uri}" : $root;
}