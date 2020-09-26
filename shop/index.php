<?php

if (isset($_POST['search'])) {
    setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
} else {
    if (empty($_GET['pageno'])) {
        unset($_COOKIE['search']);
        setcookie('search', null, -1, '/');
    }
}
if (isset($_GET['category'])) {
    setcookie('category', $_GET['category'], time() + (86400 * 30), "/");
    if ($_GET['category'] == 'all') {
        unset($_COOKIE['category']);
        setcookie('category', null, -1, '/');
        unset($_GET['category']);
    }
} else {
    if (empty($_GET['pageno'])) {
        unset($_COOKIE['category']);
        setcookie('category', null, -1, '/');
    }
}

include('header.php');
include('IndexShow.php');


if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$numOfrecs = 3;
$offset = ($pageno - 1) * $numOfrecs;

$select = new IndexShow($pdo, $numOfrecs, $offset);


if (empty($_POST['search']) && empty($_COOKIE['search'])) {

    if (empty($_GET['category']) && empty($_COOKIE['search'])) {
        $results = $select->selectAll();
        $total_pages = $results[0];
        $result = $results[1];
    } else {
        $category = isset($_GET['category']) ? $_GET['category'] : $_COOKIE['category'];
        $results = $select->selectCat($category);
        $total_pages = $results[0];
        $result = $results[1];
    }


} else {

    $searchKey = isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];

    if (empty($_GET['category']) && empty($_COOKIE['category'])) {
        $results = $select->selectSearch($searchKey);
        $total_pages = $results[0];
        $result = $results[1];
    } else {
        $category = isset($_GET['category']) ? $_GET['category'] : $_COOKIE['category'];
        $results = $select->selectSearchCat($searchKey, $category);
        $total_pages = $results[0];
        $result = $results[1];
    }

}

?>
    <div class="container">
    <div class="row">
    <div class="col-xl-3 col-lg-4 col-md-5">
        <div class="sidebar-categories">
            <div class="head">Browse Categories</div>
            <ul class="main-categories">
                <li class="main-nav-list">
                    <a href="?category=all&pageno=1">All</a>
                </li>
                <li class="main-nav-list">
                    <?php
                    $catstmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
                    $catstmt->execute();
                    $catResult = $catstmt->fetchAll();
                    ?>

                    <?php foreach ($catResult as $key => $value) { ?>
                        <a href="?category=<?php echo escape($value['id']) . '&pageno=1'; ?>"><?php echo escape($value['name']) ?></a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8 col-md-7">
    <div class="filter-bar d-flex flex-wrap align-items-center">
        <div class="pagination">
            <a href="?pageno=1<?php echo isset($category) ? '&category=' . $category : '';
            ?>" class="active">First</a>
            <a <?php if ($pageno <= 1) {
                echo 'disabled';
            } ?>
                    href="<?php if ($pageno <= 1) {
                        echo '#';
                    } else {
                        echo "?pageno=" . ($pageno - 1);
                        echo isset($category) ? '&category=' . $category : '';
                    } ?>" class="prev-arrow">
                <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
            </a>
            <a href="#" class="active"><?php echo $pageno; ?></a>
            <a <?php if ($pageno >= $total_pages) {
                echo 'disabled';
            } ?>
                    href="<?php if ($pageno >= $total_pages) {
                        echo '#';
                    } else {
                        echo "?pageno=" . ($pageno + 1);
                        echo isset($category) ? '&category=' . $category : '';
                    } ?>" class="next-arrow">
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            </a>
            <a href="?pageno=<?php echo $total_pages;
            echo isset($category) ? '&category=' . $category : '';
            ?>" class="active">Last</a>
        </div>
    </div>
    <!-- End Filter Bar -->
    <!-- Start Best Seller -->
    <section class="lattest-product-area pb-40 category-list">
        <div class="row">
            <?php
            if ($result) {
                foreach ($result as $key => $value) :?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <img class="img-fluid" src="admin/product_img/<?php echo escape($value['image']) ?>"
                                 style="height: 250px;">
                            <div class="product-details">
                                <h6><?php echo escape($value['name']) ?></h6>
                                <div class="price">
                                    <h6><?php echo escape($value['price']) ?></h6>
                                </div>
                                <div class="prd-bottom">
                                    <form action="addtocart.php" method="post">
                                        <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                                        <input type="hidden" name="id" value="<?php echo escape($value['id']) ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <div class="social-info">
                                            <button style="display:contents" class="social-info" type="submit">
                                                <span class="ti-bag"></span>
                                                <p style="left: 20px;" class="hover-text">add to bag</p>
                                            </button>
                                        </div>
                                        <a href="product_detail.php?id=<?php echo $value['id']; ?>" class="social-info">
                                            <span class="lnr lnr-move"></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            }
            if (empty($result)) { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="single-product">
                        There is no product with this category
                    </div>
                </div>
            <?php } ?>

    </section>
    <!-- End Best Seller -->
<?php include('footer.php'); ?>