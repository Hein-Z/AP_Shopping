<?php
require ('UserManagement.php');
if (isset($_POST['search'])) {
    setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
} else {
    if (empty($_GET['page_no'])) {
        unset($_COOKIE['search']);
        setcookie('search', null, -1, '/');
    }
}


?>

<?php include('header.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><b>AP Shop</b> Admin Panel</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="logout.php">Logout</a></li>

                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            <br>
            <a href='user_add.php' class="btn btn-success">
                <svg width="2em" height="2em" viewBox="0 0 16 16"
                     class="bi bi-file-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M12 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zM8.5 6a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V10a.5.5 0 0 0 1 0V8.5H10a.5.5 0 0 0 0-1H8.5V6z"/>
                </svg>
                New User</a>


        </div>
        <?php
        $userManagement = new UserManagement();
        $result=$userManagement->show($_POST, $pdo);

        $total_page=$result[0];
        $users=$result[1];
        $page_no=$result[2];
        $offset=$result[3];
        ?>
        <!-- Main content -->
        <?php if (count($users)) { ?>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Role</th>

                        <th style="width: 120px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $id = 0;

                    foreach ($users as $user) {
                        $id++; ?>
                        <tr>
                            <td><?php echo $id+$offset ; ?></td>
                            <td><?php echo escape($user['name']); ?></td>
                            <td>
                                <?php echo escape($user['email']); ?>
                            </td>
                            <td>
                                <?php echo escape($user['address']); ?>
                            </td>
                            <td>
                                <?php echo escape($user['phone']); ?>
                            </td>
                            <td>
                                <?php echo $user['role']==0?'customer':'admin'; ?>
                            </td>
                            <td>
                                <a href='user_edit.php?id=<?php echo $user['id']; ?>'
                                   class="btn btn-primary btn-sm mb-1 w-100">
                                    <svg width="1.3em" height="1.3em" viewBox="0 0 16 16"
                                         class="bi bi-pencil-square mr-1 mb-1"
                                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd"
                                              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                    Edit</a>
                                <a href='user_delete.php?id=<?php echo $user['id']; ?>'
                                   onclick="return confirm('Are you sure you want to delete this item?');"
                                   class="btn btn-outline-warning btn-sm w-100 text-bold">
                                    <svg width="1.3em" height="1.3em"
                                         viewBox="0 0 16 16" class="bi bi-trash mr-1 mb-1" fill="currentColor"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd"
                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                    Delete</a>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
                <div class='float-right mt-2 mr-5'>
                    <ul class="pagination">
                        <li class="page-item <?php if ($page_no == 1) {
                            echo 'disabled';
                        } ?>">
                            <a class="page-link" href="?page_no=<?php if ($page_no <= 1) {
                                echo $page_no;
                            } else {
                                echo $page_no - 1;
                            } ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item <?php if ($page_no == 1) {
                            echo 'disabled';
                        } ?>"><a class="page-link"
                                 href="?page_no=1">First page</a></li>
                        <li class="page-item <?php if ($page_no == 1) {
                            echo 'disabled';
                        } ?>"><a class="page-link" href="?page_no=<?php if ($page_no <= 1) {
                                echo $page_no;
                            } else {
                                echo $page_no - 1;
                            } ?>">Previous Page</a></li>
                        <li class="page-item">
                            <a class="page-link text-bold" href="#"><?php echo $page_no ?>
                            </a>
                        </li>
                        <li class="page-item <?php if ($page_no == $total_page) {
                            echo 'disabled';
                        } ?>"><a class="page-link" href="?page_no=<?php if ($page_no < $total_page) {
                                echo $page_no + 1;
                            } else {
                                echo $page_no;
                            } ?>">Next Page</a>
                        </li>
                        <li class="page-item <?php if ($page_no == $total_page) {
                            echo 'disabled';
                        } ?>"><a class="page-link"
                                 href="?page_no=<?php echo $total_page ?>">Last Page</a></li>
                        <li class="page-item  <?php if ($page_no == $total_page) {
                            echo 'disabled';
                        } ?>">
                            <a class="page-link" href="?page_no=<?php echo $total_page ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>


            </div>
        <?php } else { ?>
            <h1>
                <?php if (!empty($_POST['search'])) {
                    echo "There is no user match with '" . $_POST['search'] . "'";
                } else {
                    echo "There is no user yet";
                } ?>
            </h1>
        <?php } ?>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php include('footer.html'); ?>