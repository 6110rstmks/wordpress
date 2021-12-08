<?php
global $NO_IMAGE_URL;
$NO_IMAGE_URL= '/image/noimg.png';
add_theme_support('post-thumbnails');
function max_excerpt_length( $string, $maxLength) {
    $length = mb_strlen($string, 'UTF-8');
    if($length < $maxLength){
        return $string;
    }   else { //$length > $maxLengthの時
            $string = mb_substr( $string , 0 , $maxLength, 'utf-8' );//substrはsub string
            return $string.'[...]';
}

$page_url = $_SERVER['REQUEST_URI'];
$page_url = strtok( $page_url, '?' );
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);
function pagination( $pages, $term_id, $paged, $page_url, $range = 2) {

    $pages = ( int ) $pages;
    $paged = $paged ?: 1;
    $term_id = ( $term_id ) ? $term_id : 0;
    $s = $_GET['s'];
    $search = ($s) ? '&s='.$s : '';  

    if ($pages === 1 ) {
    };
    if ( 1 !== $pages ) {
        echo '<div class="inner">';
        if ( $paged > $range + 1 ) {
	echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum=1'.$search.'"><span>1</span></a></div>';
        echo '<div class="dots"><span>・・・</span></div>';
	};
        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( $i <= $paged + $range && $i >= $paged - $range ) {
                if ( $paged == $i ) {
                echo '<div class="number -current"><span>'.$i.'</span></div>';
                } else {
                echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='.$i.$search.'"><span>'.$i.'</span></a></div>';
                };
            };
        };
        if ( $paged < $pages - $range ) {
        echo '<div class="dots"><span>...</span></div>';
        echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='. $pages.$search.'"><span>'. $pages .'</span></a></div>';
        }
        echo '</div>';
  };
};

function breadcrumb() {
    $title = get_the_title();
    echo '<ol class="breadcrumb-list">';
    if ( is_single() ) {
    //詳細ページの場合
    echo '<li class="breadcrumb-item"><a href="/">ホーム</a><span>></span></li>';
    echo '<li class="breadcrumb-item"><a href="/blog/">ブログ</a><span>></span></li>';
    echo '<li class="breadcrumb-item title-item" aria-current="page">'.$category.'</a></li>';
    echo '<li class="breadcrumb-item title-item" aria-current="page">'.$title.'</li>';
    }
    else if( is_page() ) {
    echo '<li class="breadcrumb-item"><a href="/">ホーム</a><span>></span></li>';
    echo '<li class="breadcrumb-item" aria-current="page">'.$title.'</li>';
    }
    echo "</ol>";
}

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

//メニュー
function my_menu_init() {
  register_nav_menus( array(
    'global' =>  'グローバルメニュー',
    'utility' => 'ユーティリティメニュー',
    'drawer' => 'ドロワーメニュー',
  ));
}
add_action( 'init', 'my_menu_init');
