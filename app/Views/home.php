<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Slim Framework Eloquent Struct</title>
   <link rel="stylesheet" href="<?= url() ?>/assets/css/styles.css">
</head>

<body>
   <main class="main">
      <section class="main_content">
         <div class="main_content_img">
            <img src="<?= url() ?>/assets/images/slim_logo.png" alt="Slim Framework">
         </div>

         <div class="main_contant_text">
            <h1>Slim Framework 3 Project Struct</h1>
            <p>A default project struct created by <a href="https://github.com/pvictorf"><?=$v($name)?></a> with:</p>
            <ul>
               <li>UUID Generator</li>
               <li>League Plates Templates</li>
               <li>TWIG Templates</li>
               <li>Eloquent ORM</li>
               <li>PDO</li>
               <li>Repository</li>
               <li>JWT Authentication</li>
         </div>

      </section>
      <?= $v->insert('footer', ['name' => $name]) ?>
   </main>

</body>

</html>