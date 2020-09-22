<?php
include('header.php');
include('CatManagement.php');
$catManagement = new CatManagement();
$catManagement->edit($_POST, $pdo);
?>

    <div class="content-wrapper pl-3">
        <h1>Edit Category</h1>
        <form action='' method="post">
            <input type="hidden" name='_token' value='<?php echo $_SESSION["_token"];?>'>
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="name" name="name" class="form-control" placeholder="Enter Name">

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Description</label>
                <input type="description" name="description" class="form-control" id placeholder="Enter Description">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php
include('footer.html');
?>