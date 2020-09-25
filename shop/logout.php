<?php
require 'authentication.php';
require 'config/config.php';
$authenticate = new Authentication($pdo);
$authenticate->logout();
?>