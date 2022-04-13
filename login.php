<?php
require('dbconnect.php');
session_start();

if ($_COOKIE['email'] != '') {
  $_POST['email'] = $_COOKIE['email'];
  $_POST['password'] = $_COOKIE['password'];
  $_POST['save'] = 'on';
}

if (!empty($_POST)) {
  // ログインの処理
  if ($_POST['email'] != '' && $_POST['password'] != '') {
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password']) // sha1は不可逆暗号、同じ情報を入れると同じ文字列のパターンになる性質を使ってパスワードを照合する
    ));
    $member = $login->fetch();

    if ($member) {
      // ログイン成功
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();
        // ログイン情報を記録する
        if ($_POST['save'] == 'on') {
          setcookie('email', $_POST['email'], time()+60*24*2);
          setcookie('password', $_POST['password'], time()+60*24*2); // Cookieの保存期間を14日間に設定している
        }
      header('Location: todo.php'); exit();
    } else {
      $error['login'] = 'failed';
    }
  } else {
    $error['login'] = 'blank';
  }
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

  <title>signin.php</title>
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
        <h2 class="page-title">ログインする</h2>
        <div class="supplement">
          <h5>アカウントをお持ちで無い方は、こちらから作成してください</h5>
          <p>&raquo;<a href="index.php">SIGNUP</a></p><br>
        </div> 
        <form action="" method="post">
          <dl>
            <!-- email -->
            <dt><label for="email">email</label></dt>
            <input type="text" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>"/>
            <?php if ($error['email'] == 'blank'): ?>
            <p class="error">* メールアドレスを入力してください</p>
            <?php endif; ?>
            <?php if ($error['login'] == 'failed'): ?>
            <p class="error">* ログインに失敗しました。正しくご記入ください。</p>
            <?php endif; ?>
            <!-- パスワード -->
            <dt><label for="password">password</label></dt>
            <dd><input type="password" id="password" name="password" size="10" maxlength="20" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>" />
            </dd>
            <dd>
              <input id="save" type="checkbox" name="save" value="on">次回からは自動的にログインする
            </dd>
          </dl>
          <input type="submit" class="button" value="SIGNIN">
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