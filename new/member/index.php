<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyInput") {
        echo '<script type="text/javascript">alert("入力してください");</script>';
    }
    if ($_GET["error"] == "wrongLogin") {
        echo '<script type="text/javascript">alert("ユーザーIDまたはメールアドレスが正しくありません");</script>';
    }
}
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ログイン | PON PON</title>
<meta name="description" content="買物も、配送も全てお任せ!一家に一台「完全自律型ドローン」が個人物流時代の幕を開ける。">
<!-- css -->
<link rel="stylesheet" href="../css/style.css" media="screen">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
<!-- favicon -->
<link rel="icon" href="../images/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
</head>

<body class="preload">
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
            <!-- login -->
            <section class="inner inner--middle">
                <div class="title">
                    <h1>ログイン</h1>
                </div>
                <div class="form form__login">
                    <div class="form__login--left">
                        <h2 class="form__title">PON PON IDでログイン</h2>
                        <form action="../includes/login.inc.php" method="post">
                            <dl class="form-inputGroup">
                                <dt><label>PON PON ID</label></dt>
                                <dd><input type="text" name="input" value="" placeholder="ユーザIDまたはメールアドレス"></dd>
                                <dt><label>パスワード</label></dt>
                                <dd>
                                    <input type="password" name="password" value="" placeholder="半角英数字">
                                    <!-- <span class="form__login--forgot"><a href="#">パスワードをお忘れの方</a></span> -->
                                </dd>
                            </dl>
                            <div class="form-buttonGroup">
                                <button class="form-buttonGroup__button form-buttonGroup__button--in" type="submit" name="submit">ログイン</button>
                            </div>
                            <span class="form__login--regist"><a href="regist.php">はじめてご利用の方（新規会員登録）</a></span>
                        </form>
                    </div>
                    <!-- visual -->
                    <div class="form__login--right">
                        <div class="form__visual">
                            <img src="../images/ponpon-login-visual.png" alt="PON PON体験版 | イメージ画像" loading="lazy">
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