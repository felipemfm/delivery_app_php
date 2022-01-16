<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location: ../member");
    exit();
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
    <!-- PONPON機器未登録時の状態 -->
    <div class="hero hero--firstVisual">
        <div class="hero__background hero__background--earth"></div>
        <div class="hero__background hero__background--houseFix"></div>
        <div class="hero__registButton">
            <div class="modalButton">
                <a href="#" class="modalButton__button modalButton__button--open" data-modal-open="modal-1">PON PONを<br>登録する</a>
            </div>
            <div class="modal" data-modal="modal-1">
                <div class="modal__cover"></div>
                <div class="modal__inner">
                    <div class="form modal--form">
                        <form action="../includes/drone-register.inc.php" method="POST">
                            <dl class="form-inputGroup">
                                <dt>
                                    <span class="modal__img modal__img--body"><img src="../images/ponpon-serial-body.png"></span>
                                    <label>PONPON シリアルNo.</label>
                                </dt>
                                <dd><input type="text" name="ponpon-number" placeholder="シリアルNo.(8080 8080 8080 8080) " value="8080 8080 8080 8080" autocomplete="off"></dd>
                                <dt class="form-inputGroup__img">
                                    <span class="modal__img modal__img--house"><img src="../images/ponpon-serial-house.png"></span>
                                    <label>PONPON HOSUE シリアルNo.</label>
                                </dt>
                                <dd><input type="text" name="ponpon-house-number" placeholder="シリアルNo.(8080 8080 8080 8080) " value="8080 8080 8080 8080" autocomplete="off"></dd>
                            </dl>
                            <div class="form-buttonGroup">
                                <button class="form-buttonGroup__button form-buttonGroup__button--in" type="submit">PONPONを登録</button>
                            </div>
                        </form>
                    </div>
                    <div class="modalButton">
                        <a href="#" class="modalButton__button modalButton__button--close"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                <dd><input type="text" name="user-name" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "" ?>" autocomplete="name"></dd>
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
                            <div class="form-buttonGroup">
                                <button type="button" class="form-buttonGroup__button form-buttonGroup__button--out">変更する</button>
                            </div>
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
                                <dd><input type="text" name="ponpon-number" placeholder="シリアルNo.(8080 8080 8080 8080) " value="8080 8080 8080 8080" autocomplete="off"></dd>
                                <dt><label>PONPON HOSUE シリアルNo.</label></dt>
                                <dd><input type="text" name="ponpon-house-number" placeholder="シリアルNo.(8080 8080 8080 8080) " value="8080 8080 8080 8080" autocomplete="off"></dd>
                            </dl>
                            <div class="form-buttonGroup">
                                <button type="button" class="form-buttonGroup__button form-buttonGroup__button--in">変更する</button>
                            </div>
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
        <!-- 未登録の場合 -->
        <!-- <a href="../mypage/index.php" class="buttonMenu__item"><img src="../images/ponpon-menubutton-default.png"></a> -->
        <!-- PONPON登録済みの場合 -->
        <a href="../mypage/index-registered.php" class="buttonMenu__item"><img src="../images/ponpon-menubutton-default.png"></a>
        <a id="pageTop" href="#" class="buttonMenu__item"><i class="fas fa-chevron-up"></i></a>
        <a href="../index.php" class="buttonMenu__item"><i class="fas fa-unlock-alt"></i></a>
    </div>
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
    <script type="text/javascript" src="../js/common.js"></script>
</body>

</html>