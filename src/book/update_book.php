<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/database.php";
include_once "../../src/objects/book.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$book = new Book($dbConn);

$data = json_decode(file_get_contents("php://input"));

$book->id = $data->id;

// Присвоение значений свойств товара
$book->title = $data->title;
$book->binding = $data->binding;
$book->publication_date = $data->publication_date;
$book->book_identifier = $data->book_identifier;
$book->publisher = $data->publisher;
$book->category = $data->category;
$book->page_count = $data->page_count;
$book->price = $data->price;
$book->author = $data->author;
$book->genre = $data->genre;
$book->bookstore_id = $data->bookstore_id;

if ($book->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Данная позиция товара была изменена."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Невозможно изменить позицию книги из-за тех. неполадок сервера."), JSON_UNESCAPED_UNICODE);
}

$dbConn = null;
?>