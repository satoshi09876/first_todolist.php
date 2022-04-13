<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    // 投稿を検査
    $messages = $db->prepare('SELECT * FROM tasks WHERE id=?');
    $messages->execute(array($id));
    $message = $messages->fetch();

    // 更新
    if ($message['member_id'] == $_SESSION['id']) {
        $update = $db->prepare('UPDATE tasks SET message=?, title=? WHERE id=?');
        $update->execute(array($_POST['message'], $_POST['title']));
    }
}
header('Location: todo.php');
?>