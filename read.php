<?php
require('dbconnect.php');
session_start();

// todoがDBに入っていない場合の処理、todoのページに戻す
if (empty($_REQUEST['id'])) {
    header('Location: todo.php'); exit();
}

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];
    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
}
// 投稿を取得する
$tasks = $db->prepare('SELECT m.email, t.* FROM members m, tasks t WHERE m.id=t.member_id AND t.id=? ORDER BY t.created DESC');
$tasks->execute(array($_REQUEST['id']));
?>
<!doctype html>
<html lang="ja">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap,CSS -->
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link rel="stylesheet" href="css/style.css">

  <!-- googlefonts -->  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

  <title>index.php</title>
</head>
<body>
<header class="page-header wrapper">
    <h1>TODO-LIST</h1>
    <nav>
        <ul class="main-nav">
        <li><a href="login.php">signin</a></li>
        <li><a href="index.php">signup</a></li>
        </ul>
    </nav> 
</header>
<main>
    <div id="login-form"class="big-bg">
        <div class="wrapper">
            <h2 class="page-title">EDIT-TODO</h2>
            <p class="username"><?php echo htmlspecialchars($member['email'], ENT_QUOTES); ?>さん、todo-listを編集してください。</p>
            <p>&laquo;<a href="todo.php">todo一覧に戻る</a></p>
            <form action="update_do.php" method="post">
                <?php if ($task = $tasks->fetch()): ?>
                    <input type="hidden" name="id" value="<?php print($task['id']) ?>">
                    <dl>
                    <dt><label for="todo-title">タイトル</label></dt>
                    <dd><input type="title" name="title" size="35" maxlength="255" value="<?php echo htmlspecialchars($task['title'], ENT_QUOTES); ?>" <?php print($task['title']); ?>/>

                    <dt><label for="todo-content">内容</label></dt>
                    <dd><textarea name="message" cols="50" rows="3"><?php echo htmlspecialchars($task['message'], ENT_QUOTES); ?></textarea>
                    </dl>
                <?php else: ?>
                    <p>その投稿は削除されたか、URLが間違えています。</p>
                <?php endif; ?>
                <input type="submit" class="button" value="修正">
            </form>
        </div> <!-- /.wrapper -->
    </div>
</main>
<footer>
    <div class="wrapper">
      <p><small>&copy; 2022 todo-list</p>
    </div>
</footer>
</body>
</html>