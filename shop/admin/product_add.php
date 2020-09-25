<?php
include('header.php');
include('ProductsManagement.php');
$productManagement = new ProductsManagement($pdo);
$error = $productManagement->add($_POST, $_FILES);

$stmt = $pdo->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();

?>


<div class="content-wrapper pt-5 pb-2">
    <h1 class='text-center'>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus-fill"
             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M12 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zM8.5 6a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V10a.5.5 0 0 0 1 0V8.5H10a.5.5 0 0 0 0-1H8.5V6z"/>
        </svg>
        Add New Product
    </h1>
    <div class='col-10 offset-1 '>

        <form action="" method="post" enctype='multipart/form-data'>
            <input type="hidden" name='_token' value='<?php echo $_SESSION["_token"]; ?>'>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name='name' class="form-control" placeholder="Fill Product's name"
                       value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                <small class="text-danger"> * <?php echo isset($error['name']) ? $error['name'] : ''; ?> </small>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea style="resize:none; height:300px;" type="text" name='description' class="form-control"
                          placeholder="Fill Product's Description"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
                <small class="text-danger">
                    * <?php echo isset($error['description']) ? $error['description'] : ''; ?> </small>
            </div>
            <div class="form-group">

                <label for="category">Category:</label>

                <select name="category_id">
                    <?php
                    foreach ($categories as $category){
                    if($_POST['category_id']===$category['id']){?>
                    <option value="<?php echo $category['id'];?>"<?php echo " selected"; ?>><?php echo $category['name'];?></option>
                     <?php }else{ ?>
                        <option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
                    <?php }} ?>
                </select>
                <br>
                <small class="text-danger">
                    * <?php echo isset($error['category']) ? $error['category'] : ''; ?> </small>

            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" name='price' class="form-control" placeholder="Fill Product's Price"
                       value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
                <small class="text-danger"> * <?php echo isset($error['price']) ? $error['price'] : ''; ?> </small>
            </div>

            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name='quantity' class="form-control" placeholder="Fill Quantity"
                       value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>">
                <small class="text-danger">
                    * <?php echo isset($error['quantity']) ? $error['quantity'] : ''; ?> </small>

            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name='image' class="form-control" placeholder="Fill Product's Image">
                <small class="text-danger"> * <?php echo isset($error['image']) ? $error['image'] : ''; ?> </small>

            </div>

            <p class="text-primary">* fields are required</p>
            <div class="form-group">

                <input type="submit" class='btn btn-primary' name='' value='submit'>
                <a href="index.php" class='btn btn-warning'>
                    <svg width="2em" height="1.5em" viewBox="0 0 16 16"
                         class="bi bi-arrow-left-square-fill " fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.354 10.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L6.207 7.5H11a.5.5 0 0 1 0 1H6.207l2.147 2.146z"/>
                    </svg>
                    Back</a>
            </div>

        </form>

    </div>
</div>
<?php
include('footer.html');
?>


