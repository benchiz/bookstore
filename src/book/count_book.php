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

$total_books = $book->count();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Количество книг</title>
</head>
<body>
    <h1>Список книг</h1>
    
    <?php if ($total_books > 0): ?>
        <p>Всего книг в базе данных: <strong><?php echo htmlspecialchars($total_books); ?></strong></p>
    <?php else: ?>
        <p>Книги в базе данных отсутствуют.</p>
    <?php endif; ?>
</body>
</html>

<?php
$dbConn = null;
?>