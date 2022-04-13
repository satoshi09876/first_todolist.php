<?php
require('dbconnect.php');
session_start();
if (!empty($_POST)) {
  // // バリデーションに使う正規表現
  // $pattern = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$/";
  // エラーの確認
  if ($_POST['email'] == '') {
    $error['email'] = 'blank';
  }
  if (strlen($_POST['password']) < 4) {
    $error['password'] = 'Length';
  }
  if ($_POST['password'] == '') {
    $error['password'] = 'blank';
  }
  // 重複アカウントチェック
  if (empty($error)) {
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if ($record['cnt'] > 0) {
      $error['email'] = 'duplicate';
    }
  }
  if (empty($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}
// 書き直し
if ($_REQUEST['action'] == 'rewrite') {
  $_POST = $_SESSION['join'];
  $error['rewrite'] = true;
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
        <h2 class="page-title">新規登録</h2>
        <form action="" method="post">
          <dl>
            <!-- email -->
            <dt><label for="email">email</label></dt>
            <input type="text" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>"/>
            <?php if ($error['email'] == 'blank'): ?>
            <p class="error">* メールアドレスを入力してください</p>
            <?php endif; ?>
            <?php if ($error['email'] == 'duplicate'): ?>
            <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
            <?php endif; ?>
                <!-- <?php if (preg_match($pattern,$_POST)): ?>
                <p class="error">* 不正な形式のメールアドレスです</p>
                <?php endif; ?> -->
            <!-- パスワード -->
            <dt><label for="password">password</label></dt>
            <dd><input type="password" id="password" name="password" size="10" maxlength="20" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>" />
              <?php if($error['password'] == 'blank'): ?>
                <p class="error">* パスワードを入力してください</p>
              <?php endif; ?>
              <?php if($error['password'] == 'Length'): ?>
                <p class="error">* パスワードは4文字以上で入力してください</p>
              <?php endif; ?>
            </dd>
          </dl>
          <input type="submit" class="button" value="入力内容の確認">
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