<?php
include('header.php');
include('UserManagement.php');
$userManagement = new UserManagement();
$error = $userManagement->update($_POST, $pdo);

$user = $userManagement->edit($pdo);
?>

    <div class="content-wrapper pl-3 pb-4">
        <h1>Edit User</h1>
        <form action='' method="post">
            <input type="hidden" name='_token' value='<?php echo $_SESSION["_token"]; ?>'>
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control"
                       value="<?php echo isset($_POST['name']) ? $_POST['name'] : $user['name']; ?>"
                       placeholder="Enter Name">
                <small class="text-danger"> * <?php echo isset($error['name']) ? $error['name'] : ''; ?> </small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter Email"
                       value="<?php echo isset($_POST['email']) ? $_POST['email'] : $user['email']; ?>">
                <small class="text-danger"> * <?php echo isset($error['email']) ? $error['email'] : ''; ?> </small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="text" name="password" class="form-control" placeholder="Enter Password"
                       value="<?php echo isset($_POST['password']) ? $_POST['password'] : $user['password']; ?>">
                <small class="text-danger">
                    * <?php echo isset($error['password']) ? $error['password'] : ''; ?> </small>
            </div>
            <select name="role">
                <?php if (empty($_POST)) { ?>
                    <option value="1"<?php echo $user['role'] == 1 ? 'selected' : ''; ?>>Admin</option>
                    <option value="0"<?php echo $user['role'] == 0 ? 'selected' : ''; ?>>Customer</option>
                <? } else{?>
                    <option value="1"<?php echo $_POST['role'] == 1 ? 'selected' : ''; ?>>Admin</option>
                    <option value="0"<?php echo $_POST['role'] == 0 ? 'selected' : ''; ?>>Customer</option>
                <?}?>
            </select>
            <br>
            <small class="text-danger">* <?php echo isset($error['role']) ? $error['role'] : ''; ?> </small>

            <div class="form-group">
                <label for="exampleInputPassword1">address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter Address"
                       value="<?php echo isset($_POST['address']) ? $_POST['address'] : $user['address']; ?>">
                <small class="text-danger"> * <?php echo isset($error['address']) ? $error['address'] : ''; ?> </small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="number" name="phone" class="form-control" placeholder="Enter Phone"
                       value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $user['phone']; ?>">
                <small class="text-danger"> * <?php echo isset($error['phone']) ? $error['phone'] : ''; ?> </small>
            </div>

            <p>* fields are required</p>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="button" class="btn btn-outline-warning" href="user_lists.php">Back</a>

        </form>
    </div>
<?php
include('footer.html');
?>