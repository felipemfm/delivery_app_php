<?php
session_start();
include_once __DIR__ . "/includes/dbh.inc.php";

$sql = mysqli_query($conn, "SELECT count(*) as total, SUM(transaction_amount) as amount FROM transactions_database WHERE created_at > '2022-01-22';");
$result = mysqli_fetch_assoc($sql);
mysqli_free_result($sql);
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PON PON 空飛ぶMyパートナー</title>
<meta name="description" content="買物も、宅配も全てPON PONにお任せ！一人、一台「完全自律型ドローン」が個人物流時代の幕を開ける。">
<!-- css -->
<link rel="stylesheet" href="css/style-lp.css" media="screen">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<!-- favicon -->
<link rel="icon" href="images/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
</head>

<body class="preload body">
  <div class="bounce">
    <span class="bounce__text">P</span><span class="bounce__text"></span><span class="bounce__text">O</span><span class="bounce__text">N</span><span class="bounce__text">P</span><span class="bounce__text">O</span><span class="bounce__text">N</span>
  </div>
  </div>
  <!-- fix area -->
  <div id="fixContents">
    <!-- header -->
    <header class="header">
      <div class="logo">
        <p class="logo__text"><a>PON PON</a></p>
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
            <li><a href="mypage">My Page</a></li>
          </ul>
        <?php endif; ?>
      </div>
    </header>
  </div>
  <main>
    <article class="lp--warp">
      <!-- hero -->
      <section class="hero">
        <div class="hero__mainBox inner">
          <img class="hero__ponponBody" src="images/ponpon-right.png" alt="空飛ぶMyパートナー PONPON | キャラクターイメージ">
          <div class="hero__svg">
            <img class="hero__svg--sun" src="images/svg/sun.svg">
            <img class="hero__svg--triangle3d" src="images/svg/triangle_3d.svg">
          </div>
          </svg>
          <div class="hero__consept">
            <h1 class="hero__title"><span>時代はMIRAIへ</span><span>物流は<strong>PON PON</strong>で<i>！</i></span></h1>
            <p class="hero__text"><strong>PON PON</strong>はあなたのパートナーとして<span>新たな物流時代の幕を開く。</span></p>
            <div class="hero__svg">
              <svg xmlns="http://www.w3.org/2000/svg" width="160" height="40" viewBox="0 0 168.269 41.677" class="hero__svg--waveYellow">
                <path id="wave_y" d="M205.28,415.388c-16.03-.277-15.585-26.264-31.613-26.541s-16.479,25.707-32.513,25.439-15.6-26.266-31.641-26.539-16.507,25.71-32.567,25.432S61.335,386.913,45.28,386.64" transform="matrix(0.999, -0.035, 0.035, 0.999, -55.065, -375.559)" fill="none" stroke="#ecd26e" stroke-linecap="round" stroke-linejoin="round" stroke-width="7" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="160" viewBox="0 0 34.296 172.695" class="hero__svg--waveWhite">
                <path id="wave_w" d="M21.467,3,3,31.414,24.335,57.751,5.87,86.182l21.34,26.341L8.742,140.965l21.335,26.36" transform="translate(0 1.15)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="72" height="96" viewBox="0 0 78.129 97.088" class="hero__svg--box">
                <g id="box" transform="translate(-2 -2)">
                  <path id="path_185" data-name="path 185" d="M186.316,47.571,143,65.924,124.65,22.614,167.965,4.26Z" transform="translate(-108.187 -0.233)" fill="none" stroke="#252525" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                  <path id="path_186" data-name="path 186" d="M65.668,345.66,22.355,364.014,4,320.7,47.313,302.35Z" transform="translate(0 -267.531)" fill="none" stroke="#252525" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                  <path id="path_187" data-name="path 187" d="M454.107,47.309l-12.452,30.82L423.3,34.819,435.754,4Z" transform="translate(-375.987)" fill="none" stroke="#252525" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                  <path id="path_188" data-name="path 188" d="M47.351,34.821,4.04,53.174,16.49,22.352,59.8,4Z" transform="translate(-0.036)" fill="none" stroke="#252525" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                  <path id="path_189" data-name="path 189" d="M731.13,770" transform="translate(-665.462 -691.867)" fill="none" stroke="#252525" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                  <path id="path_190" data-name="path 190" d="M65.668,345.66,22.355,364.014,4,320.7,47.313,302.35Z" transform="translate(0 -267.531)" fill="none" stroke="#252525" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                  <line id="border_2" data-name="border 2" x1="12.483" y2="30.831" transform="translate(22.354 65.653)" fill="none" stroke="#252525" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                </g>
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="120" height="88" viewBox="0 0 136 108.798" class="hero__svg--triangle">
                <g id="triangle" transform="translate(0 54.399)">
                  <path id="path_2" data-name="path 2" d="M61.578,19.26,92.25,72.32l30.672,53.057-61.462-.067L0,125.241,30.788,72.253Z" transform="translate(0 -70.977)" fill="#ecd26e" />
                  <path id="path_3" data-name="path 3" d="M253.743,0,279.1,50.443l25.366,50.441-50.825-.064-50.826-.064,25.463-50.379Z" transform="translate(-168.471 -54.399)" fill="#fff" />
                </g>
              </svg>
            </div>
          </div>
        </div>
        <div class="hero--skyline"></div>
      </section>
      <!-- 空から人へ -->
      <section class="consept inner wave">
        <div class="consept__box fadeAnimeJs">
          <h2 class="consept__title">空から人々へ<span>新たな物流の未来を</span></h2>
          <p class="consept__text">車での輸送が当たり前の時代から、<span>必要な時に必要な物を「空から届ける」</span>という新たな物流の時代が到来しました。</p>
        </div>
        <div class="consept__visual fadeAnimeJs">
          <img class="consept__visual--main" src="images/lp/mainvisual_bg.png" alt="空から人々へ新たな物流の未来へ">
          <img class="consept__visual--delivery" src="images/ponpon-icon-delivery.png" alt="PONPON宅配 | イメージ画像 PON PON">
          <img class="consept__visual--shopping" src="images/ponpon-icon-shopping.png" alt="PONPON買物 | イメージ画像 PON PON">
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="wave__top">
          <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="wave__buttom">
          <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
        </svg>
      </section>
      <!-- video -->
      <section class="videoPr wave">
        <div class="videoPr__box fadeAnimeJs inner inner--middle">
          <h2 class="videoPr__title"><span>PON PON</span> プロモーションビデオ</h2>
          <div class="videoPr__image">
            <img src="images/lp/video_pr.png" alt="PON PON プロモーションビデオ | イメージ画像 PON PON">
            <div class="videoPr__button">
              <button class="js-modal-btn " data-video-id="shE6UDOJHh4"><i class="fab fa-youtube"></i>動画を見る</button>
            </div>
          </div>
        </div>
      </section>
      <!-- PONPONとは？ -->
      <section class="introduction inner">
        <div class="lp-head fadeAnimeJs">
          <p class="lp-head__title">PON PON</p>
          <h2 class="lp-head__description">新たな物流が、たくさんの嬉しいを届ける。</h2>
        </div>
        <div class="introduction__box fadeAnimeJs">
          <p class="introduction__item"><b>送料無料</b>で<span>ネットショッピング</span></p>
          <p class="introduction__item">注文からお届けまで<span><b>50%以上</b>の待ち時間削減</span></p>
          <p class="introduction__item">登録した予定に合わせ<span><b>完全自律飛行</b></span></p>
          <p class="introduction__item">PON PONで繋がり<span>必要な時に<b>空から贈り物</b></span></p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="wave__top">
          <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="wave__buttom">
          <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
        </svg>
      </section>
      <!-- おすすめの使い方 -->
      <section class="manual inner">
        <div class="lp-head fadeAnimeJs">
          <p class="lp-head__title">おすすめの<span>PON PON</span>の使い方</p>
          <h2 class="lp-head__description"><span>テーマは、</span>「母への誕生日プレゼント」</h2>
        </div>
        <ul class="list inner--large fadeAnimeJs">
          <li class="list__item">
            <div class="list__content">
              <time class="list__time">10:00</time>
              <p class="list__text">朝、ネットで注文した誕生日プレゼントのマフラーを、PON PONに店舗まで取りに行くよう依頼。</p>
            </div>
            <div class="list__image">
              <img src="images/lp/top_howtouse_ponpon01.jpg" alt="PONPONに母の誕生日のマフラーを買いに行くよう依頼。 | イメージ画像 PON PON">
            </div>
          </li>
          <li class="list__item">
            <div class="list__content">
              <time class="list__time">11:00</time>
              <p class="list__text">ツバポンの母が住む秋田へ、12時に出発するようPON PONに依頼。<span class="list__attantion">※ツバポンが誰なのか、ログインして探してみてね。</span></p>
            </div>
            <div class="list__image">
              <img src="images/lp/top_howtouse_ponpon02.jpg" alt="母のいる秋田へ12時に出発するようPONPONに
              依頼。 | イメージ画像 PON PON">
            </div>
          </li>
          <li class="list__item">
            <div class="list__content">
              <time class="list__time">12:00</time>
              <p class="list__text">PON PONが予定に合わせて、母の住む秋田へ出発。</p>
            </div>
            <div class="list__image">
              <img src="images/lp/top_howtouse_ponpon03.jpg" alt="PONPONが予定に合わせて、母の居る秋田の
              実家へ出発。 | イメージ画像 PON PON">
            </div>
          </li>
          <li class="list__item">
            <div class="list__content">
              <time class="list__time">13:00</time>
              <p class="list__text">PON PONが秋田へ到着し、プレゼントを母に渡す。</p>
            </div>
            <div class="list__image">
              <img src="images/lp/top_howtouse_ponpon04.jpg" alt="PONPONが秋田の実家へ到着し、プレゼントを
              母に渡す。 | イメージ画像 PON PON">
            </div>
          </li>
          <li class="list__item">
            <div class="list__content">
              <time class="list__time">14:00</time>
              <p class="list__text">PON PONが秋田から帰る前にツバポンの大好きな、秋田名物「味噌きりたんぽ」を購入するよう依頼。</p>
            </div>
            <div class="list__image">
              <img src="images/lp/top_howtouse_ponpon05.jpg" alt="PONPONが帰る前に秋田名物の「味噌きりたんぽ」を購入するよう依頼。 | イメージ画像 PON PON">
            </div>
          </li>
          <li class="list__item">
            <div class="list__content">
              <time class="list__time">15:30</time>
              <p class="list__text">PON PONがツバポンの自宅にある、PON PONハウスに到着。</p>
            </div>
            <div class="list__image">
              <img src="images/lp/top_howtouse_ponpon06.jpg" alt="PONPONが私の自宅のPONPONハウスに到着。 | イメージ画像 PON PON">
            </div>
          </li>
        </ul>
      </section>
      <!-- チーム紹介 -->
      <section class="team">
        <div class="lp-head fadeAnimeJs">
          <p class="lp-head__title"><span>PON PON</span>を共に創った</p>
          <h2 class="lp-head__description">#大切なチーム</h2>
        </div>
        <ul id="slide1" class="team__list">
          <li><img src="images/u-user-jin.jpg"></li>
          <li><img src="images/u-user-naoki.jpg"></li>
          <li><img src="images/u-user-ou.jpg"></li>
          <li><img src="images/u-user-tsubasa.jpg"></li>
          <li><img src="images/u-user-sou.jpg"></li>
          <li><img src="images/u-user-ubi.jpg"></li>
          <li><img src="images/u-user-felipe.jpg"></li>
        </ul>
      </section>
      <!-- app -->
      <div class="app wave">
        <div class="lp-head fadeAnimeJs">
          <h2 class="lp-head__title"><span>未来をいま、体験しよう。</span></h2>
          <p class="lp-head__description">感動をあなたの手に。</p>
        </div>
        <div class="inner--large">
          <section class="app__item">
            <div class="app__box fadeAnimeJs">
              <h2 class="app__title">いつもの、買物が変わる。</h2>
              <p class="app__text">もう、あなたが買い物に行く必要はありません。なぜなら必要な時にPON
                PONがあなたの登録した予定に合わせて、代わりに買物に行ってくれます。もちろん、ネットショッピングで買物しても、当日中にあなたのもとに届きます。</p>
            </div>
            <div class="app__box fadeAnimeJs"><img src="images/lp/app_shopping_01.png" alt="買い物が変わる | イメージ画像 PON PON">
            </div>
          </section>
          <section class="app__item">
            <div class="app__box fadeAnimeJs">
              <h2 class="app__title">いつでも、宅配で繋がる。</h2>
              <p class="app__text">
                本当に必要な人に必要な物を、空から届けることができます。遠く離れた家族、大切な友人、かけがえのない人にも、あなたの想いを乗せて届けましょう。そう、いつでも。いますぐでも。</p>
            </div>
            <div class="app__box fadeAnimeJs"><img src="images/lp/app_delivery_01.png" alt="買い物が変わる | イメージ画像 PON PON">
            </div>
          </section>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="wave__top">
          <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" id="svg-bg" class="wave__buttom">
          <path d="M0,0 v50 q10,10 20,0 t20,0 t20,0 t20,0 t20,0 v-50 Z"></path>
        </svg>
      </div>
    </article>
    <aside class="lp-login inner">
      <div class="lp-head fadeAnimeJs">
        <h2 class="lp-head__title"><span>さぁ、はじめよう。</span></h2>
        <p class="lp-head__description">あなたの想いを乗せて、個人物流時代の幕を開こう。</p>
      </div>
      <div class="lp-login__button">
        <?php if (!isset($_SESSION["userid"])) : ?>
          <a href="member/index.php">ログイン</a>
        <?php else : ?>
          <a href="mypage">My Page</a>
        <?php endif; ?>
      </div>
      <div class="lp-login__image fadeAnimeJs">
        <img src="images/lp/ponpon-login.png" alt="ログインしてPON PONをはじめる。 | イメージ画像 PON PON">
      </div>
    </aside>
  </main>
  <div class="button"></div>
  <!-- ad -->
  <section class="ad">
    <div class="ad__box">
      <span class="ad__button"><a href="javascript:void(0)" class="ad__button--close"><i class="fas fa-times-circle"></i></a></span>
      <h2 class="ad__title">みんな、PON PONはじめてる。<i class="fas fa-external-link-alt"></i></h2>
      <?php if (!isset($_SESSION["userid"])) : ?>
        <a href="member/index.php" class="button-hoverTextChange ad__text">
          <p class="button-hoverTextChange__text">注文数<span><?php echo $result["total"] ?></span>個&nbsp;&nbsp;&nbsp;合計金額<span><?php echo number_format($result["amount"]) ?></span>円</p>
          <p class="button-hoverTextChange__text">ログインしてはじめる。</p>
        </a>
      <?php else : ?>
        <a href="mypage" class="button-hoverTextChange ad__text">
          <p class="button-hoverTextChange__text">注文数<span><?php echo $result["total"] ?></span>個&nbsp;&nbsp;&nbsp;合計金額<span><?php echo number_format($result["amount"]) ?></span>円</p>
          <p class="button-hoverTextChange__text">My Pageへ</p>
        </a>
      <?php endif; ?>
    </div>
  </section>
  <!-- footer -->
  <footer class="footer">
    <small>Copyright <i class="far fa-copyright"></i> 2021-2022 PON PON All Rights Reserved.</small>
  </footer>
  <!-- javascript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
  <script src="//cdn.jsdelivr.net/npm/modal-video@2.4.2/js/jquery-modal-video.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script type="text/javascript" src="js/ponpon-lp.js"></script>
</body>

</html>