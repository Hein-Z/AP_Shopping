<?php


class UserManagement
{

    protected $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo=$pdo;
    }

    public function edit(){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id=:id");

        $stmt->execute(array(':id' => $_GET['id']));
        $user = $stmt->fetch();
        return $user;
    }

    public function update($data)
    {

        if ($data) {

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=:email and id!=:id");
            $stmt->execute(array(':email' => $data['email'], ':id' => $_GET['id']));
            $result = $stmt->fetch();


            $name = $data['name'];
            $email = $data['email'];
            $address = $data['address'];
            $phone = $data['phone'];
            $password = $data['password'];
            $role=$data['role'];


            if (!empty($result)) {
                $error['email']='Email already exit!';
            }
            if(empty($name)){
                $error['name']='Name cannot be blank';
            }
            if(empty($email)){
                $error['email']='Email cannot be blank';
            }
            if(empty($address)){
                $error['address']='Address cannot be blank';
            }
            if(empty($phone)){
                $error['phone']='Phone number cannot be blank';
            }
            if(empty($password)){
                $error['password']='Password cannot be blank';
            }
            if(empty($role)){
                $error['role']='please fill the role';
            }elseif (is_numeric($data['role']) != 1) {
                $error['role'] = 'role value should be number';
            }



            if (!empty($name) && !empty($email) && !empty($phone) && !empty($password) && !empty($address)) {
                $stmt = $this->pdo->prepare('UPDATE users SET name=:name, email=:email, address =:address, phone=:phone, password=:password,role=:role WHERE id=:id');
                $result = $stmt->execute(array(':name' => $name, ':email' => $email, ':address' => $address, ':phone' => $phone, ':password' => $password,':role'=>$role, ':id' => $_GET['id']));

                if (isset($result)) {
                    echo '<script>alert("successfully edited");window.location.href="user_lists.php";</script>';

                } else {
                    echo '<script>alert("cannot edited");</script>';
                }
            } else {
                return $error;
            }
        }

    }

    public function add($data)
    {


        if ($data) {

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=:email");
            $stmt->execute(array(':email' => $data['email']));
            $result = $stmt->fetch();

            $name = $data['name'];
            $email = $data['email'];
            $address = $data['address'];
            $phone = $data['phone'];
            $password = $data['password'];
            $role=$data['role'];


            if (!empty($result)) {
                $error['email']='This email already exist!';
            }
            if(empty($name)){
                $error['name']='please fill the name';
            }
            if(empty($email)){
                $error['email']='please fill the email';
            }
            if(empty($address)){
                $error['address']='please fill the address';
            }
            if(empty($phone)){
                $error['phone']='please fill the phone number';
            }
            if(empty($password)){
                $error['password']='please fill the password';
            }
            if(empty($role)){
                $error['role']='please fill the role';
            }elseif (is_numeric($data['role']) != 1) {
                $error['role'] = 'role value should be number';
            }


            if (!empty($name) && !empty($email) && !empty($address) && !empty($phone) && !empty($password)) {

                $stmt = $this->pdo->prepare('INSERT INTO users(name,email,address,phone,password,role) VALUE (:name,:email,:address,:phone,:password,:role)');
                $result = $stmt->execute(array(':name' => $name, ':email' => $email, ':address' => $address, ':phone' => $phone, ':password' => $password, ':role' => $role));
                if ($result) {
                    echo '<script>alert("successfully added");window.location.href="user_lists.php"</script>';
                } else {
                    echo '<script>alert("cannot add");window.location.href="user_lists.php"</script>';

                }
            } else {
                return $error;
            }
        }

    }

    public function delete()
    {
        $ID = $_GET['id'];
        $sql = 'DELETE FROM categories WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $ID);

        $result = $stmt->execute();
        if (isset($result)) {

            echo '<script>alert("Successful Delete");
        window.location.href="user_lists.php";
        </script>';
        }
    }

    public function show($data)
    {


        if (!empty($_GET['page_no'])) {
            $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
        }
        $num_of_regs = 3;
        $offset = ($page_no - 1) * $num_of_regs;


        if (empty($data['search']) && !isset($_COOKIE['search'])) {

            $stmt = $this->pdo->prepare("SELECT * FROM users ORDER BY id DESC");

            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $this->pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $users = $stmt->fetchAll();


        } else {
            $search_key = isset($data['search']) ? $data['search'] : $_COOKIE['search'];

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE name LIKE '%$search_key%'  ORDER BY id DESC");

            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE name LIKE '%$search_key%' ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $users = $stmt->fetchAll();
        }
        return [$total_page, $users,$page_no,$offset];
    }


}

