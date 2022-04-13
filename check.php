<?php
session_start();
require('dbconnect.php');

if(!isset($_SESSION['join'])) {
  header('Location: index.php');
  exit();
}

if(!empty($_POST)) {
  // 登録処理をする
  $statement = $db->prepare('INSERT INTO members SET email=?, password=?, created=NOW()');
  echo $ret = $statement->execute(array(
    $_SESSION['join']['email'],
    sha1($_SESSION['join']['password']) // sha1()はセキュリティ的に望ましくないため、将来的には変更をする。PHPリファレンス要確認
  ));
  unset($_SESSION['join']); // 入力情報(join)を削除している、特録済みなので。これをすることで重複登録を避けることができる
  header('Location: thanks.php');
  exit();
}
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
        <h2 class="page-title">登録内容を確認してください</h2>
        <form action="#" method="post">
          <input type="hidden" name="action" value="submit" />
          <dl>
            <dt><label for="email">email</label></dt>
            <dd>
            <?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?>
            </dd>
            <dt><label for="password">password</label></dt>
            <dd>※表示されません</dd>
          </dl>
          <div>
            <input type="button" class="rewrite" value="修正" onclick="location.href='index.php?action=rewrite'"/><input type="submit" class="button" value="signup"/>
          </div>
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