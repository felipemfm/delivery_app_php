<?php
session_start();
if (!isset($_SESSION["userid"]) && (!isset($_POST["submit"]) || !isset($_POST["resubmit"]))) {
    header("location: ../shopping/");
    exit();
} else {
    if (isset($_POST["submit"])) {
        $_SESSION["store"] = array();
        $_SESSION["store"]["id"] = $_POST["id"];
        $_SESSION["store"]["code"] = $_POST["code"];
        $_SESSION["store"]["name"] = $_POST["name"];
        $_SESSION["store"]["address"] = $_POST["address"];
        $_SESSION["store"]["store_name"] = $_POST["name"];
        $_SESSION["store"]["phonenumber"] = $_POST["phonenumber"];
        $_SESSION["store"]["lat"] = $_POST["lat"];
        $_SESSION["store"]["long"] = $_POST["long"];
    }
}
include_once __DIR__ . "/../includes/dbh.inc.php";
include_once __DIR__ . "/../includes/functions.inc.php";

$category = getCategoryNavBar($conn);
$menu = getMenu($conn, $_SESSION["store"]["id"]);
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>メニュー 買物を依頼 | PON PON</title>
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
                    <li class="active"><a href="index.php">買物を依頼</a></li>
                    <li><a href="../delivery/index.php">宅配を依頼</a></li>
                </ul>
                <div class="header__flex">
                    <!-- search -->
                    <div class="open-btn"><i class="fas fa-search"></i></div>
                    <div id="search-wrap">
                        <div class="search-area">
                            <form role="search" action="../shopping/search-result.php" method="POST">
                                <input type="text" name="inquiry" id="search-text" placeholder="店舗名、料理名、都道府県名など">
                                <button id="searchsubmit" value="submit" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                            <div class="close-btn"><span></span><span></span></div>
                        </div>
                    </div>
                    <!-- user -->
                    <div class="header__user">
                        <a href="../mypage/index.php">
                            <img src="../images/avatar/<?php echo $_SESSION['avatar'] ?>.jpg" loding="lazy">
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <!-- navigation -->
        <nav class="navigation navigation--fix">
            <div class="navigation__horizontal">
                <ul>
                    <li><button type="button" onclick="location.href='./index.php'">TOP</button></li>
                    <?php foreach ($category as $element) : ?>
                        <?php echo ($_SESSION['store']['id'] == $element['id']) ? "<li class='active'>" : "<li>" ?>
                        <form action='../shopping/menu-store.php' method='post'>
                            <button type='submit' name='submit'><?php echo $element['name'] ?></button>
                            <input type='hidden' name='id' value='<?php echo $element['id'] ?>'>
                        </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </div>
    <!-- title -->
    <div class="title">
        <h1>買物を依頼</h1>
    </div>
    <!-- main -->
    <main class="main">
        <div class="wrap wrap--shopping">
            <div class="inner inner--tPd0 flex shopping--flex">
                <!-- order -->
                <aside class="flex__side flex__side--sticky order">
                    <div class="head head--flex">
                        <h2 class="head__title"><?php echo $_SESSION["store"]["name"] ?></h2>
                    </div>
                    <section class="card">
                        <div class="card__img">
                            <img src="../images/<?php echo $_SESSION["store"]["id"] ?>.jpg" loading="lazy">
                        </div>
                        <ul class="card__list">
                            <li><i class="fas fa-map-marker-alt"></i>所在地<span><?php echo $_SESSION["store"]["address"] ?></span></li>
                            <li><i class="fas fa-phone"></i>電話番号<span><?php echo $_SESSION["store"]["phonenumber"] ?></span></li>
                            <li><i class="fas fa-clock"></i>注文可能時間<span>9:00-21:00</span></li>
                        </ul>
                    </section>
                </aside>
                <!-- menu -->
                <article class="flex__main menu">
                    <form action="./menu-cart.php" method="post">
                        <div class="head head--flex head--sticky">
                            <h2 class="head__title">メニュー</h2>
                            <button class="head__link head__link--ponpon" type="submit" class="head-base"><i class="fas fa-shopping-cart"></i>カートに追加する</button>
                        </div>
                        <ul class="flex menu--flex">
                            <?php foreach ($menu as $element) : ?>
                                <li class='list'>
                                    <div class='list__img'>
                                        <img src='../images/<?php echo $element['code'] ?>.jpg' loading='lazy'>
                                    </div>
                                    <div class='list__info'>
                                        <h3 class='list__title'><?php echo $element['name'] ?></h3>
                                        <p class='list__price'><?php echo $element['price'] ?>円<span class='list__price--small'>（税込）</span></p>
                                    </div>
                                    <div class='list__quantity'>
                                        <select name='<?php echo $element['code'] . "_" . $element['name'] . "_" . $element['price'] ?>'>
                                            <option value='0' selected>0</option>
                                            <option value='1'>1</option>
                                            <option value='2'>2</option>
                                            <option value='3'>3</option>
                                            <option value='4'>4</option>
                                            <option value='5'>5</option>
                                        </select>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <!-- menu end -->
                        </ul>
                    </form>
                </article>
            </div>
        </div>
    </main>
    <!-- footer -->
    <footer class="footer">
        <small>Copyright <i class="far fa-copyright"></i> 2021-2022 PON PON All Rights Reserved.</small>
    </footer>
    <!-- menu button -->
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