<?php
include_once __DIR__ . "/../includes/dbh.inc.php";
include_once __DIR__ . "/../includes/functions.inc.php";
session_start();
if (isset($_POST) && isset($_SESSION["userid"])) {

    $_SESSION["cart"] = array();
    $order_info = "";
    $total = 0;
    $items = 0;
    foreach ($_POST as $key => $value) {
        if ($value != 0) {
            $order = explode("_", $key); //$order[0] => item code $order[1] => item name $order[2] => item price $order[3] => item quantity
            array_push($order, $value);
            array_push($_SESSION["cart"], $order);
            $total += ($order[2] * $value);
            $item++;
        }
    }

    foreach ($_SESSION["cart"] as $key => $element) {
        if (count($_SESSION["cart"]) - 1 === $key)
            $order_info .= "{$element[0]}_{$element[1]}_{$element[2]}_{$element[3]}";
        else
            $order_info .= "{$element[0]}_{$element[1]}_{$element[2]}_{$element[3]}/";
    }
} else {
    header("location: ../shopping");
    exit();
}
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$category = getCategoryNavBar($conn);
date_default_timezone_set('Asia/Tokyo');
$date = new DateTime("08:00:00");

// $date = new DateTime();

$schedule = array();
$active_schedule = array();
$schedule = getDeliverySchedule($conn, $_SESSION["userid"], $_SESSION["lat"], $_SESSION["long"]);
if (!empty($schedule)) {
    foreach ($schedule as $element) {
        if ($date->format("Y/m/d H:i") < $element["return_time"]->format("Y/m/d H:i"))
            array_push($active_schedule, $element);
    }
}
?>
<!DOCTYPE html>
<html>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>注文確認画面 買物を依頼 | PON PON</title>
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
            <div class="inner inner--tPd0 flex shopping--flexReverse">
                <!-- order -->
                <aside class="flex__side flex__side--sticky order">
                    <div class="head head--flex">
                        <h2 class="head__title">注文者情報</h2>
                    </div>
                    <section class="order-card">
                    <?php if (count($_SESSION["cart"]) == 0) : ?>
                        <dl class="order-card__user">
                            <dt><i class="fas fa-user-circle"></i>注文者</dt>
                            <dd>
                                <span><?php echo $_SESSION["userid"] ?></span>
                                <span><?php echo ("〒{$_SESSION["postal_code"]} {$_SESSION["postal_info"]}") ?></span>
                            </dd>
                            <dt><i class="fas fa-credit-card"></i>決済方法</dt>
                            <dd><span>TANI MASARU払い</span></dd>
                        </dl>
                        <ul class="order-card__total">
                          <li class="order-card__total--cart"><i class="fas fa-shopping-cart "></i><?php echo $item ?><span>&nbsp;品</span></li>
                          <li class="order-card__total--price"><i class="fas fa-yen-sign"></i><?php echo $total ?><span>（税込）</span></li>
                          <li class="order-card__total--button order-card__total--buttonOut">
                            <button type="button">注文する</button>
                          </li>
                    <?php else : ?>
                      <form action="../includes/shopping-order.inc.php" method="post">
                      <dl class="order-card__user">
                            <dt><i class="fas fa-user-circle"></i>注文者</dt>
                            <dd>
                                <span><?php echo $_SESSION["userid"] ?></span>
                                <span><?php echo ("〒{$_SESSION["postal_code"]} {$_SESSION["postal_info"]}") ?></span>
                            </dd>
                            <dt><i class="fas fa-credit-card"></i>決済方法</dt>
                            <dd><span>TANI MASARU払い</span></dd>
                            <dt><i class="fas fa-clock"></i>出発時間</dt>
                            <dd>
                              <ul class="checkout__radio">
                                  <li>
                                      <input class="radio__check" type="radio" id="time01" name="check" value="0" onclick="formSwitch()" checked>
                                      <label for="time01">今すぐ出発</label>
                                  </li>
                                  <li>
                                      <input class="radio__check" type="radio" id="time02" name="check" value="1" onclick="formSwitch()">
                                      <label for="time02">時間指定する</label>
                                  </li>
                                  <span id="radioSelect" class="checkout__radio--time">
                                      <input type="time" name="time" value="09:00" min="09:00" max="21:00">
                                  </span>
                                </ul>
                            </dd>
                        </dl>
                        <ul class="order-card__total">
                          <li class="order-card__total--cart"><i class="fas fa-shopping-cart "></i><?php echo $item ?><span>&nbsp;品</span></li>
                          <li class="order-card__total--price"><i class="fas fa-yen-sign"></i><?php echo $total ?><span>（税込）</span></li>
                          <li class="order-card__total--button">
                                  <button type="submit" name="submit">注文する</button>
                                  <input type="hidden" name="total" value="<?php echo $total ?>">
                                  <input type="hidden" name="order_info" value="<?php echo $order_info ?>">
                              </form>
                          </li>
                        </ul>
                      </form>
                    <?php endif; ?>
                    </section>
                </aside>
                <!-- menu -->
                <article class="flex__main menu">
                    <?php if (count($_SESSION["cart"]) == 0) : ?>
                        <div class="head head--flex head--sticky">
                            <h2 class="head__title">カートに商品が入っていません。</h2>
                            <form action="../shopping/menu.php" method="POST">
                                <button class="head__link head__link--accent" type="submit" name="resubmit">
                                    <i class="fas fa-list-ul"></i>メニューへ戻る
                                </button>
                            </form>
                        </div>
                        <div class="checkout">
                        <?php else : ?>
                            <div class="head head--flex head--sticky">
                                <h2 class="head__title">注文内容</h2>
                                <!-- <button class="head__link head__link--accent" onclick="history.back();">
                                    <i class="fas fa-list-ul"></i>メニューへ戻る
                                </button> -->
                                <form action="../shopping/menu.php" method="POST">
                                    <button class="head__link head__link--accent" type="submit" name="resubmit">
                                        <i class="fas fa-list-ul"></i>メニューへ戻る
                                    </button>
                                </form>
                            </div>

                            <!-- store -->
                            <section class="checkout__store">
                                <div class="head head--flex">
                                    <h3 class="head__title">注文店舗</h3>
                                </div>
                                <div class="infoBg">
                                    <div class="infoBg__bgimg">
                                        <img src=<?php echo "../images/{$_SESSION['store']['id']}.jpg" ?> loading="lazy">
                                    </div>
                                    <div class="infoBg__box">
                                        <p class="infoBg__title"><?php echo $_SESSION['store']['name'] ?></p>
                                        <div class="flex">
                                            <div class="infoBg__icon">
                                                <img src=<?php echo "../images/{$_SESSION['store']['id']}.jpg" ?> loading="lazy">
                                            </div>
                                            <ul class="infoBg__info">
                                                <li><i class="fas fa-map-marker-alt"></i>所在地:<span><?php echo $_SESSION['store']['address'] ?></span></li>
                                                <li><i class="fas fa-phone"></i>電話番号:<span><?php echo $_SESSION['store']['phonenumber'] ?></span></li>
                                                <li><i class="fas fa-clock"></i>注文可能時間:<span>9:00-21:00</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- item -->
                            <section class="checkout__item">
                                <div class="head head--flex">
                                    <h3 class="head__title">注文商品</h3>
                                </div>
                                <ul class="flex menu--flex">
                                    <?php foreach ($_SESSION["cart"] as $order) : ?>
                                        <li class="list">
                                            <div class="list__img">
                                                <img src=<?php echo "../images/{$order[0]}.jpg" ?> loading="lazy">
                                            </div>
                                            <div class="list__info">
                                                <h3 class="list__title"><?php echo $order[1] ?></h3>
                                                <p class="list__price"><?php echo $order[2] * $order[3] ?><span class="list__price--small">（税込）</span></p>
                                            </div>
                                            <div class="list__quantity">
                                                <p><?php echo $order[3] ?></p>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                    <!-- menu end -->
                                </ul>
                            </section>
                        <?php endif; ?>
                        <!-- address -->
                        <section class="checkout__address">
                            <div class="head head--flex">
                                <h3 class="head__title">お届け先</h3>
                                <!-- <form action="../mypage/index.html">
                                    <button href="#" class="head__text"><i class="fas fa-pen"></i>編集</button>
                                </form> -->
                            </div>
                            <div class="checkout__user flex">
                                <div class="cardBg">
                                    <div class="cardBg__img">
                                        <img src="../images/avatar/<?php echo $_SESSION["avatar"] ?>.jpg" loading="lazy">
                                    </div>
                                    <div class="cardBg__box">
                                        <div class="cardBg__box--icon">
                                            <img src="../images/avatar/<?php echo $_SESSION["avatar"] ?>.jpg" loading="lazy">
                                        </div>
                                        <ul class="cardBg__info">
                                            <li class="cardBg__name"><?php echo $_SESSION["username"] ?></li>
                                            <li class="cardBg__map">〒<?php echo $_SESSION["postal_code"] . $_SESSION["postal_info"] ?></li>
                                            <li class="cardBg__tel">03-5321-7618</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- payment -->
                        <section class="checkout__payment">
                            <div class="head head--flex">
                                <h3 class="head__title">お支払い方法</h3>
                                <!-- <form action="../mypage/index.html">
                                    <button href="#" class="head__text"><i class="fas fa-pen"></i>編集</button>
                                </form> -->
                            </div>
                            <ul class="checkout__radio">
                                <li>
                                    <input type="radio" id="01" name="pay" checked="checked">
                                    <label for="01">TANI MASARU払い<span>【太っ腹キャンペーン中!】</span></label>
                                </li>
                                <li class="checkout__radio--disabled">
                                    <input type="radio" id="02" name="pay" disabled>
                                    <label for="02">クレジットカード払い</label>
                                </li>
                                <li class="checkout__radio--disabled">
                                    <input type="radio" id="03" name="pay" disabled>
                                    <label for="03">現金払い</label>
                                </li>
                            </ul>
                        </section>
                        <!-- order time -->
                        <br>
                        <?php if (!empty($active_schedule)) : ?>
                            <section class="schedule checkout__schedule">
                                <div class="head head--flex">
                                    <h3 class="head__title head__title--pink">PON PONおつかいリスト</h3>
                                    <span class="head__text">
                                        <?php echo $date->format("Y/m/d") ?>
                                    </span>
                                </div>
                                <ul class="listView">
                                    <php $newdate="" ?>
                                        <?php foreach ($active_schedule as $key => $element) : ?>
                                            <?php $deliverydate = new DateTime($element['createdAt']); ?>
                                            <!-- <?php if ($date->format("Y/m/d H:i") < $element["return_time"]->format("Y/m/d H:i")) : ?> -->
                                            <?php if ($newdate != $deliverydate->format("Y/m/d")) : $newdate = $deliverydate->format("Y/m/d"); ?>
                                                <li class="listView__list listView__list--date">
                                                    <?php echo $newdate ?>
                                                </li>
                                            <?php endif; ?>
                                            <li class="listView__list">
                                                <p class="listView__store"><?php echo $element["store_name"] ?></p>
                                                <span class="listView__time">
                                                    <?php echo  $element["arrival_time"]->format("H:i") ?>に到着</span>
                                            </li>
                                            <?php if (!$element["reroute"]) : ?>
                                                <li class="listView__list listView__list--back">
                                                    <span class="schedule__time"><?php echo $element["return_time"]->format("m/d H:i") ?>に帰宅</span>
                                                </li>
                                            <?php endif; ?>
                                            <!-- <?php endif; ?> -->
                                        <?php endforeach; ?>
                                </ul>
                                <div class="schedule__result">
                                    <a href="../mypage/schedule.php" class="schedule__link">別日の予定を確認</a>
                                    <!-- <span class="schedule__time"><?php echo $returntime ?>分後に到着</span> -->
                                </div>
                            </section>
                        <?php endif; ?>

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