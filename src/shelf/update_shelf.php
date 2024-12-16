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

//error_log(print_r($data, true));

$shelf->id = $data->id;

$shelf->category = $data->category;
$shelf->placement = $data->placement;

if ($shelf->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Данная полка была изменена."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Невозможно изменить указанную полку из-за тех. неполадок сервера."), JSON_UNESCAPED_UNICODE);
}

$dbConn = null;
?>