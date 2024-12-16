<?php
class BookShelf {
    private $conn;
    private $table_name = "book_shelf";

    public $book_id;
    public $shelf_id;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Метод для добавления книги на полку
    public function addBookToShelf() {
        $query = "INSERT INTO " . $this->table_name . " (book_id, shelf_id) VALUES (:book_id, :shelf_id)";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':shelf_id', $this->shelf_id);

        if ($stmt->execute())
            return true;
        return false;
    }

}
?>