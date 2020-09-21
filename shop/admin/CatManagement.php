<?php


class CatManagement
{
    public function edit($data,$pdo){
        if($data){
            $name=$data['name'];
            $description=$data['description'];

            if(!empty($name) && !empty($description)){
                    $stmt=$pdo->prepare('UPDATE categories SET name=:name, description=:description WHERE id=:id');
                    $result=$stmt->execute(array(':name'=>$name,':description'=>$description,':id'=> $_GET['id'] ));

                if(isset($result)){
                    echo '<script>alert("successfully edited");window.location.href="category.php";</script>';

                }else{
                    echo '<script>alert("cannot edited");</script>';
                }
            }else{
                echo '<script>alert("You Must Fill The Form!");</script>';
            }
        }

    }
    public function add($data,$pdo){
        if($data){

                $name=$data['name'];
                $description=$data['description'];
                if(!empty($name)&& !empty($description)){

                    $stmt=$pdo->prepare('INSERT INTO categories(name,description) VALUE (:name,:description)');
                    $result=$stmt->execute(array(':name'=>$name,':description'=>$description));
                    if($result){
                        echo '<script>alert("successfully added");window.location.href="category.php"</script>';
                    }else{
                        echo '<script>alert("cannot add");window.location.href="category.php"</script>';

                    }
                }else{
                    echo '<script>alert("cannot add");</script>';
                }
            }

        }

    public function delete($pdo){
        $ID=$_GET['id'];
        $sql = 'DELETE FROM categories WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $ID);

        $result=$stmt->execute();
        if(isset($result)){

            echo '<script>alert("Successful Delete");
        window.location.href="category.php";
        </script>';}
    }

}