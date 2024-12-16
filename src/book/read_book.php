<?php
header("Access-Control-Allow-Origin: *"); // Чтение доступно всем пользователям
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../src/objects/book.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$book = new Book($dbConn);

// Запрос книг
$stmt = $book->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $books_arr = array();
    $books_arr["books"] = array();

    // Получение содержимого таблицы Book
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $book_item = array(
            "id" => $id,
            "title" => $title,
            "binding" => $binding,
            "publication_date" => $publication_date,
            "book_identifier" => $book_identifier,
            "publisher" => $publisher,
            "category" => $category,
            "page_count" => $page_count,
            "price" => $price,
            "author" => $author,
            "genre" => $genre,
            "bookstore_id" => $bookstore_id
        );
        array_push($books_arr["books"], $book_item);
    }
    http_response_code(200);
    echo json_encode($books_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Книги не найдены."), JSON_UNESCAPED_UNICODE);
}

$dbConn = null;
?>