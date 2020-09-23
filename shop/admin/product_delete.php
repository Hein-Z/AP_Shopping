<?php

session_start();
require '../config/config.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('location:login.php');
}
if ($_SESSION['role'] == 0) {
    header('location:login.php');
}
$link = $_SERVER['PHP_SELF'];
$link_array = explode('/', $link);
$page = end($link_array);

include('ProductsManagement.php');
$productsManagement = new ProductsManagement();
$productsManagement->delete( $pdo);
