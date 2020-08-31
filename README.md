# slim_framework_eloquent_struct
Project structure to work with the pre-configured Slim Framework 3, ORM Eloquent and View temple engine(Twig).

# How to install
  * In terminal run: **composer install and composer dump-autoload -o**
  * Copy **env.example.php to env.php** and set your environment variables.
  * Start server typing:  
    - cd path/to/your/main_project
    - php -S localhost:8888
  * Use insominia or postman to test routes.
  
# Routes
  * [GET] / - Base url, like: http://localhost:8888/
  * [POST] /signup - To create a new user with token JWT (see: https://github.com/firebase/php-jwt)
  * [POST] /v1/users - Protected routes that need authentication! 
  Use Bearer token with hash received in /signup (see: https://github.com/tuupola/slim-jwt-auth)
  
  
  # Router /signup exemple
  ![](exemp_signup.gif)
    
  # Router /v1/users exemple using token
  ![](exemp_v1.gif)

# Models
 * User - Extends eloquent ORM to get all data for your database (see: https://laravel.com/docs/7.x/eloquent)
