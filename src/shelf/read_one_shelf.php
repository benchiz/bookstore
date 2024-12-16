<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: accept");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once "../../config/database.php";
include_once "../../src/objects/shelf.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$shelf = new Shelf($dbConn);

$shelf->id = isset($_GET["id"]) ? $_GET["id"] : die();

$shelf->readOne();

if ($shelf->placement != null) {
    $shelf_arr = array(
        "category" => $shelf->category,
        "placement" => $shelf->placement
    );
    http_response_code(200);
    echo json_encode($shelf_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Такой полки нет в данном магазине"), JSON_UNESCAPED_UNICODE);
}

$dbConn = null;
?>