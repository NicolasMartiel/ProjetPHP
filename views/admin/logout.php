<?php
session_start();
session_destroy();

$redirect = $router->getRoute("LoginGet");

header("Location:$redirect");

require "login.php" 
?>