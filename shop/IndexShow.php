<?php


class IndexShow
{
    protected $pdo;
    protected $numOfrecs;
    protected $offset;

    function __construct(PDO $pdo, $numberOfrecs, $offset)
    {
        $this->pdo = $pdo;
        $this->numOfrecs = $numberOfrecs;
        $this->offset = $offset;
    }

    public function selectAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE quantity > 0");
        $stmt->execute();
        $rawResult = $stmt->fetchAll();

        $total_pages = ceil(count($rawResult) / $this->numOfrecs);

        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT $this->offset,$this->numOfrecs");
        $stmt->execute();
        $result = $stmt->fetchAll();

        return [$total_pages, $result];
    }

    public function selectCat($category)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id=:category AND quantity > 0");
        $stmt->execute([':category' => $category]);
        $rawResult = $stmt->fetchAll();

        $total_pages = ceil(count($rawResult) / $this->numOfrecs);

        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id=:category AND quantity > 0 ORDER BY id DESC LIMIT $this->offset,$this->numOfrecs");
        $stmt->execute([':category' => $category]);
        $result = $stmt->fetchAll();

        return [$total_pages, $result];
    }

    public function selectSearch($searchKey)
    {

        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0");
        $stmt->execute();
        $rawResult = $stmt->fetchAll();

        $total_pages = ceil(count($rawResult) / $this->numOfrecs);

        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC LIMIT $this->offset,$this->numOfrecs");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return [$total_pages, $result];
    }

    public function selectSearchCat($searchKey, $category)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id=:category AND name LIKE '%$searchKey%' AND quantity > 0");
        $stmt->execute([':category' => $category]);
        $rawResult = $stmt->fetchAll();

        $total_pages = ceil(count($rawResult) / $this->numOfrecs);

        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id=:category AND name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC LIMIT $this->offset,$this->numOfrecs");
        $stmt->execute([':category' => $category]);
        $result = $stmt->fetchAll();
        return [$total_pages, $result];
    }
}