<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: ../member/regist.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>新規会員登録 入力内容確認画面 | PON PON</title>
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
            <section class="inner inner--middle">
                <div class="title">
                    <h1>新規会員登録</h1>
                </div>
                <div class="form form--confirm form__login">
                    <div class="form__login--left">
                        <h2 class="form__title">基本情報</h2>
                        <form action="../includes/regist-complete.inc.php" method="POST">
                            <dl class="form-inputGroup form-inputGroup__confirm">
                                <dt><label>ユーザーID</label></dt>
                                <dd>#<?php echo $_SESSION["id"] ?></dd>
                                <dt><label>郵便番号</label></dt>
                                <dd>〒 <?php echo $_SESSION["postal_code"] ?></dd>
                                <dt><label>住所</label></dt>
                                <dd><?php echo $_SESSION["postal_info"] ?></dd>
                                <dt><label>メールアドレス</label></dt>
                                <dd><?php echo $_SESSION["email"] ?></dd>
                                <dt><label>パスワード</label></dt>
                                <dd>●●●●●●●●</dd>
                            </dl>
                            <div class="form-buttonGroup">
                                <button type="button" onClick="history.back(); return false;" class="form-buttonGroup__button form-buttonGroup__button--out">修正する</button>
                                <button class="form-buttonGroup__button form-buttonGroup__button--in" type="submit" name="submit">登録する</button>
                            </div>
                        </form>
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