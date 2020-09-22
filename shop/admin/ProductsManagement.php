<?php


class ProductsManagement
{
    public function show($data,$pdo){


        if (!empty($_GET['page_no'])) {
            $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
        }
        $num_of_regs = 3;
        $offset = ($page_no - 1) * $num_of_regs;


        if (empty($data['search']) && !isset($_COOKIE['search'])) {

            $stmt = $pdo->prepare("SELECT * FROM products  ORDER BY id DESC");

            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $pdo->prepare("SELECT * FROM products  ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $products = $stmt->fetchAll();
        } else {
            $search_key = isset($data['search']) ? $data['search'] : $_COOKIE['search'];

            $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search_key%'  ORDER BY id DESC");
            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search_key%' ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $products = $stmt->fetchAll();
        }


        return [$total_page, $products,$page_no,$offset];
    }
}

