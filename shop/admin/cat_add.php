<?php
include('header.php');
include('CatManagement.php');
$catManagement = new CatManagement();
$error=$catManagement->add($_POST, $pdo);
?>
    <div class="content-wrapper pl-3">
        <h1>Add Category</h1>

        <form action='cat_add.php' method="post">
            <input type="hidden" name='_token' value='<?php echo $_SESSION["_token"];?>'>
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="name" name="name" class="form-control" placeholder="Enter Name" value="<?php echo isset($_POST['name'])?$_POST['name']:'';?>">
                <small class="text-danger"> * <?php echo isset($error['name'])?$error['name']:'';?> </small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Description</label>
                <textarea type="description" name="description" class="form-control" rows="5" placeholder="Enter Description"><?php echo isset($_POST['description'])?$_POST['description']:'';?></textarea>
                <small class="text-danger"> * <?php echo isset($error['description'])?$error['description']:'';?> </small>
            </div>
            <p>* fields are required</p>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="category.php" type="button" class="btn btn-outline-warning">Back</a>
        </form>

    </div>
<?php
include('footer.html');
?>