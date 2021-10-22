<?php

//NO_IMAGE_URLをグローバル宣言している（理屈とかなく丸暗記）

global $NO_IMAGE_URL; //globalはグローバル関数であるということですよ

$NO_IMAGE_URL= '/image/noimg.png';//imageファイルのnoimg.png

//

//標準機能の設定
add_theme_support('post-thumbnails');//アイキャッチを有効にする(デフォルトではアイキャッチを使用できないため記述する必要がある)
//疑問 この場合はアクションフックはいらないのか？


/*文字数の設定→文字数の設定,これらをすべて書けるようになる必要はないと思う,writing力よりreading力
------------------------------------------------------*/
function max_excerpt_length( $string/*文字が入る(ここではpage-blog.phpのタイトル) */, $maxLength/*文字の長さの最大数 */) {
    $length = mb_strlen($string, 'UTF-8');//strlenはstring lengthの略,mb_strlenについてまたggr
    if($length < $maxLength){
        return $string;
    }   else { //$length > $maxLengthの時
            $string = mb_substr( $string , 0 , $maxLength, 'utf-8' );//substrはsub string
            return $string.'[...]';
        }//もし文字数の最大数を超えてしまって場合は「[...続きを読む]」などのようなものを出力するってこと？
}
//mb_strlen（文字列の長さを取得）とmb_substr（文字列の切り出し）を区別
//max_excerpt_lengthは自作した関数名（おそらく）,[...]は省略記号
//抜粋の文字数はデフォルトで55単語、日本語などのマルチバイト文字では110文字,うえのはこれらを変更するための記述だと思われる
//$maxLengthは引数でpage-blog.phpで関数を呼び出す時に定義されている↓
//$title = max_excerpt_length(get_the_title( $post->ID ), 60);//記事タイトルを取得し、文字数を制限（functions.php）
//$string = mb_substr( $string , 0 , $maxLength, 'utf-8' );において、変数の$stringと引数の$stringは同じもの、mb_substr関数で、引数の$stringを$maxLengthの文字数で切り出して、引数$stringに格納し直しています。（つまり上書きしています、


/*ページネーション→ページネーションでぐぐる,これらをすべて書けるようになる必要はないと思う,writing力よりreading力
//最悪、わからなければプラグインを使えばいい
---------------------------------------------------------*/
/*
使い方↓
$page_url = $_SERVER['REQUEST_URI'];//ページurlを取得,$_SERVER['キーの名前']でよびだす,$_SERVER['REQUEST_URI']は自作などではなく、元々決まっている変数,他にもいろいろな変数がある
$page_url = strtok( $page_url, '?' );//パラメータは切り捨て
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);

引数↓
@ $pages =>     全ページ数
@ $term_id =>   タクソノミーID
@ $paged =>     現在のページの値(数)
@ $page_url =>  ページURL
@ $range =>     前後に何ページ分表示するか（引数が無ければ2ページ表示する）
*/
function pagination( $pages, $term_id, $paged, $page_url, $range = 2) {

    $pages = ( int ) $pages;
    //全てのページ数。float型(浮動小数点数）で渡ってくるので明示的にint型 へ
    //float型からint型へ変数の型を変更(キャスト)している
    //その理由はがちでプログラミングにとりくむまでおそらくわからない→pythonをしたら少しわかったかも
    $paged = $paged ?: 1;
    //そもそも$pagedはpage-blog.phpの6行目で定義されている
    //現在のページを表示するための処理
    //三項演算子を省略形。省略しない場合は以下となります。
    //$paged = ($paged) ? $paged : 1;
    //get_query_var('paged')をそのまま投げても大丈夫なように
    //三項演算子をif文を使ってかいた場合↓
    //if ($paged) {
    //$paged = $paged;
    //} else {
    //$paged = 1;
    //}
    $term_id = ( $term_id ) ? $term_id : 0;
    //タームID
    //term_idに値がセットされている場合はterm_idをセット、セットされていない場合は0
    //省略形で書くのであれば、$term_id = $term_id ?: 0;


    //-----------------------------------
    $s = $_GET['s'];
    //検索ワードを取得
    $search = ($s) ? '&s='.$s : '';
    //検索パラメータを制作
    //■投稿データが検索条件で絞られている場合、ページリンクに検索条件を引き継ぐ.例：投稿がキーワード「ZONE」で絞られている場合は、ページネーションのリンクに検索条件「ZONE」を引き継がせる
    //function pagination() の関数に上記の機能をあらかじめ実装している形。したがって、サイト自体に投稿の検索機能がない場合は,$sや$searchの変数はなくてもよい
    //-----------------------------------


    if ($pages === 1 ) {
      // 1ページ以上の時 => 出力しない
    return;//出力しないを表す
    };
    if ( 1 !== $pages ) {
      //２ページ以上の時
        echo '<div class="inner">';
        if ( $paged > $range + 1 ) {
				// 一番初めのページへのリンク
				echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum=1'.$search.'"><span>1</span></a></div>';
        echo '<div class="dots"><span>・・・</span></div>';
			};
        for ( $i = 1; $i <= $pages; $i++ ) {
            //for文は繰り返し処理に使う
        //今おるページ番号の表示
            if ( $i <= $paged + $range && $i >= $paged - $range ) {
              //
                if ( $paged == $i ) {
                //現在表示しているページ
                echo '<div class="number -current"><span>'.$i.'</span></div>';
                } else {
             //前後のページ
                echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='.$i.$search.'"><span>'.$i.'</span></a></div>';
                    };
            };
        };
        if ( $paged < $pages - $range ) {
				// 一番最後のページへのリンク
        echo '<div class="dots"><span>...</span></div>';
        echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='. $pages.$search.'"><span>'. $pages .'</span></a></div>';
        }
        echo '</div>';
  };
};


/*パンくず→パンくずリスト表示方法でググる,これらをすべて書けるようになる必要はないと思う,writing力よりreading力
--------------------------------------------------------- */
function breadcrumb() {
    $title = get_the_title();
  //記事タイトル,ループの外で使う場合idが必要なようです,get_the_title()は、引数を指定しないと現在の投稿のタイトルを返します
  //外部のファイルにおいてbreadcrumbの引数にいれた値がfunctions.phpの$postIDに入り、それがさらにget_the_titleの引数の$postIDに入る。外部のファイルは引数に$post->IDをいれておりこれにより、そのページのIDが入りパンくずリストに任意のページのタイトルが入る
    echo '<ol class="breadcrumb-list">';
    if ( is_single() ) {
    //詳細ページの場合
    echo '<li class="breadcrumb-item"><a href="/">ホーム</a><span>></span></li>';
    echo '<li class="breadcrumb-item"><a href="/blog/">ブログ</a><span>></span></li>';
    echo '<li class="breadcrumb-item title-item" aria-current="page">'.$category.'</a></li>';
    echo '<li class="breadcrumb-item title-item" aria-current="page">'.$title.'</li>';
    //$titleは固定ページの「お問い合わせ」や「送信完了」「ブログ」の部分
    //$titleはfunctions.phpでは定義されていないが、各テンプレートで定義されておりそこで、breadcrumb()の関数を用いることで$titleを使う
    }
    else if( is_page() ) {
    //固定ページの場合
    echo '<li class="breadcrumb-item"><a href="/">ホーム</a><span>></span></li>';
    echo '<li class="breadcrumb-item" aria-current="page">'.$title.'</li>';
    //$titleは固定ページの「お問い合わせ」や「送信完了」「ブログ」の部分
    }
    echo "</ol>";
}
//パンくずリストの表示方法はほかにもいろんなやりかたがある

function my_script() {
  wp_enqueue_style( 'style-slick' , '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'style-reset', get_template_directory_uri() . '/css/reset.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'style-css', get_template_directory_uri() . '/css/style.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'style-animation', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '1.0.0', 'all' );

  wp_enqueue_script( 'js-jqery','//code.jquery.com/jquery-3.5.1.min.js', array(),'1.0.0','all');
  wp_enqueue_script( 'js-slick','//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(),'1.0.0','all');
  wp_enqueue_script( 'js-main', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', 'all');
  wp_enqueue_script( 'js-wow', get_template_directory_uri() . '/js/wow.min.js', array(), '1.0.0', 'all');
};
add_action('wp_enqueue_scripts', 'my_script');
//↑scriptじゃなくてscriptsです（間違えないように）

//メニュー
function my_menu_init() {
  register_nav_menus( array(
    'global' =>  'グローバルメニュー',
    'utility' => 'ユーティリティメニュー',
    'drawer' => 'ドロワーメニュー',
  ));
}
add_action( 'init', 'my_menu_init');
