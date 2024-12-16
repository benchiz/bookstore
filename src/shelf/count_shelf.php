<?php
header("Content-Type: text/html; charset=UTF-8");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; script-src 'self';");

include_once "../../config/database.php";
include_once "../../src/objects/shelf.php";

$db = new Database();
$dbConn = $db->getConnectionInstance();

$shelf = new Shelf($dbConn);

$total_shelfs = $shelf->count();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Количество полок</title>
</head>
<body>
    <h1>Список полок</h1>
    
    <?php if ($total_shelfs > 0): ?>
        <p>Всего полок в магазине: <strong><?php echo htmlspecialchars($total_shelfs); ?></strong></p>
    <?php else: ?>
        <p>Указанные полки отсутствуют в магазине.</p>
    <?php endif; ?>
</body>
</html>

<?php
$dbConn = null;
?>