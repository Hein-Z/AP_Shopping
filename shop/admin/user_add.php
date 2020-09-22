<?php

include('header.php');
include('UserManagement.php');
$userMangement = new UserManagement();
$error=$userMangement->add($_POST, $pdo);
?>
    <div class="content-wrapper pl-3">
        <h1>Add User</h1>

        <form action='' method="post">
            <input type="hidden" name='_token' value='<?php echo $_SESSION["_token"];?>'>
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter Email" required>
                <small class="text-danger"> <?php echo isset($error)?$error:'';?> </small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="text" name="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="number" name="phone" class="form-control" placeholder="Enter Phone"  required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php
include('footer.html');
?>