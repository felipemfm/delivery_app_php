// 読み込み時のtransition対策
window.onload = function () {
  const preload = document.getElementsByClassName('preload');
  preload[0].classList.remove('preload');
}

// スクロールアニメーション fadeUp
function scrollFadein() {
  $('.fadeAnimeJs > *').each(scrollIn);
}
// 処理
function scrollIn() {
  var elemPos = $(this).offset().top;
  var scroll = $(window).scrollTop();
  var windowHeight = $(window).height();
  if (scroll > elemPos - windowHeight + windowHeight / 4) {
    $(this).addClass('scroll--in');
  }
}
$(function () {
  $(window).scroll(function () {
    scrollFadein();
  });
  scrollFadein();
});

// modal-video.js setting
$(".js-modal-btn").modalVideo({
  channel: "youtube",
  youtube: {
    rel: 0, //関連動画の指定
    autoplay: 1, //自動再生の指定
    controls: 0, //コントロールさせるかどうかの指定
  },
});
$(".js-vimeo-modal-btn").modalVideo({ channel: "vimeo" });

// slick
$(function () {
  $("#slide1").slick({
    arrows: false,
    autoplay: true,
    autoplaySpeed: 0,
    cssEase: 'linear',
    speed: 5000,
    slidesToScroll: 1,
    slidesToShow: 5,
    responsive: [
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
        },
      },
    ],
  });
});

// 広告
$(function () {
  var winWidth = $('body').outerWidth(true);
  var ad = $('.ad');
  var adBox = $('.ad__box');
  //画面下位置を取得
  var bottomPos = $(document).height() - $(window).height() - 500;
  var showFlug = false;
  // ウィンドウより小さかったら開く
  panelOpen();
  //adを画面右外へ配置
  $('.ad').css('margin-left', winWidth + 'px');
  $(window).scroll(function () {
    panelOpen();
  });
  //閉じるボタン
  $('.ad__button').click(function () {
    ad.hide();
  });
  //ウィンドウリサイズしたらwidth変更
  $(window).resize(function () {
    winWidth = $('body').outerWidth(true);
    bottomPos = $(document).height() - $(window).height() - 500;
  });

  function panelOpen() {
    if ($(this).scrollTop() > 200) {
      if (showFlug == false) {
        showFlug = true;
        adBox.stop().animate({ 'marginLeft': '0px' }, 200);
      }
    } else {
      if (showFlug) {
        showFlug = false;
        adBox.stop().animate({ 'marginLeft': winWidth + 'px' }, 200);
      }
    }
  }
});