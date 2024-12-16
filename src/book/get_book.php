<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$query = "SELECT id, title FROM book";
$stmt = $dbConn->prepare($query);
$stmt->execute();

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(array("books" => $books));

$dbConn = null;
?>