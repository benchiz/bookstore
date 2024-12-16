<?php
class Shelf {
    private $conn;
    private $table_name = "shelf";

    public $id;
    public $category;
    public $placement;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO shelf (category, placement) VALUES (:category, :placement)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':placement', $this->placement);
        
        if($stmt->execute()) {
            return true;
        }
        
        //error_log(print_r($stmt->errorInfo(), true));
        
        return false;
    }

    public function read() {
        $query = "SELECT * FROM $this->table_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT category, placement FROM $this->table_name WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->category = $row['category'];
            $this->placement = $row['placement'];
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET category = :category, placement = :placement WHERE id = :id";

        $stmt = $this->conn->prepare($query);
    
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->placement = htmlspecialchars(strip_tags($this->placement));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':placement', $this->placement);
        $stmt->bindParam(':id', $this->id);
    
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Ошибка при выполнении запроса: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public function delete() {
        $query = "DELETE FROM book_shelf WHERE shelf_id = :shelf_id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':shelf_id', $this->id);
        $stmt->execute();    

        $query = "DELETE FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category ILIKE :keyword";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);

        return $stmt;
    }

    public function count() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>