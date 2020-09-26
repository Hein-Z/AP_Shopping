<?php
session_start();
require '../config/config.php';
include '../config/common.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) || $_SESSION['role'] == 0)
    header('location:login.php');

$link = $_SERVER['PHP_SELF'];
$link_array = explode('/', $link);
$page = end($link_array);

if (!empty($_POST['search']) || isset($_COOKIE['search']))
    $search_key = isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>AP Shop</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">


</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">AP Shopping</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block">Account's Name : : <?php echo $_SESSION['user_name']; ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="index.php" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Products
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="user_lists.php" class="nav-link">
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-people-fill"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                            </svg>
                            <p class='ml-1'> Users
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="category.php" class="nav-link">
                            <i class="fa fa-list"></i>
                            <p class='ml-1'> Categories
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="order_list.php" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <p class='ml-1'> Order Lists
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link pl-2">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="weekly_report.php" class="nav-link">
                                    <i class="fas fa-calendar-day nav-icon"></i>
                                    <p>Weekly report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="monthly_report.php" class="nav-link">
                                    <i class="fas fa-calendar-week nav-icon"></i>
                                    <p>Monthly Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="royal_users.php" class="nav-link">
                                    <i class="fas fa-user-check text-success nav-icon"></i>
                                    <p>Royal Users</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="best_selling.php" class="nav-link ">
                                    <i class="far fa-bookmark nav-icon"></i>
                                    <p>Best Selling Items</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo $page; ?>" class="nav-link">Home</a>
            </li>

        </ul>

        <!-- SEARCH FORM -->
        <?php if ($page == 'index.php' || $page == 'category.php' || $page == 'user_list.php') { ?>
            <?php if ($page != 'order_list.php') { ?>
                <form class="form-inline ml-3" method="post"
                    <?php if ($page == 'index.php') : ?>
                        action="index.php"
                    <?php elseif ($page == 'category.php'): ?>
                        action="category.php"
                    <?php elseif ($page == 'user_lists.php'): ?>
                        action="user_lists.php"
                    <?php endif; ?>
                >
                    <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                    <div class="input-group input-group-sm">
                        <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            <?php } ?>
        <?php } ?>
        <ul>
            <li class="nav-item d-none d-sm-inline-block"><?php echo isset($search_key) ? 'Search results for "' . $search_key . '"' : ''; ?></li>
        </ul>
    </nav>
    <!-- /.navbar -->