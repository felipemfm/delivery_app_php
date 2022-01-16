<?php
session_cache_limiter("none");
session_start();
if (!isset($_SESSION["userid"])) {
  header("location: index.php");
  exit();
}
include_once __DIR__ . "/../includes/dbh.inc.php";
include_once __DIR__ . "/../includes/functions.inc.php";
$category = getCategoryNavBar($conn);
$storeinfo = getStoreInfo($conn, $id = "c-", $_SESSION["lat"], $_SESSION["long"]);
$timesort = array_column($storeinfo, 'time');
array_multisort($timesort, SORT_ASC, $storeinfo);
$storeinfo = array_splice($storeinfo, 0, 8);
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>買物を依頼 | PON PON</title>
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
          <li class="active"><button type="button" onclick="location.href='./index.php'">TOP</button></li>
          <?php foreach ($category as $element) : ?>
            <li>
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
    <!-- shopping-->
    <article class="wrap wrap--shopping">
      <div class="inner inner--tPd0">
        <h2 class="inner__title">お近くの店舗</h2>
        <section class="store">
          <?php foreach ($storeinfo as $element) : ?>
            <form action='menu.php' method='post' class='store__box'>
              <figure class='card'>
                <div class='card__img'>
                  <img src='../images/<?php echo $element["id"] ?>.jpg' loading='lazy'>
                </div>
                <div class='card__head'>
                  <figcaption class='card__title'><?php echo $element['name'] ?></figcaption>
                  <span class='card__icon'><?php echo $element["time"] ?>分</span>
                </div>
                <p class='card__text'><?php echo $element['address'] ?></p>
              </figure>
              <input type='hidden' name='id' value='<?php echo $element['id'] ?>'>
              <input type='hidden' name='address' value='<?php echo $element['address'] ?>'>
              <input type='hidden' name='name' value='<?php echo $element['name'] ?>'>
              <input type='hidden' name='code' value='<?php echo $element['code'] ?>'>
              <input type='hidden' name='phonenumber' value='<?php echo $element['phonenumber'] ?>'>
              <input type='hidden' name='lat' value='<?php echo $element['lat'] ?>'>
              <input type='hidden' name='long' value='<?php echo $element['long'] ?>'>
              <input type='hidden' name='open' value='<?php echo $element['open'] ?>'>
              <input type='hidden' name='close' value='<?php echo $element['close'] ?>'>
              <button type='submit' name='submit'></button>
            </form>
          <?php endforeach; ?>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
  <script type="text/javascript" src="../js/common.js"></script>
</body>

</html>