<?php
include('header.php');
include('CatManagement.php');
$catManagement = new CatManagement();
$catManagement->update($_POST, $pdo);
$categories =$catManagement->edit($pdo);

?>

    <div class="content-wrapper pl-3 pb-4">
        <h1>Edit Category</h1>
        <form action='' method="post">
            <input type="hidden" name='_token' value='<?php echo $_SESSION["_token"];?>'>
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="name" name="name" class="form-control" placeholder="Enter Name" value="<?php echo $categories['name']?>">
                <small class="text-danger"> * <?php echo isset($error['name'])?$error['name']:'';?> </small>

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Description</label>

                <textarea name="description" class="form-control" cols="30" rows="10"><?php echo $categories['description']?></textarea>
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