<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: accept");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once "../../config/database.php";
include_once "../../src/objects/book.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$book = new Book($dbConn);

// Свойство ID записи для чтения
$book->id = isset($_GET["id"]) ? $_GET["id"] : die();

// Получение деталей одной книги
$book->readOne();

if ($book->title != null) {
    $book_arr = array(
        "title" => $book->title,
        "binding" => $book->binding,
        "publication_date" => $book->publication_date,
        "book_identifier" => $book->book_identifier,
        "publisher" => $book->publisher,
        "category" => $book->category,
        "page_count" => $book->page_count,
        "price" => $book->price,
        "author" => $book->author,
        "genre" => $book->genre,
        "bookstore_id" => $book->bookstore_id
    );
    http_response_code(200);
    echo json_encode($book_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Такой книги нет в данном магазине"), JSON_UNESCAPED_UNICODE);
}

$dbConn = null;
?>