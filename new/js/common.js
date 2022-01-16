// 読み込み時のtransition対策
window.onload = function(){
    const preload = document.getElementsByClassName('preload');
    preload[0].classList.remove('preload');
}

// topへ戻る
$(function(){
    var pagetop = $('#pageTop');
    $(window).scroll(function () {
       if ($(this).scrollTop() > 100) {
            pagetop.fadeIn();
       }
    });
    pagetop.click(function () {
       $('body, html').animate({ scrollTop: 0 }, 400);
       return false;
    });
});

// scroll fix navigation
let start_position = 0,
window_position,
$window = $(window),
$fixContents = $('#fixContents'),
$navi = $('.navigation--fix')

$window.on( 'scroll' , function(){
    // スクロール量の取得
    window_position = $(this).scrollTop();
    // スクロール量が初期位置より小さければ，
    // 上にスクロールしているのでヘッダーフッターを出現させる
    if (window_position <= start_position) {
        $fixContents .css('top','0');
    } else {
        $fixContents .css('top','0');
    }
    if (window_position <= start_position) {
        $navi.css('top','62px');
    } else {
        $navi.css('top','-62px');
    }
    // 現在の位置を更新する
    start_position = window_position;
});
// 中途半端なところでロードされても良いようにスクロールイベントを発生させる
$window.trigger('scroll');

//ヘッダーの高さ分だけコンテンツを下げる
$(function() {
    var height=$("#fixContents").height();
    $("body").css("margin-top", height + 35);
});

// 検索バー表示・非表示
$(".open-btn").click(function () {
    $("#search-wrap").addClass('panelactive');
  $('#search-text').focus();
});
$(".close-btn").click(function () {
    $("#search-wrap").removeClass('panelactive');
});

// スクロールアニメーション fadeUp
function scrollFadein(){
    $('.fadeAnimeJs .cardBg').each(scrollIn);
    $('.fadeAnimeJs .card').each(scrollIn);
}
// 処理
function scrollIn(){
    var elemPos = $(this).offset().top;
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll > elemPos - windowHeight + windowHeight / 4){
        $(this).addClass('scroll--in');
    }
}
$(function(){
    $(window).scroll(function (){
        scrollFadein();
    });
    scrollFadein();
});

// store title 文字をカット
const cutText = document.getElementsByClassName("card__title");
const mojisuu = 16;
//「mojisuu」取得まではグローバルで記述。
for (i = 0; i < cutText.length; i++) {
    //もしテキストの文字数がオーバーしたら
    if(cutText[i].innerText.length > mojisuu) {
    //テキストの取得/置き換え
    let str = cutText[i].innerText;
    str = str.substr(0,(mojisuu-1));
    cutText[i].innerText = str + " …";
    }
}

// 画像アップロード時のプレビュー
function previewImage(obj) {
    const fileReader = new FileReader();
    fileReader.onload = (function() {
        document.getElementById('preview').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
}

// モーダルウィンドウ ES
const modal = document.querySelectorAll('.modal');
const modalOpen = document.querySelectorAll('.modalButton__button--open');
const modalCover = document.querySelectorAll('.modal__cover');
let modalCloseAction;
let dataModalOpen;
let targetModal;
const TIMEOUT_SPEED = 500;
for (let i = 0; i < modalOpen.length; i++) {
    //モーダルを下げる処理
    modalCloseAction = function(e) {
    targetModal = e.currentTarget.closest('.modal');
    targetModal.classList.add('is-close');
    setTimeout(function(e) {
        targetModal.classList.remove('is-open');
        targetModal.classList.remove('is-close');
    }, TIMEOUT_SPEED);
    };
    // グレー部分をクリックでmodalを下げる
    const modalWrapClose = function() {
        modalCover[i].addEventListener('click',function(e){
        modalCloseAction(e);
    },false);
    };
    // modalをあげる
    const modalWrapOpen = function(e) {
    dataModalOpen = e.currentTarget.getAttribute('data-modal-open');
    for (var b = 0; b < modal.length; b++) {
        if (modal[b].getAttribute('data-modal') === dataModalOpen) {
        modal[b].classList.add('is-open');
        modalWrapClose();
        return false;
        }
    }
    };
    modalOpen[i].addEventListener('click', function(e) {
    modalWrapOpen(e);
    }, false);
}
// modalを下げる
const modalBtnClose = document.querySelectorAll('.modalButton__button--close');
for (let n = 0; n < modalBtnClose.length; n++) {
    modalBtnClose[n].addEventListener('click', function(e) {
    modalCloseAction(e);
    return false;
    }, false);
}

// mypage fadeで画像を切り替え
$(function(){
    var $interval = 20000;
    var $fade_speed = 800;
    $(".changeImageItems img").hide();
    $(".changeImageItems img:first").addClass("active").show();
    setInterval(function(){
        var $active = $(".changeImageItems img.active");
        var $next = $active.next("img").length?$active.next("img"):$(".changeImageItems img:first");
        $active.fadeOut($fade_speed).removeClass("active");
        $next.fadeIn($fade_speed).addClass("active");
    },$interval);
});

// checkout radioボタンが押された時の処理
if(document.URL.match(/menu-cart/)){
    const selecterBox = document.getElementById('radioSelect');
    function formSwitch() {
        check = document.getElementsByClassName('radio__check')
        if (check[0].checked) {
            selecterBox.style.display = "none";
        } else if (check[1].checked) {
            selecterBox.style.display = "block";
        } else {
            selecterBox.style.display = "none";
        }
    }
    window.addEventListener('load', formSwitch());
}

// input dateに本日の日付を初期値にする
if(document.URL.match(/friend-request/)){
    window.onload = function () {
        var date = new Date()
        var year = date.getFullYear()
        var month = date.getMonth() + 1
        var day = date.getDate()
        var toTwoDigits = function (num, digit) {
            num += ''
            if (num.length < digit) {
            num = '0' + num
            }
            return num
        }
        var yyyy = toTwoDigits(year, 4)
        var mm = toTwoDigits(month, 2)
        var dd = toTwoDigits(day, 2)
        var ymd = yyyy + "-" + mm + "-" + dd;
        document.getElementById("today").value = ymd;
    }
}