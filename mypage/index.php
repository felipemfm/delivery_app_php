<?php
session_start();
if (!isset($_SESSION["userid"])) {
  header("location: ../");
  exit;
}
include_once __DIR__ . "/../includes/dbh.inc.php";
include_once __DIR__ . "/../includes/functions.inc.php";

if (isset($_SESSION["error"])) {
  if ($_SESSION["error"] == "username")
    echo '<script type="text/javascript">alert("無効なユーザー名");</script>';
  if ($_SESSION["error"] == "email")
    echo '<script type="text/javascript">alert("無効なメールアドレス");</script>';
  if ($_SESSION["error"] == "postal")
    echo '<script type="text/javascript">alert("無効な郵便番号");</script>';
  unset($_SESSION["error"]);
}

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

date_default_timezone_set('Asia/Tokyo');
// $date = new DateTime("08:00:00");
$date = new DateTime();

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
<title>マイページ | PON PON</title>
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
          <li class="active"><a href="index.php">TOP</a></li>
          <li><a href="#p-schedule">PONPONのスケジュール</a></li>
          <li><a href="#login">ログイン情報</a></li>
          <li><a href="#address">お届け先情報</a></li>
          <li><a href="#payment">お支払い情報</a></li>
          <li><a href="#ponpon">機器情報</a></li>
          <li><a href="../mypage/schedule.php#p-schedule-history">おつかい履歴</a></li>
        </ul>
      </div>
    </nav>
  </div>
  <!-- PONPON登録済みの状態 -->
  <div class="hero hero--mypage">
    <div class="hero__mypage">
      <h1 class="hero__mypage--userName"><span>#<?php echo $_SESSION['userid'] ?></span>MY PAGE</h1>
      <div class="hero__mypage--ponpon changeImageItems">
        <img src="../images/ponpon-right.png">
        <img src="../images/ponpon-left.png">
      </div>
    </div>
  </div>
  <!-- スケジュール登録済み -->
  <?php if (!empty($active_schedule)) : ?>
    <aside class="wrap wrap--grayfa wrap--schedule svg" id="p-schedule">
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
              <div id=<?php echo (!empty($schedule)) ? 'map' : '' ?> class="map__google"></div>
            </div>
          </section>
          <section class="schedule">
            <div class="head head--flex">
              <h3 class="head__title head__title--pink">PON PONおつかいリスト</h3>
            </div>
            <ul class="listView">
              <php $newdate="" ;?>
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
                      <?php echo  $element["arrival_time"]->format("H:i") ?> 到着</span>
                  </li>
                  <?php if (!$element["reroute"]) : ?>
                    <li class="listView__list listView__list--back">
                      <span class="schedule__time"><?php echo $element["return_time"]->format("H:i") ?> 自宅到着</span>
                    </li>
                  <?php endif; ?>
                  <!-- <?php endif; ?> -->
                <?php endforeach; ?>
            </ul>
            <div class="schedule__result">
              <a href="../mypage/schedule.php" class="schedule__link">別日の予定を確認</a>
              <a href="../includes/clear-schedule.inc.php" class="schedule__link schedule__link--out ">予定キャンセル</a>
              <!-- <span class="schedule__time"><?php echo $returntime ?>分後 到着</span> -->
            </div>
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
  <main class="main">
    <article class="wrap mypage">
      <div class="inner">
        <!-- login -->
        <section id="login" class="flex">
          <div class="head head--flex">
            <h2 class="head__title">ログイン情報</h2>
          </div>
          <div class="form">
            <form action="../includes/profile-edit.inc.php" method="POST" enctype="multipart/form-data">
              <div class="form__icon">
                <div class="form__icon__box">
                  <img id="preview" class="form__preview" src="../images/avatar/<?php echo $_SESSION["avatar"] ?>.jpg">
                  <label class="form__input">
                    <input type="file" name="fname" accept='image/*' onchange="previewImage(this);">
                  </label>
                </div>
                <p class="form__iconname">#<?php echo $_SESSION["userid"] ?></p>
              </div>
              <dl class="form-inputGroup">
                <dt><label>ユーザー名</label></dt>
                <dd><input type="text" name="user-name" value="<?php echo $_SESSION['username'] ?>" autocomplete="name"></dd>
                <dt><label>メールアドレス</label></dt>
                <dd><input type="email" name="email" value="<?php echo $_SESSION['email'] ?>" placeholder="hal@ponpon.co.jp" autocomplete="email"></dd>
                <dt><label>パスワード</label></dt>
                <dd>
                  <input type="password" name="password" value="" placeholder="半角英数字" autocomplete="new-password">
                </dd>
              </dl>
              <div class="form-buttonGroup">
                <button class="form-buttonGroup__button form-buttonGroup__button--in" name="submit" type="submit">変更する</button>
              </div>
            </form>
          </div>
        </section>
        <!-- address -->
        <section id="address" class="flex">
          <div class="head flex">
            <h2 class="head__title">お届け先情報</h2>
          </div>
          <div class="form">
            <form action="../includes/profile-edit.inc.php" method="POST">
              <dl class="form-inputGroup">
                <dt><label>郵便番号</label></dt>
                <dd><input type="text" name="postal-code" value="<?php echo $_SESSION['postal_code'] ?>"></dd>
                <dt><label>住所</label></dt>
                <dd>
                  <input type="text" name="address-1" value="<?php echo $_SESSION['postal_info'] ?>" placeholder="東京都新宿区西新宿" disabled>
                  <input type="text" name="address-2" value="" placeholder="１丁目７-３ 総合校舎コクーンタワ" disabled>
                </dd>
                <dt><label>お届け先名</label></dt>
                <dd><input type="text" name="name" value="<?php echo $_SESSION['username'] ?>" placeholder="お届け先名を入力してください。" disabled></dd>
              </dl>
              <div class="form-buttonGroup">
                <button class="form-buttonGroup__button form-buttonGroup__button--in" name="submit" type="submit">変更する</button>
              </div>
            </form>
          </div>
        </section>
        <!-- payment -->
        <section id="payment" class="flex">
          <div class="head flex">
            <h2 class="head__title">お支払い情報</h2>
          </div>
          <div class="form">
            <form action="../shopping/index.php">
              <dl class="form-inputGroup">
                <dt><label>クレジットカード番号</label></dt>
                <dd><input type="text" name="Credit-Card-Number" placeholder="1111 2222 3333 4444" disabled></dd>
                <dt><label>セキュリティコード</label></dt>
                <dd class="form-inputGroup__2col"><input type="text" name="Security-Code" placeholder="123" disabled></dd>
              </dl>
            </form>
          </div>
        </section>
        <!-- ponpon -->
        <section id="ponpon" class="flex">
          <div class="head flex">
            <h2 class="head__title">機器情報</h2>
          </div>
          <div class="form">
            <form action="../shopping/index.php">
              <dl class="form-inputGroup">
                <dt><label>PONPON シリアルNo.</label></dt>
                <dd><input type="text" name="ponpon-number" placeholder="シリアルNo.(8080 8080 8080 8080) " value="8080 8080 8080 8080" autocomplete="off" disabled></dd>
                <dt><label>PONPON HOSUE シリアルNo.</label></dt>
                <dd><input type="text" name="ponpon-house-number" placeholder="シリアルNo.(8080 8080 8080 8080) " value="8080 8080 8080 8080" autocomplete="off" disabled></dd>
              </dl>
            </form>
          </div>
        </section>
      </div>
    </article>
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
      const centerControlDiv = document.createElement("div");
      const infoWindow = new google.maps.InfoWindow();
      deliveryPath.forEach(([position, title], i) => {
        const marker = new google.maps.Marker({
          position,
          map,
          title: `${title}`,
          label: deliveryPath.length - 1 != i ? `${i + 1}` : "🏠",
          optimized: false,
        });

        var box = $(`<div><a>${deliveryPath.length - 1 != i ? `${i + 1}` : "🏠"}</a></div>`)[0];
        box.index = 1;
        box.style.backgroundColor = '#fff';
        box.style.border = "2px solid #fff";
        box.style.borderRadius = "3px";
        box.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        box.style.cursor = "pointer";
        box.style.margin = "5px";
        box.style.width = "32px";
        box.style.lineHeight = "32px";
        box.style.textAlign = "center";
        box.style.color = "rgb(25,25,25)";
        box.style.fontFamily = "Roboto,Arial,sans-serif";
        box.style.fontSize = "16px";

        box.addEventListener("click", () => {
          map.setCenter(position);
        });

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(box);
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