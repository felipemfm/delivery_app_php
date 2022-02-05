<?php
session_start();
if (isset($_SESSION["error"])) {
  if ($_SESSION["error"] == "emptyInput")
    echo '<script type="text/javascript">alert("入力してください");</script>';
  if ($_SESSION["error"] == "postal")
    echo '<script type="text/javascript">alert("無効な郵便番号");</script>';
  if ($_SESSION["error"] == "userid")
    echo '<script type="text/javascript">alert("無効なユーザーID");</script>';
  if ($_SESSION["error"] == "email")
    echo '<script type="text/javascript">alert("無効なメールアドレス");</script>';
  if ($_SESSION["error"] == "userExists")
    echo '<script type="text/javascript">alert("既にユーザーIDが登録されています");</script>';
  session_unset();
  session_destroy();
}
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>新規会員登録 | PON PON</title>
<meta name="description" content="買物も、配送も全てお任せ!一家に一台「完全自律型ドローン」が個人物流時代の幕を開ける。">
<!-- css -->
<link rel="stylesheet" href="../css/style.css" media="screen">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
<!-- favicon -->
<link rel="icon" href="../images/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
</head>

<body id="body--mypage" class="preload">
  <!-- fix area -->
  <div id="fixContents" class="fixContents--clear">
    <!-- header -->
    <header class="header">
      <div class="logo">
        <p class="logo__text"><a href="../index.php">PON PON</a></p>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 254.264 80">
          <path id="logo__bg" class="logo__bg" d="M0,0H254.264S221.724,3,200,40.621,143.9,80,121.807,80H0Z" fill="#f22580" />
        </svg>
      </div>
      <div class="header__member">
        <ul class="header__navigation header__navigation--login header__navigation--right">
          <li class="active"><a href="index.php">ログイン</a></li>
        </ul>
      </div>
    </header>
  </div>
  <!-- main -->
  <main class="main member">
    <article class="wrap">
      <!-- regist -->
      <section class="inner inner--large">
        <div class="title">
          <h1>新規会員登録</h1>
        </div>
        <div class="form form__login">
          <div class="form__login--left">
            <h2 class="form__title">基本情報</h2>
            <form action="../includes/regist.inc.php" method="POST">
              <dl class="form-inputGroup">
                <dt><label>ユーザーID</label></dt>
                <dd>
                  <input type="text" name="id" value="" placeholder="半角英数字" autocomplete="off">
                </dd>
                <dt><label>郵便番号</label></dt>
                <dd><input type="text" name="postal-code" value="" placeholder="160-0023" autocomplete="postal-code"></dd>
                <dt><label>メールアドレス</label></dt>
                <dd><input type="email" name="email" value="" placeholder="hal@ponpon.co.jp" autocomplete="email"></dd>
                <dt><label>パスワード</label></dt>
                <dd>
                  <input type="password" name="password" value="" placeholder="半角英数字">
                </dd>
              </dl>
              <div class="form-buttonGroup">
                <button class="form-buttonGroup__button form-buttonGroup__button--in" type="submit" name="submit">登録内容確認</button>
              </div>
              <span class="form__login--regist"><a href="index.php">PON PON会員の方はこちら</a></span>
            </form>
          </div>
          <!-- visual -->
          <div class="form__login--right">
            <div class="form__visual">
              <img src="../images/ponpon-regist-visual.png" alt="PON PON体験版 | イメージ画像" loading="lazy">
            </div>
          </div>
        </div>
        </div>
      </section>
    </article>
  </main>
  <!-- footer -->
  <footer class="footer">
    <small>Copyright <i class="far fa-copyright"></i> 2021-2022 PON PON All Rights Reserved.</small>
  </footer>
  <!-- javascript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
  <script type="text/javascript" src="../js/common.js"></script>
</body>

</html>