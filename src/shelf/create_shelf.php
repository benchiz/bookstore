<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/database.php";
include_once "../../src/objects/shelf.php";
include_once "../../src/objects/book_shelf.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();
$shelf = new Shelf($dbConn);
$bookShelf = new BookShelf($dbConn); 

$data = json_decode(file_get_contents("php://input"));

//error_log("Category: " . $data->category);
//error_log(print_r($data, true));

if (!empty($data->category) && !empty($data->placement) && !empty($data->book_id)) {
    $shelf->category = $data->category;
    $shelf->placement = $data->placement;

    if ($shelf->create()) {
        $shelfId = $dbConn->lastInsertId();

        // Добавление записи в таблицу book_shelf
        $bookShelf->book_id = $data->book_id; 
        $bookShelf->shelf_id = $shelfId;

        if ($bookShelf->addBookToShelf()) { 
            http_response_code(201);
            echo json_encode(array("message" => "Полка была успешно добавлена и книга связана с полкой."), JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Не удалось связать книгу с полкой из-за тех. неполадок сервера."), JSON_UNESCAPED_UNICODE);
        }
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Невозможно добавить полку из-за тех. неполадок сервера."), JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Невозможно добавить полку, так как данные заполнены не полностью."), JSON_UNESCAPED_UNICODE);
}

$dbConn = null;
?>