<?php 
if (!isset($_GET["id"])) {
    header("location: ../member/regist-confirm.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録完了 | PON PON</title>
    <meta name="description" content="買物も、配送も全てお任せ!一家に一台「完全自律型ドローン」が個人物流時代の幕を開ける。">
    <!-- css -->
    <link rel="stylesheet" href="../css/style.css" media="screen">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <!-- favicon -->
    <link rel="icon" href="../images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
</head>
<body id="body--mypage" class="body--fix preload">
    <!-- fix area -->
    <div id="fixContents" class="fixContents--clear">
        <!-- header -->
        <header class="header">
            <div class="logo">
                <p class="logo__text"><a href="../index.php">PON PON</a></p>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 254.264 80">
                    <path id="logo__bg" class="logo__bg" d="M0,0H254.264S221.724,3,200,40.621,143.9,80,121.807,80H0Z" fill="#f22580"/>
                </svg>
            </div>
            <div class="header__member">
                <ul class="header__navigation header__navigation--login header__navigation--right">
                    <li class="active"><a href="index.php">ログイン</a></li>
                </ul>
            </div>
        </header>
    </div>
    <!-- result -->
    <div class="hero hero--skyline">
        <div class="hero__message">
            <span class="hero__message--id">#<?php echo $_GET["id"]?></span>
            <h1 class="hero__message--title">ご登録ありがとうポン</h1>
            <a class="hero__message--linkAnime" href="../member/index.php" >ログインする</a>
        </div>
    </div>
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