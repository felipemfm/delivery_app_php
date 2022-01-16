<?php
session_start();
if (!isset($_SESSION["userid"])) {
    header("location: ../mypage/");
    exit();
}
include_once __DIR__ . "/../includes/dbh.inc.php";
include_once __DIR__ . "/../includes/functions.inc.php";

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

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
<meta charset="utf-8">
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PON PONのスケジュール | PON PON</title>
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
                    <li class="active"><a href="../mypage/index.php">My PAGE</a></li>
                    <li><a href="../shopping/index.php">買物を依頼</a></li>
                    <li><a href="../delivery/index.php">宅配を依頼</a></li>
                </ul>
                <div class="header__flex">
                    <!-- user -->
                    <div class="header__user">
                        <a href="../mypage/index.php">
                            <img id="user_avatar" src="../images/avatar/<?php echo $_SESSION['avatar'] ?>.jpg" loding="lazy">
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
                    <li><a href="index.php#p-schedule">PONPONのスケジュール</a></li>
                    <li><a href="index.php#login">ログイン情報</a></li>
                    <li><a href="index.php#address">お届け先情報</a></li>
                    <li><a href="index.php#payment">お支払い情報</a></li>
                    <li><a href="index.php#ponpon">機器情報</a></li>
                    <li class="active"><a href="schedule.php#p-schedule-history">おつかい履歴</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="title">
        <h1>My PAGE</h1>
    </div>
    <!-- スケジュール登録済み -->
    <?php if (!empty($active_schedule)) : ?>
        <aside class="wrap wrap--grayfa wrap--schedule svg">
            <div class="svg__warp">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="svg__wave svg__wave--top">
                    <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="svg__wave svg__wave--bottom">
                    <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
                </svg>
            </div>
            <div class="inner">
                <h2 class="inner__title">PON PONのスケジュール</h2>
                <div class="flex schedule--flex">
                    <section class="map">
                        <div class="map__content">
                            <div id=<?php echo (!empty($active_schedule)) ? 'map' : '' ?> class="map__google"></div>
                        </div>
                    </section>
                    <section class="schedule">
                        <div class="head head--flex">
                            <h3 class="head__title head__title--pink">PON PONおつかいリスト</h3>
                            <span class="head__text">
                                <a href="../includes/clear-schedule.inc.php">リストクリア</a>
                            </span>
                            <span class="head__text">
                                <?php echo $date->format("Y/m/d") ?>
                            </span>
                        </div>
                        <ul class="listView">
                            <php $newdate="" ?>
                                <?php foreach ($active_schedule as $key => $element) : ?>
                                    <?php $deliverydate = new DateTime($element['createdAt']); ?>
                                    <!-- <?php if ($date->format("Y/m/d H:i") < $element["return_time"]->format("Y/m/d H:i")) : ?> -->
                                    <?php if ($newdate != $element["arrival_time"]->format("Y/m/d")) : $newdate = $element["arrival_time"]->format("Y/m/d"); ?>
                                        <li class="listView__list listView__list--date">
                                            <?php echo $newdate ?>
                                        </li>
                                    <?php endif; ?>
                                    <li class="listView__list">
                                        <p class="listView__store"><?php echo $element["store_name"] ?></p>
                                        <span class="listView__time">
                                            <?php echo $element["arrival_time"]->format("H:i") ?>に到着</span>
                                    </li>
                                    <?php if (!$element["reroute"]) : ?>
                                        <li class="listView__list listView__list--back">
                                            <span class="schedule__time"><?php echo $element["return_time"]->format("m/d H:i") ?>に帰宅</span>
                                        </li>
                                    <?php endif; ?>
                                    <!-- <?php endif; ?> -->
                                <?php endforeach; ?>
                        </ul>
                        <!-- <div class="schedule__result">
                            <a href="../mypage/schedule.php" class="schedule__link">別日の予定を確認</a>
                        </div> -->
                    </section>
                </div>
            </div>
        </aside>
        <!-- スケジュール未登録状態 -->
    <?php else : ?>
        <aside id="p-schedule" class="wrap wrap--grayfa wrap--schedule svg svg--notschedule">
            <div class="svg__warp">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="svg__wave svg__wave--top">
                    <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="svg__wave svg__wave--bottom">
                    <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
                </svg>
            </div>
            <div class="inner">
                <h2 class="inner__title schedule-not__title">PON PONのスケジュール</h2>
                <section class="schedule schedule-not">
                    <div class="schedule-not__button">
                        <a href="../shopping/index.php" class="schedule-not__button--shopping">
                            <img src="../images/ponpon-icon-shopping.png">
                        </a>
                        <a href="../delivery/index.php" class="schedule-not__button--delivery">
                            <img src="../images/ponpon-icon-delivery.png">
                        </a>
                    </div>
                    <div class="schedule-not__visual">
                        <div class="schedule-not__visual--house">
                            <img src="../images/ponpon-schedule-not.png">
                        </div>
                    </div>
                </section>
            </div>
        </aside>
    <?php endif; ?>
    <!-- main -->
    <?php if (!empty($schedule)) : ?>
        <main id="p-schedule-history" class="main">
            <article class="wrap mypage">
                <?php
                $prev_date = "";
                for ($i = 0; $i < count($schedule); $i++) : ?>
                    <?php $deliverydate = new DateTime($schedule[$i]["createdAt"]);
                    if ($date->format("Y/m/d H:i") > $schedule[$i]["return_time"]->format("Y/m/d H:i")) : ?>
                        <?php if ($prev_date !== $deliverydate->format("Y/m")) : $prev_date = $deliverydate->format("Y/m"); ?>
                            <div class="inner mypage__schedule">
                                <!-- order -->
                                <section>
                                    <div class="head head--flex head--sticky">
                                        <button class='head__title head__title--button head__title--active' type='buton'>
                                            <?php echo $prev_date ?>
                                        </button>
                                    </div>
                                </section>
                            </div>
                        <?php endif; ?>
                        <div class="inner mypage__schedule">
                            <!-- order -->
                            <!-- <section>
                                <div class="head head--flex head--sticky">
                                    <?php
                                    if ($prev_date !== $deliverydate->format("Y/m")) {
                                        $prev_date = $deliverydate->format("Y/m");
                                        echo "<button class='head__title head__title--button head__title--active' type='buton'>{$prev_date}</button>";
                                    }
                                    ?>
                                </div>
                            </section> -->
                            <!-- schedule -->
                            <div>
                                <section class="flex">
                                    <div class="head head--flex">
                                        <h2 class="head__title">
                                            <?php echo $deliverydate->format("m/d H:m"); ?>
                                        </h2>
                                    </div>
                                    <div class="schedule">
                                        <ul class="listView">
                                            <li class="listView__list">
                                                <p class="listView__store"><?php echo $schedule[$i]["store_name"] ?></p>
                                                <span class="listView__time">
                                                    <?php
                                                    echo $schedule[$i]['arrival_time']->format("H:i");
                                                    ?>に到着
                                                </span>
                                            </li>
                                            <?php while ($schedule[$i]['reroute']) : ?>
                                                <?php $i++ ?>
                                                <li class="listView__list">
                                                    <p class="listView__store"><?php echo $schedule[$i]["store_name"] ?></p>
                                                    <span class="listView__time">
                                                        <?php
                                                        echo $schedule[$i]['arrival_time']->format("H:i");
                                                        ?>に到着
                                                    </span>
                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                        <div class="schedule__result">
                                            <span class="schedule__time">
                                                <?php
                                                echo $schedule[$i]['return_time']->format("m/d H:i");
                                                ?>
                                                おつかい完了
                                            </span>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </article>
        </main>
    <?php endif; ?>
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
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: <?php echo $_SESSION['lat'] ?>,
                    lng: <?php echo $_SESSION['long'] ?>
                },
                disableDefaultUI: true,
                zoomControl: true,
                zoom: 8,
            });
            const deliveryPath = [
                <?php
                foreach ($active_schedule as $key => $element) {
                    $deliverydate = new DateTime($element['createdAt']);
                    echo "[{ lat:" . $element["store_lat"] . ", lng:" . $element["store_long"] . "}, '" . $element["store_name"] . "'],";
                }
                echo "[{ lat:" . $_SESSION["lat"] . ", lng:" . $_SESSION["long"] . "}, '" . $_SESSION["username"] . "'],";
                ?>
            ];
            const infoWindow = new google.maps.InfoWindow();
            deliveryPath.forEach(([position, title], i) => {
                const marker = new google.maps.Marker({
                    position,
                    map,
                    title: `${title}`,
                    label: deliveryPath.length - 1 != i ? `${i + 1}` : "🏠",
                    optimized: false,
                });

                // Add a click listener for each marker, and set up the info window.
                marker.addListener("click", () => {
                    infoWindow.close();
                    infoWindow.setContent(marker.getTitle());
                    infoWindow.open(marker.getMap(), marker);
                });

            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_ENV['GOOGLE_KEY_API'] ?>&callback=initMap&v=weekly" async></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
    <script type="text/javascript" src="../js/common.js"></script>
</body>

</html>