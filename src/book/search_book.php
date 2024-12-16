<?php
header("Content-Type: text/html; charset=UTF-8");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; script-src 'self';");

include_once "../../config/database.php";
include_once "../../src/objects/book.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$book = new Book($dbConn);

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты поиска</title>
</head>
<body>
    <h1>Найденные книги</h1>

<?php
if ($search) {
    $result = $book->search($search);
    echo "<h2>Результаты поиска для: " . htmlspecialchars($search) . "</h2>";
    echo "<ul>";
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . htmlspecialchars($row['title']) . " - " . htmlspecialchars($row['author']) . "</li>";
        }
    } else {
        echo "<li>Нет результатов для поиска: " . htmlspecialchars($search) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<h2>Пожалуйста, введите запрос для поиска.</h2>";
}
?>

</body>
</html>
<?php
$dbConn = null; // Закрываем соединение
?>