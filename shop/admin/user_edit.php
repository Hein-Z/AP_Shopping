<?php
include('header.php');
include('UserManagement.php');
$userManagement = new UserManagement();
$error=$userManagement->update($_POST, $pdo);

$user=$userManagement->edit($pdo);
?>

    <div class="content-wrapper pl-3">
        <h1>Edit User</h1>
        <form action='' method="post">
            <input type="hidden" name='_token' value='<?php echo $_SESSION["_token"];?>'>
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" value="<? echo $user['name'];?>" placeholder="Enter Name">

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter Email" value="<? echo $user['email'];?>" required>
                <small class="text-danger"> <?php echo isset($error)?$error:'';?> </small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="text" name="password" class="form-control" placeholder="Enter Password" value="<? echo $user['password'];?>" required>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter Address" value="<? echo $user['address'];?>" required>
            </div>name
            <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="number" name="phone" class="form-control" placeholder="Enter Phone" value="<? echo $user['phone'];?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php
include('footer.html');
?>