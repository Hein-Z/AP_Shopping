<?php


class CatManagement
{
    public function update($data,$pdo){
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

    public function show($data,$pdo){


        if (!empty($_GET['page_no'])) {
            $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
        }
        $num_of_regs = 3;
        $offset = ($page_no - 1) * $num_of_regs;


        if (empty($data['search']) && !isset($_COOKIE['search'])) {

            $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");

            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $categories = $stmt->fetchAll();
        } else {
            $search_key = isset($data['search']) ? $data['search'] : $_COOKIE['search'];

            $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$search_key%'  ORDER BY id DESC");

            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$search_key%' ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $categories = $stmt->fetchAll();
        }
        return [$total_page, $categories,$page_no,$offset];
    }
    public function edit($pdo){
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=:id");

        $stmt->execute(array(':id'=>$_GET['id']));
        $categories = $stmt->fetch();
        return $categories;
    }
}