<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // Отправка данных на сервер
header("Access-Control-Max-Age: 3600"); // Количество секунд, на которые предзапрос может быть кеширован и опущен при запросах к серверу.
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/database.php";
include_once "../../src/objects/book.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$book = new Book($dbConn);

// Получение отправленных данных
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->title) && 
    !empty($data->publication_date) && 
    !empty($data->category) && 
    !empty($data->page_count) && 
    !empty($data->price) && 
    !empty($data->author) && 
    !empty($data->genre) && 
    !empty($data->bookstore_id)) {
        
    $book->title = $data->title;
    $book->publication_date = $data->publication_date;
    $book->category = $data->category;
    $book->page_count = $data->page_count;
    $book->price = $data->price;
    $book->author = $data->author;
    $book->genre = $data->genre;
    $book->bookstore_id = $data->bookstore_id;

    // Для необязательных атрибутов (DEFAULT NOT NULL)
    $book->binding = isset($data->binding) ? $data->binding : null;
    $book->book_identifier = isset($data->book_identifier) ? $data->book_identifier : null;
    $book->publisher = isset($data->publisher) ? $data->publisher : null;
    $bookstoreId = isset($data->bookstore_id) && !empty($data->bookstore_id) ? (int)$data->bookstore_id : null;

    if ($book->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Книга была успешно добавлена."), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Невозможно добавить книгу из-за тех. неполадок сервера."), JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Невозможно добавить книгу, так как данные заполнены не полностью."), JSON_UNESCAPED_UNICODE);
}

$dbConn = null;
?>