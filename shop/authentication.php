<?php


class Authentication
{
    public function login($data,$pdo){
        if($data){
            $email=$data['email'];
            $password=$data['password'];
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
            echo '<script>
    alert("incorrect Email or Password");</script>';


        }
    }
    public function logout(){
        session_start();
        session_destroy();
        header("location:login.php");
    }
}