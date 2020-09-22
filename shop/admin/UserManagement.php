<?php


class UserManagement
{


    public function edit($data, $pdo)
    {

        if ($data) {

            $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email and id!=:id");
            $stmt->execute(array(':email'=>$data['email'],':id'=>$_GET['id']));
            $result=$stmt->fetch();


            if(!empty($result)){
                return "Email already exist!";
            }

            $name = $data['name'];
            $email = $data['email'];
            $address = $data['address'];
            $phone = $data['phone'];
            $password = $data['password'];

            if (!empty($name) && !empty($email)&& !empty($phone)&& !empty($password)&& !empty($address)) {
                $stmt = $pdo->prepare('UPDATE users SET name=:name, email=:email, address =:address, phone=:phone, password=:password WHERE id=:id');
                $result = $stmt->execute(array(':name' => $name, ':email' => $email, ':address' => $address, ':phone' => $phone, ':password' => $password,   ':id' => $_GET['id']));

                if (isset($result)) {
                    echo '<script>alert("successfully edited");window.location.href="user_lists.php";</script>';

                } else {
                    echo '<script>alert("cannot edited");</script>';
                }
            } else {
                echo '<script>alert("You Must Fill The Form!");</script>';
            }
        }

    }

    public function add($data, $pdo)
    {


        if ($data) {

            $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
            $stmt->execute(array(':email'=>$data['email']));
            $result=$stmt->fetch();


            if(!empty($result)){
                return "Cannot add.Email already exist!";
            }

            $name = $data['name'];
            $email = $data['email'];
            $address = $data['address'];
            $phone = $data['phone'];
            $password = $data['password'];
            $role=2;
            if (!empty($name) && !empty($email) && !empty($address) && !empty($phone) && !empty($password)) {

                $stmt = $pdo->prepare('INSERT INTO users(name,email,address,phone,password,role) VALUE (:name,:email,:address,:phone,:password,:role)');
                $result = $stmt->execute(array(':name' => $name, ':email' => $email, ':address' => $address, ':phone' => $phone, ':password' => $password,':role' => $role));
                if ($result) {
                    echo '<script>alert("successfully added");window.location.href="user_lists.php"</script>';
                } else {
                    echo '<script>alert("cannot add");window.location.href="user_lists.php"</script>';

                }
            } else {
                echo '<script>alert("cannot add");</script>';
            }
        }

    }

    public function delete($pdo)
    {
        $ID = $_GET['id'];
        $sql = 'DELETE FROM categories WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $ID);

        $result = $stmt->execute();
        if (isset($result)) {

            echo '<script>alert("Successful Delete");
        window.location.href="user_lists.php";
        </script>';
        }
    }

}

