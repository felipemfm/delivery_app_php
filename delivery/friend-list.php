<?php
session_start();
if (!isset($_SESSION["userid"])) {
  header("location: ../index.php");
  exit();
}
include_once __DIR__ . "/../includes/dbh.inc.php";
include_once __DIR__ . "/../includes/functions.inc.php";
$friendlist = getFriendList($conn, $_SESSION["userid"]);
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>おともだちリスト 宅配を依頼 | PON PON</title>
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
    <!-- friend list 50 view -->
    <article class="wrap wrap--friend">
      <div class="inner inner--tPd0">
        <div class="head head--flex">
          <h2 class="head__title">ともだちリスト</h2>
        </div>
        <section class="friend friend--flex fadeAnimeJs">
          <?php foreach ($friendlist as $key => $element) : ?>
            <div class="cardBg">
              <div class="cardBg__img">
                <img src="../images/avatar/<?php echo $element["avatar"] ?>.jpg" loading="lazy">
              </div>
              <div class="cardBg__box">
                <div class="cardBg__box--icon">
                  <img src="../images/avatar/<?php echo $element["avatar"] ?>.jpg" loading="lazy">
                </div>
                <ul class="cardBg__info">
                  <li class="cardBg__name"><?php echo $element["name"] ?></li>
                  <li class="cardBg__id">#<?php echo $element["id"] ?></li>
                  <li class="cardBg__button cardBg__button--request">
                    <form action="friend-request.php" method="POST">
                      <button name="friend--add">宅配を送る</button>
                      <input type="hidden" name="friend_id" value="<?php echo $element["id"] ?>">
                      <input type="hidden" name="friend_name" value="<?php echo $element["name"] ?>">
                      <input type="hidden" name="friend_avatar" value="<?php echo $element["avatar"] ?>">
                      <input type="hidden" name="friend_lat" value="<?php echo $element["lat"] ?>">
                      <input type="hidden" name="friend_long" value="<?php echo $element["long"] ?>">
                    </form>
                  </li>
                </ul>
              </div>
              <div class="cardBg__delete">
                <form action="../includes/friend-remove.inc.php" method="post">
                  <input type="hidden" name="friend_id" value="<?php echo $element["id"] ?>">
                  <button name="submit" type="submit"><i class="fas fa-times"></i></button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </section>
      </div>
    </article>
  </main>
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