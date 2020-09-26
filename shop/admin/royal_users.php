


<?php include('header.php'); ?>
<!-- Main content -->
<div class="content-wrapper pl-3">
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title">Royal Users</h3>
                    </div>
                    <?php
                    $currentDate = date("Y-m-d");
                    $stmt = $pdo->prepare("SELECT * FROM sale_orders WHERE total_price>=400000 ORDER BY id DESC");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered hover compact stripe" id="d-table">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>UserID</th>
                    compact            <th>Total Amount</th>
                                <th>Order Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($result) {
                                $i = 1;
                                foreach ($result as $value) { ?>

                                    <?php
                                    $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                                    $userStmt->execute();
                                    $userResult = $userStmt->fetchAll();
                                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo escape($userResult[0]['name'])?></td>
                                        <td><?php echo escape($value['total_price'])?></td>
                                        <td><?php echo escape(date("Y-m-d",strtotime($value['order_date'])))?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            </tbody>
                        </table><br>

                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<?php include('footer.html')?>

<script>
    $( document ).ready(function() {
        $('#d-table').DataTable();
    });
</script>