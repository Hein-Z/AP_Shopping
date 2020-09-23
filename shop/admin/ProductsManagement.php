<?php


class ProductsManagement
{

    public function update($data, $file, $pdo)
    {
        if ($data) {
            if (empty($data['name']) || empty($data['description']) || empty($data['category_id'])
                || empty($data['quantity']) || empty($data['price']) ) {
                if (empty($data['name']))
                    $error['name'] = 'Category name is required';

                if (empty($data['description']))
                    $error['description'] = 'Description is required';

                if (empty($data['category_id']))
                    $error['category'] = 'Category is required';
                elseif (is_numeric($data['category_id']) != 1)
                    $error['category'] = 'Category_id should be integer value';

                if (empty($data['quantity']))
                    $error['quantity'] = 'Quantity is required';
                elseif (is_numeric($data['quantity']) != 1)
                    $error['quantity'] = 'Quantity should be integer value';

                if (empty($data['price']))
                    $error['price'] = 'Price is required';
                elseif (is_numeric($data['price']) != 1)
                    $error['price'] = 'Price should be integer value';

                return $error;

            } else {//validation success

                if (is_numeric($data['quantity']) != 1) {
                    $qtyError = 'Quantity should be integer value';
                }
                if (is_numeric($data['price']) != 1) {
                    $priceError = 'Price should be integer value';
                }

                if (empty($qtyError) && empty($priceError)) {
                    if ($file['image']['name'] != null) {
                        $imageTemp = 'product_img/' . ($file['image']['name']);
                        $imageType = pathinfo($imageTemp, PATHINFO_EXTENSION);

                        if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
                            echo "<script>alert('Image should be jpg,jpeg,png');</script>";
                        } else { //image validation success
                            $name = $data['name'];
                            $desc = $data['description'];
                            $category = $data['category_id'];
                            $qty = $data['quantity'];
                            $price = $data['price'];
                            $image = $file['image']['name'];
                            $id = $_GET['id'];

                            move_uploaded_file($file['image']['tmp_name'], $imageTemp);

                            $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,category_id=:category,
                              price=:price,quantity=:quantity,image=:image WHERE id=:id");

                            $result = $stmt->execute(
                                array(':name' => $name, ':description' => $desc, ':category' => $category, ':price' => $price, ':quantity' => $qty, ':image' => $image, ':id' => $id)
                            );

                            if ($result) {
                                echo "<script>alert('Product is updated');window.location.href='index.php';</script>";
                            }
                        }
                    } else {
                        $name = $data['name'];
                        $desc = $data['description'];
                        $category = $data['category_id'];
                        $qty = $data['quantity'];
                        $price = $data['price'];
                        $id = $_GET['id'];

                        $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,category_id=:category,
                              price=:price,quantity=:quantity WHERE id=:id");
                        $result = $stmt->execute(
                            array(':name' => $name, ':description' => $desc, ':category' => $category, ':price' => $price, ':quantity' => $qty, ':id' => $id)
                        );
                        if ($result) {
                            echo "<script>alert('Product is updated');window.location.href='index.php';</script>";
                        }
                    }
                }

            }
        }
    }

    public function edit($pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=:id");

        $stmt->execute(array(':id' => $_GET['id']));
        $product = $stmt->fetch();
        return $product;
    }

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

    public function add($data, $file, $pdo)
    {

        if (!empty($data)) {

            $targetFile = 'product_img/' . rand(time(), time()) . $file['image']['name'];
            $imageName = rand(time(), time()) . $file['image']['name'];
            $imageType = pathinfo($targetFile, PATHINFO_EXTENSION);

            if (empty($file['image']['name']) || empty($data['name']) || empty($data['description']) ||
                empty($data['price']) || empty($data['quantity']) || empty($data['category_id'])) {

                if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg')
                    $error['image'] = 'Image must be jpg, png or jpeg';
                if (empty($data['name']))
                    $error['name'] = 'name cannot be blank';
                if (empty($data['description']))
                    $error['description'] = 'description cannot be blank';

                if (empty($data['quantity']))
                    $error['quantity'] = 'Quantity is required';
                elseif (is_numeric($data['quantity']) != 1)
                    $error['quantity'] = 'Quantity should be integer value';

                if (empty($data['price']))
                    $error['price'] = 'Price is required';
                elseif (is_numeric($data['price']) != 1)
                    $error['price'] = 'Price should be integer value';

                if (empty($data['category_id']))
                    $error['category'] = 'category cannot be blank';
                elseif (is_numeric($data['price']) != 1)
                    $error['category'] = 'category_id should be integer value';
                if (empty($file['image']['name']))
                    $error['image'] = 'image cannot be blank';

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

    public function delete($pdo)
    {
        $ID = $_GET['id'];
        $sql = 'DELETE FROM products WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $ID);

        $result = $stmt->execute();
        if (isset($result)) {

            echo '<script>alert("Successful Delete");
        window.location.href="index.php";
        </script>';
        } else
            echo '<script>alert("Someting Wrong!.Cannot be Delete");
        window.location.href="index.php";
        </script>';
    }

}

