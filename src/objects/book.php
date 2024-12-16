<?php
class Book
{
    private $conn;
    private $table_name = "book";

    public $id;
    public $title;
    public $binding;
    public $publication_date;
    public $book_identifier;
    public $publisher;
    public $category;
    public $page_count;
    public $price;
    public $author;
    public $genre;
    public $bookstore_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = <<<END
        SELECT b.id, b.title, b.binding, b.publication_date, b.book_identifier, b.publisher, b.category, b.page_count, b.price, b.author, b.genre, b.bookstore_id, bs.name AS bookstore_name, bs.address
        FROM 
        $this->table_name b
        LEFT JOIN 
            bookstore bs ON b.bookstore_id = bs.id
        ORDER BY
            b.publication_date DESC;
        END;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT title, binding, publication_date, book_identifier, publisher, category, page_count, price, author, genre, bookstore_id FROM $this->table_name WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->binding = $row['binding'];
            $this->publication_date = $row['publication_date'];
            $this->book_identifier = $row['book_identifier'];
            $this->publisher = $row['publisher'];
            $this->category = $row['category'];
            $this->page_count = $row['page_count'];
            $this->price = $row['price'];
            $this->author = $row['author'];
            $this->genre = $row['genre'];
            $this->bookstore_id = $row['bookstore_id'];
        } else {
            $this->id = null; 
            $this->title = null;
        }
    }

    public function create()
    {
        $query = <<<END
        INSERT INTO $this->table_name (title, binding, publication_date, book_identifier, publisher, category, page_count, price, author, genre, bookstore_id) 
        VALUES (:title, :binding, :publication_date, :book_identifier, :publisher, :category, :page_count, :price, :author, :genre, :bookstore_id);
        END;
        $stmt = $this->conn->prepare($query);

        // Очистка от HTML и PHP кода
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->binding = htmlspecialchars(strip_tags($this->binding));
        $this->publication_date = htmlspecialchars(strip_tags($this->publication_date));
        $this->book_identifier = htmlspecialchars(strip_tags($this->book_identifier));
        $this->publisher = htmlspecialchars(strip_tags($this->publisher));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->page_count = htmlspecialchars(strip_tags($this->page_count));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->genre = htmlspecialchars(strip_tags($this->genre));
        $this->bookstore_id = htmlspecialchars(strip_tags($this->bookstore_id));

        // Привязка значений
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":binding", $this->binding);
        $stmt->bindParam(":publication_date", $this->publication_date);
        $stmt->bindParam(":book_identifier", $this->book_identifier);
        $stmt->bindParam(":publisher", $this->publisher);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":page_count", $this->page_count);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":bookstore_id", $this->bookstore_id);

        if ($stmt->execute())
            return true;
        return false;
    }

    public function update()
    {
        $query = <<<END
        UPDATE $this->table_name
        SET
            title = :title,
            binding = :binding,
            publication_date = :publication_date,
            book_identifier = :book_identifier,
            publisher = :publisher,
            category = :category,
            page_count = :page_count,
            price = :price,
            author = :author,
            genre = :genre,
            bookstore_id = :bookstore_id
        WHERE
            id = :id;
        END;

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->binding = htmlspecialchars(strip_tags($this->binding));
        $this->publication_date = htmlspecialchars(strip_tags($this->publication_date));
        $this->book_identifier = htmlspecialchars(strip_tags($this->book_identifier));
        $this->publisher = htmlspecialchars(strip_tags($this->publisher));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->page_count = htmlspecialchars(strip_tags($this->page_count));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->genre = htmlspecialchars(strip_tags($this->genre));
        $this->bookstore_id = htmlspecialchars(strip_tags($this->bookstore_id));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":binding", $this->binding);
        $stmt->bindParam(":publication_date", $this->publication_date);
        $stmt->bindParam(":book_identifier", $this->book_identifier);
        $stmt->bindParam(":publisher", $this->publisher);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":page_count", $this->page_count);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":bookstore_id", $this->bookstore_id);

        if ($stmt->execute())
            return true;
        return false;
    }

    public function delete()
    {
        $query = <<<END
        DELETE FROM $this->table_name WHERE id = :id;
        END;

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute())
            return true;
        return false;
    }

    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE title ILIKE :keyword 
                  OR author ILIKE :keyword 
                  OR genre ILIKE :keyword";

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