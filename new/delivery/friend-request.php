<?php
session_start();
if (!isset($_SESSION["userid"]) && isset($_POST["submit"])) {
    header("location: ../index.php");
    exit();
}
$_SESSION["friend"]["id"] = $_POST["friend_id"];
$_SESSION["friend"]["name"] = $_POST["friend_name"];
$_SESSION["friend"]["avatar"] = $_POST["friend_avatar"];
$_SESSION["friend"]["lat"] = $_POST["friend_lat"];
$_SESSION["friend"]["long"] = $_POST["friend_long"];
date_default_timezone_set('Asia/Tokyo');
// $date = new DateTime();
$date = new DateTime("08:00:00");
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>宅配スケジュールの登録 宅配を依頼 | PON PON</title>
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
    <div id="fixContents">
        <!-- header -->
        <header class="header">
            <div class="logo">
                <p class="logo__text"><a href="../index.php">PON PON</a></p>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 254.264 80">
                    <path id="logo__bg" class="logo__bg" d="M0,0H254.264S221.724,3,200,40.621,143.9,80,121.807,80H0Z" fill="#f22580" />
                </svg>
            </div>
            <div class="header__member">
                <ul class="header__navigation">
                    <li><a href="../mypage/index.php">My PAGE</a></li>
                    <li><a href="../shopping/index.php">買物を依頼</a></li>
                    <li class="active"><a href="index.php">宅配を依頼</a></li>
                </ul>
                <div class="header__flex">
                    <!-- search -->
                    <div class="open-btn"><i class="fas fa-search"></i></div>
                    <div id="search-wrap">
                        <div class="search-area">
                            <form role="search" action="../delivery/search-result.php" method="post">
                                <input type="text" name="inquiry" id="search-text" placeholder="お名前、メールアドレス、電話番号など">
                                <button id="searchsubmit" value="submit" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                            <div class="close-btn"><span></span><span></span></div>
                        </div>
                    </div>
                    <!-- user -->
                    <div class="header__user">
                        <a href="../mypage/index.php">
                            <img src="<?php echo "../images/avatar/{$_SESSION['avatar']}.jpg"?>" loding="lazy">
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <!-- navigation -->
        <nav class="navigation navigation--fix">
            <div class="navigation__horizontal">
                <ul>
                    <li><a href="index.php">TOP</a></li>
                    <li class="active"><a href="friend-list.php">ともだちリスト</a></li>
                    <li><a href="../mypage/schedule.php">おつかい履歴</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- title -->
    <div class="title">
        <h1>宅配を依頼</h1>
    </div>
    <!-- main -->
    <main class="main">
        <!-- friend send -->
        <article class="wrap wrap--friend wrap--grayfa svg">
            <div class="svg__warp">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="svg__wave svg__wave--top">
                    <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="svg__wave svg__wave--bottom">
                    <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
                </svg>
            </div>
            <div class="inner inner--middle">
                <section class="friend friend--send">
                    <div class="cardBg">
                        <div class="cardBg__img">
                            <img src="../images/avatar/<?php echo $_SESSION['avatar'] ?>.jpg" loding="lazy">
                        </div>
                        <div class="cardBg__box">
                            <div class="cardBg__box--icon">
                                <img src="../images/avatar/<?php echo $_SESSION['avatar'] ?>.jpg" loding="lazy">
                            </div>
                            <ul class="cardBg__info">
                                <li class="cardBg__name"><?php echo $_SESSION["username"] ?></li>
                                <li class="cardBg__id">#<?php echo $_SESSION["userid"] ?></li>
                                <li class="cardBg__button cardBg__button--request">
                                    <form action="friend-result.php">
                                        <button type="button" name="friend--add">送る</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- animation -->
                    <div class="animeArrow">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="cardBg">
                        <div class="cardBg__img">
                            <img src="../images/avatar/<?php echo $_SESSION["friend"]["avatar"] ?>.jpg" loading="lazy">
                        </div>
                        <div class="cardBg__box">
                            <div class="cardBg__box--icon">
                                <img src="../images/avatar/<?php echo $_SESSION["friend"]["avatar"] ?>.jpg" loading="lazy">
                            </div>
                            <ul class="cardBg__info">
                                <li class="cardBg__name"><?php echo $_SESSION["friend"]["name"] ?></li>
                                <li class="cardBg__id">#<?php echo $_SESSION["friend"]["id"] ?></li>
                                <li class="cardBg__button cardBg__button--request">
                                    <form action="friend-result.php">
                                        <button type="button" name="friend--add">受け取る</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
        </article>
    </main>
    <!-- request -->
    <aside class="warp">
        <section class="friend friend--request">
            <div class="form">
                <h2 class="form__title">出発希望日時を入力</h2>
                <!-- <form action="../delivery/friend-result.php" method="POST"> -->
                <form action="../includes/friend-delivery.inc.php" method="POST">
                    <dl class="form-inputGroup">
                        <dt><label>出発予定日</label></dt>
                        <dd>
                            <input type="date" name="date" value="<?php echo $date->format("Y-m-d")?>">
                        </dd>
                        <dt><label>出発希望時間</label></dt>
                        <dd>
                            <input type="time" name="time" value="<?php echo $date->format("H:i")?>">
                        </dd>
                    </dl>
                    <div class="form-buttonGroup">
                        <button type="button" class="form-buttonGroup__button form-buttonGroup__button--out" onClick="history.back(); return false;">やめる</button>
                        <button name="submit" type="submit" class="form-buttonGroup__button form-buttonGroup__button--in">宅配を依頼</button>
                    </div>
                </form>
            </div>
        </section>
    </aside>
    <!-- footer -->
    <footer class="footer">
        <small>Copyright <i class="far fa-copyright"></i> 2021-2022 PON PON All Rights Reserved.</small>
    </footer>
    <!-- buttonMenu -->
    <div class="buttonMenu">
        <input type="checkbox" href="#" name="menu__open" id="menu__open" class="buttonMenu__open">
        <label class="buttonMenu__button" for="menu__open">
            <span class="buttonMenu__line buttonMenu__line--1"></span>
            <span class="buttonMenu__line buttonMenu__line--2"></span>
            <span class="buttonMenu__line buttonMenu__line--3"></span>
        </label>
        <a href="../delivery/index.php" class="buttonMenu__item"><img src="../images/ponpon-menubutton-delivery.png"></a>
        <a href="../shopping/index.php" class="buttonMenu__item"><img src="../images/ponpon-menubutton-shopping.png"></a>
        <!-- 未登録の場合 -->
        <!-- <a href="../mypage/index.php" class="buttonMenu__item"><img src="../images/ponpon-menubutton-default.png"></a> -->
        <!-- PONPON登録済みの場合 -->
        <a href="../mypage/index.php" class="buttonMenu__item"><img src="../images/ponpon-menubutton-default.png"></a>
        <a id="pageTop" href="#" class="buttonMenu__item"><i class="fas fa-chevron-up"></i></a>
        <a href="../includes/logout.inc.php" class="buttonMenu__item"><i class="fas fa-unlock-alt"></i></a>
    </div>
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
    <script type="text/javascript" src="../js/common.js"></script>
</body>
</html>