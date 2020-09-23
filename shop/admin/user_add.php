<?php

include('header.php');
include('UserManagement.php');
$userMangement = new UserManagement();
$error = $userMangement->add($_POST, $pdo);
?>
    <div class="content-wrapper pl-3 pb-4">
        <h1>Add User</h1>

        <form action='' method="post">
            <input type="hidden" name='_token' value=<?php echo $_SESSION["_token"]; ?>>
            <div class="form-group my-0">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name"
                       value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                <small class="text-danger"> * <?php echo isset($error['name']) ? $error['name'] : ''; ?> </small>
            </div>
            <div class="form-group my-0">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter Email"
                       value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                <small class="text-danger"> * <?php echo isset($error['email']) ? $error['email'] : ''; ?> </small>
            </div>
            <div class="form-group my-0">
                <label for="exampleInputPassword1">Password</label>
                <input type="text" name="password" class="form-control" placeholder="Enter Password"
                       value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                <small class="text-danger">
                    * <?php echo isset($error['password']) ? $error['password'] : ''; ?> </small>
            </div>

            <select name="role">
                <option value="1">Admin</option>
                <option value="0">Customer</option>
            </select>
            <br>
            <small class="text-danger">* <?php echo isset($error['role']) ? $error['role'] : ''; ?> </small>

            <div class="form-group my-0">
                <label for="exampleInputPassword1">address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter Address"
                       value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">
                <small class="text-danger"> * <?php echo isset($error['address']) ? $error['address'] : ''; ?> </small>
            </div>
            <div class="form-group my-0">
                <label for="exampleInputPassword1">Phone</label>
                <input type="number" name="phone" class="form-control" placeholder="Enter Phone"
                       value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                <small class="text-danger"> * <?php echo isset($error['phone']) ? $error['phone'] : ''; ?> </small>
            </div>

            <p class="text-primary">* fields are required!</p>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="user_lists.php.php" type="button" class="btn btn-outline-warning">Back</a>
        </form>

    </div>

<?php
include('footer.html');
?>