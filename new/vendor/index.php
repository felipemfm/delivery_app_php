<?php
session_start();
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PON PON 空飛ぶMyパートナー</title>
<meta name="description" content="買物も、配送も全てお任せ!一家に一台「完全自律型ドローン」が個人物流時代の幕を開ける。">
<!-- css -->
<link rel="stylesheet" href="css/style.css" media="screen">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
<!-- favicon -->
<link rel="icon" href="images/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
<style>
  .iframe-wrapper {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
}

.iframe-wrapper iframe {
  position: absolute;
  top: -64px;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
</head>

<body class="preload">
    <!-- fix area -->
    <div id="fixContents" class="fixContents--clear">
        <!-- header -->
        <header class="header">
            <div class="logo">
                <p class="logo__text"><a href="index.php">PON PON</a></p>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 254.264 80">
                    <path id="logo__bg" class="logo__bg" d="M0,0H254.264S221.724,3,200,40.621,143.9,80,121.807,80H0Z" fill="#f22580" />
                </svg>
            </div>
            <div class="header__member">
                <?php if (!isset($_SESSION["userid"])) : ?>
                    <ul class="header__navigation header__navigation--login header__navigation--right">
                        <li><a href="member/index.php">ログイン</a></li>
                    </ul>
                <?php else : ?>
                    <ul class="header__navigation header__navigation--login header__navigation--right">
                        <li><a href="mypage">MyPage</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </header>
    </div>
    <div class="iframe-wrapper">
      <iframe src="https://xd.adobe.com/embed/c0b6a220-e8b5-4e6c-a50e-2fcb2966b4a4-95e5/" frameborder="0" allowfullscreen></iframe>
    </div>
    <!-- main -->
    <main class="main">
    </main>
    <!-- footer -->
    <footer class="footer">
        <small>Copyright <i class="far fa-copyright"></i> 2021-2022 PON PON All Rights Reserved.</small>
    </footer>
    <!-- menu button -->
    <?php if (isset($_SESSION["userid"])) : ?>
    <div class="buttonMenu">
        <input type="checkbox" href="#" name="menu__open" id="menu__open" class="buttonMenu__open">
        <label class="buttonMenu__button" for="menu__open">
            <span class="buttonMenu__line buttonMenu__line--1"></span>
            <span class="buttonMenu__line buttonMenu__line--2"></span>
            <span class="buttonMenu__line buttonMenu__line--3"></span>
        </label>
        <a href="delivery/index.php" class="buttonMenu__item"><img src="images/ponpon-menubutton-delivery.png"></a>
        <a href="shopping/index.php" class="buttonMenu__item"><img src="images/ponpon-menubutton-shopping.png"></a>
        <!-- 未登録の場合 -->
        <!-- <a href="../mypage/index.php" class="buttonMenu__item"><img src="../images/ponpon-menubutton-default.png"></a> -->
        <!-- PONPON登録済みの場合 -->
        <a href="mypage/index.php" class="buttonMenu__item"><img src="images/ponpon-menubutton-default.png"></a>
        <a id="pageTop" href="#" class="buttonMenu__item"><i class="fas fa-chevron-up"></i></a>
        <a href="includes/logout.inc.php" class="buttonMenu__item"><i class="fas fa-unlock-alt"></i></a>
    </div>
    <?php endif; ?>
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
</body>

</html>