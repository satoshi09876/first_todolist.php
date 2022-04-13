<?php
  session_start();
  require('dbconnect.php');
  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) { // ログインしている場合の処理
    $_SESSION['time'] = time(); // 今の時間でセッションを上書きして、現在からさらに60分間ログインが有効になる
    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
  } else { // ログインしていない場合の処理
    header('Location: login.php'); exit();
  }
  // 投稿を記録する（article内に投稿エリア、create todoのコードあり）
  if (!empty($_POST)) {
    if ($_POST['message'] != '' && $_POST['title'] != '' ) {
      $message = $db->prepare('INSERT INTO tasks SET member_id=?, message=?, title=?, created=NOW()');
      $message->execute(array($member['id'], $_POST['message'], $_POST['title']));
      header('Location: todo.php'); exit();
    }
  }
  // 投稿を取得する（aside内に取得した情報を書き出すコードあり）
  $tasks = $db->query('SELECT m.email, t.* FROM members m, tasks t WHERE m.id=t.member_id ORDER BY t.created DESC'); // DESC = 降順.

  
?>
<!DOCTYPE html>
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

  <title>todo.php</title>
</head>
<body>
  <header class="page-header wrapper"> <!-- ヘッダー部分 -->
    <h1>TODO-LIST</h1>
    <nav>
      <ul class="main-nav">
        <li><a href="#">home</a></li>
        <li><a href="#">mypage</a></li>
        <li><a href="#">logout</a></li>
      </ul>
    </nav> 
  </header>
  <main>
    <div id="login-form"class="big-bg">
      <div class="wrapper">  <!-- ヘッダーとtodo contentsの間に記載する部分（ページの概要説明になる箇所） -->
        <h2 class="page-title">TODO-LIST</h2>
        <p class="username"><?php echo htmlspecialchars($member['email'], ENT_QUOTES); ?>さん、todo-listをご活用ください。</p>
      </div> <!-- /.wrapper -->
      <div class="todocontents wrapper"> <!-- create todoと表示するところ、2つを囲うのエリア　-->
        <article> <!-- create todoするとこと　-->
          <h2 class="page-title">Create TODO</h2>
          <form action="" method="post">
          <dl>
            <!-- todo title -->
            <dt><label for="todo-title">タイトル</label></dt>
            <dd><input type="title" name="title" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST[''], ENT_QUOTES); ?>"/>
              <?php if ($error['title'] == 'blank'): ?>
                <p class="error">* タイトルを入力してください</p>
              <?php endif; ?>
            </dd>
            <!-- todo content -->
            <dt><label for="todo-content">内容</label></dt>
            <dd><textarea name="message" cols="50" rows="3"><?php echo htmlspecialchars($_POST[''], ENT_QUOTES); ?></textarea>
              <?php if($error['message'] == 'blank'): ?>
                <p class="error">* 内容を入力してください</p>
              <?php endif; ?>
            </dd>
          </dl>
          <input type="submit" class="button" value="追加">
          </form>
        </article>
        <aside> <!-- todoを表示するとこと　-->
          <div class="todo-list">
            <?php foreach ($tasks as $task): ?>
             <li>
                <!-- todo のタイトル表示、15文字まで表示、16文字以降のは省略し...を追記 -->
                <?php if ((mb_strlen($task['title'])) > 15): ?>
                  <?php echo htmlspecialchars(mb_substr($task['title'], 0, 15)); ?>...
                <?php else: ?>
                  <?php echo htmlspecialchars($task['title'], ENT_QUOTES); ?>
                <?php endif; ?>
                <!-- todoの完了編集削除のボタンと、遷移先のURLを指定 -->
                <?php if ($_SESSION['id'] == $task['member_id']): ?>
                  <button class="done" onclick="location.href='delete.php?id=<?php echo $task['id']; ?>'">Done</button>
                  <button class="read" onclick="location.href='read.php?id=<?php echo $task['id']; ?>'">Edit</button>
                  <button class="delete" onclick="location.href='delete.php?id=<?php echo $task['id']; ?>'">Delete</button>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </div>
        </aside>
      </div> <!-- /.todocontents wrapper -->
    </div> <!-- /.login-form -->
  </main>
  <footer> <!-- フッター部分 -->
    <div class="wrapper">
      <p><small>&copy; 2022 todo-list</p>
    </div>
  </footer>
</body>
</html>
