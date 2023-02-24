<?php
use Router\Router;

error_reporting(E_ALL);

require_once 'settings/auto/autoloader.php';

include ROUTES_PATH . '/web.php';

?>

<html>
    <head>
        <title>Super stronka</title>
    </head>
    <body>
        <?php  echo $router->start(); ?>
    </body>
</html>

  <!-- <?php echo $router->start(); ?> -->