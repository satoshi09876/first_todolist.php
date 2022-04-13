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
        <li><a href= "index.php">signup</a></li>
      </ul>
    </nav> 
  </header>
  <main>
    <div id="login-form"class="big-bg">
      <div class="wrapper">
        <h2 class="page-title">登録が完了しました！</h2>
          <div>
            <input type="submit" class="button" value="SIGNIN" onclick="location.href='login.php'">
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