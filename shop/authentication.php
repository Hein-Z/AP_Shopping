<?php


class Authentication
{
    public function register($data,$pdo){
        if($data){
            if(!empty($data['password'])&& !empty($data['email'])&&!empty($data['confirm_password'])&& !empty($data['name'])
                &&!empty($data['address'])&&!empty($data['phone'])){
                if($data['password']== $data['confirm_password']){
                    $email=$data['email'];

                    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
                    $stmt->bindValue(':email',$email);
                    $stmt->execute();
                    $user=$stmt->fetch(PDO::FETCH_ASSOC);

                    if($user){
                            return "This Email already exit";
                    }else{
                        $name=$data['name'];
                        $email=$data['email'];
                        $password=$data['password'];
                        $phone=$data['phone'];
                        $address=$data['address'];
                        $stmt=$pdo->prepare('INSERT INTO users(name,email,password,address,phone) VALUE (:name,:email,:password,:address,:phone)');
                        $result=$stmt->execute(array(':name'=>$name,':email'=>$email,':password'=>  $password,':address'=>$address,':phone'=>$phone));

                        if($result){
                            echo '<script>alert("Successfully Registered, Please Login!");window.location.href="login.php";</script>';
                        }else{
                            echo '<script>alert("Cannot Registered");</script>';
                        }
                    }
                }else{
                   return "Do not much password";
                }
            }else{
                return "Please complete form!";
            }
        }
    }

    public function login($data,$pdo){
        if($data){
            $email=$data['email'];
            $password=$data['password'];

            if (empty($email) || empty($password))
                return "Please complete form";

            $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
            $stmt->bindValue(':email',$email);
            $stmt->execute();
            $user=$stmt->fetch(PDO::FETCH_ASSOC);
            if($user){
                if($user['password']==$password){

                    $_SESSION['user_id']=$user['id'];
                    $_SESSION['logged_in']=time();
                    $_SESSION['user_name']=$user['name'];
                    $_SESSION['profile_pic']=$user['profile_pic'];
                    $_SESSION['role']=$user['role'];
                    header('location: index.php');
                    // print_r($_SESSION);
                }
            }
          return "incorrect Email or Password";
        }
    }
    public function logout(){
        session_start();
        session_destroy();
        header("location:login.php");
    }
}