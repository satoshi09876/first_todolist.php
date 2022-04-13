<?php
try {
    $db = new PDO('mysql:dbname=todo_lists;host=localhost;charset=utf8mb4', 'root', 'root');
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
}
?>