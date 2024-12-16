<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../src/objects/shelf.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$shelf = new Shelf($dbConn);

$stmt = $shelf->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $shelfs_arr = array();
    $shelfs_arr["shelfs"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $shelf_item = array(
            "id" => $id,
            "category" => $category,
            "placement" => $placement
        );
        array_push($shelfs_arr["shelfs"], $shelf_item);
    }

    http_response_code(200);
    echo json_encode($shelfs_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Полки не найдены."), JSON_UNESCAPED_UNICODE);
}

$dbConn = null;
?>