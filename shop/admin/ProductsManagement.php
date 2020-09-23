<?php


class ProductsManagement
{
    public function show($data, $pdo)
    {


        if (!empty($_GET['page_no'])) {
            $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
        }
        $num_of_regs = 3;
        $offset = ($page_no - 1) * $num_of_regs;


        if (empty($data['search']) && !isset($_COOKIE['search'])) {

            $stmt = $pdo->prepare("SELECT * FROM products  ORDER BY id DESC");

            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $pdo->prepare("SELECT * FROM products  ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $products = $stmt->fetchAll();
        } else {
            $search_key = isset($data['search']) ? $data['search'] : $_COOKIE['search'];

            $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search_key%'  ORDER BY id DESC");
            $stmt->execute();
            $raw_result = $stmt->fetchAll();
            $total_page = ceil(count($raw_result) / $num_of_regs);

            $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search_key%' ORDER BY id DESC LIMIT $offset, $num_of_regs");

            $stmt->execute();
            $products = $stmt->fetchAll();
        }


        return [$total_page, $products, $page_no, $offset];
    }

    public function add($data, $file,$pdo)
    {

        if (!empty($data)) {

            $targetFile = 'product_img/' . rand(time(), time()) . $file['image']['name'];
            $imageName = rand(time(), time()) . $file['image']['name'];
            $imageType = pathinfo($targetFile, PATHINFO_EXTENSION);

            if (empty($file['image']['name']) || empty($data['name']) || empty($data['description']) ||
                empty($data['price']) || empty($data['quantity']) || empty($data['category_id'])) {

                if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg')
                    $error['image'] = 'Image must be jpg, png or jpeg';
                if(empty($data['name']))
                    $error['name']='name cannot be blank';
                if(empty($data['description']))
                    $error['description']='description cannot be blank';
                if(empty($data['price']))
                    $error['price']='price cannot be blank';
                if(empty($data['quantity']))
                    $error['quantity']='quantity cannot be blank';
                if(empty($data['category_id']))
                    $error['category']='category cannot be blank';
                if(empty($file['image']['name']))
                    $error['image']='image cannot be blank';

                return $error;

            } else {
                move_uploaded_file($file['image']['tmp_name'], $targetFile);

                $sql = "INSERT INTO products(name,description,image,price,quantity,category_id) VALUES(:name,:description,:image,:price,:quantity,:category_id)";
                $pdo_statement = $pdo->prepare($sql);
                $result = $pdo_statement->execute(
                    array(':name' => $data['name'], ':description' => $data['description'], ':image' => $imageName, ':price' => $data['price'],
                        ':quantity' => $data['quantity'], ':category_id' => $data['category_id']));

                if (isset($result)) {
                    echo "<script>alert('record is added');window.location.href='index.php';</script>";
                } else {
                    echo "<script>alert('record cannot be added');</script>";
                }
            }

        }


    }


}

