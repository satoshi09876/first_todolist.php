<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    // 投稿を検査
    $messages = $db->prepare('SELECT * FROM tasks WHERE id=?');
    $messages->execute(array($id));
    $message = $messages->fetch();

    // 削除
    if ($message['member_id'] == $_SESSION['id']) {
        $del = $db->prepare('DELETE FROM tasks WHERE id=?');
        $del->execute(array($id));
    }
}

header('Location: todo.php');
?>