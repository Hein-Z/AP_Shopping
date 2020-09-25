<?php


class CatManagement
{
    protected $pdo;
    function __construct(PDO $pdo)
    {
        $this->pdo=$pdo;
    }


    public function update($data){
        if($data){
            $name=$data['name'];
            $description=$data['description'];

            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE name=:name and id!=:id");
            $stmt->execute(array(':name' => $name,':id'=>$_GET['id']));
            $result = $stmt->fetch();




            if (!empty($result)) {
                $error['name']='This category already exist!';
            }
            if(empty($name)){
                $error['name']='Name is required';
            }
            if(empty($description)){
                $error['description']='Description is required';
            }

            if(!empty($name) && !empty($description)){
                    $stmt=$this->pdo->prepare('UPDATE categories SET name=:name, description=:description WHERE id=:id');
                    $result=$stmt->execute(array(':name'=>$name,':description'=>$description,':id'=> $_GET['id'] ));

                if(isset($result)){
                    echo '<script>alert("successfully edited");window.location.href="category.php";</script>';

                }else{
                    echo '<script>alert("cannot edited");</script>';
                }
            }else{
                return $error;
            }
        }

    }
    public function add($data){
        if($data){
            $name=$data['name'];
            $description=$data['description'];

            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE name=:name");
            $stmt->execute(array(':name' => $name));
            $result = $stmt->fetch();



            if (!empty($result)) {
                $error['name']='This category already exist!';
            }
            if(empty($name)){
                $error['name']='please fill the name';
            }
            if(empty($description)){
                $error['description']='please fill the description';
            }



                if(!empty($name)&& !empty($description)){

                    $stmt=$this->pdo->prepare('INSERT INTO categories(name,description) VALUE (:name,:description)');
                    $result=$stmt->execute(array(':name'=>$name,':description'=>$description));
                    if($result){
                        echo '<script>alert("successfully added");window.location.href="category.php"</script>';
                    }else{
                        echo '<script>alert("cannot add");window.location.href="category.php"</script>';

                    }
                }else{
                    return $error;
                }
            }

        }

    public function delete(){
        $ID=$_GET['id'];
        $sql = 'DELETE FROM categories WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $ID);

        $result=$stmt->execute();
        if(isset($result)){

            echo '<script>alert("Successful Delete");
        window.location.href="category.php";
        </script>';}
    }

    public function show($data){


        if (!empty($_GET['page_no'])) {
            $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
        }
        $num_of_regs = 3;
        $offset = ($page_no - 1) * $num_of_regs;


        if (empty($data['search']) && !isset($_COOKIE['search'])) {

            $stmt = $this->pdo->prepare("SELECT * FROM categories ORDER BY id DESC");

            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $this->pdo->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $categories = $stmt->fetchAll();
        } else {
            $search_key = isset($data['search']) ? $data['search'] : $_COOKIE['search'];

            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$search_key%'  ORDER BY id DESC");

            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$search_key%' ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $categories = $stmt->fetchAll();
        }
        return [$total_page, $categories,$page_no,$offset];
    }
    public function edit(){
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id=:id");

        $stmt->execute(array(':id'=>$_GET['id']));
        $categories = $stmt->fetch();
        return $categories;
    }
}