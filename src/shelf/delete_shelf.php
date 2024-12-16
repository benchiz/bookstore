<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/database.php";
include_once "../../src/objects/shelf.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$shelf = new Shelf($dbConn);

$data = json_decode(file_get_contents("php://input"));

$shelf->id = $data->id;

if ($shelf->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Полка удалена"), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Не удалось удалить полку из-за тех. неполадок сервера"));
}

$dbConn = null;
?>