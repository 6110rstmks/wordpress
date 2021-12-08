<?php
global $_post,$_HEADER;

// URLを取得
$http = is_ssl() ? 'https' : 'http' . '://';

$_HEADER['url'] = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

//ディスクリプションを取得
$_HEADER['description'] = wp_trim_words /*キストの先頭から指定された数の単語を切り出し、切り出した文字列を返す*/( strip_shortcodes( $post->post_content  ), 55 );

//ogp画像を取得
$_HEADER['og_image'] = get_the_post_thumbnail_url($post->ID);


//ページタイトルを取得
if(is_single() || is_page()) {
    $_HEADER['title'] = (get_the_title($post->ID)) ? get_the_title($post->ID) : get_bloginfo('name');
} else {
    $_HEADER['title'] = get_bloginfo('name');
}

$og_image .= '?' . time();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="<?php echo $_HEADER['title']; ?>">
    <meta property="og:type" content="blog">
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="og:url" content="<?php echo $_HEADER['url']; ?>">
    <meta property="og:image" content="<?php echo $_HEADER['og_image'].$og_image; ?>">
    <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
    <meta property="og:description" content="<?php echo $_HEADER['description']; ?>">
    <meta property="og:locale" content="ja_JP">
    <meta name="description" content="<?php echo $_HEADER['description']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_HEADER['title'];?></title>
    <link rel="canonical" href="<?php echo $_HEADER['url'];?>">
    <?php wp_head(); ?>
</head>
<body>
<!-- ヘッダー -->
    <header class="header">
        <div class="header-fixed">
            <h1 class="header-logo"><a href="/"><img src="<?php echo get_template_directory_uri();?>/image/logo.png" alt="極楽亭"></a></h1>
            <button class="nav-btn" id="nav-btn" type="button" aria-label="メニュー"><span></span><span></span><span></span></button>
        </div>
        <div class="nav header-nav" id="nav">
            <nav class="nav-wrap">
                <ul class="nav-list">
                    <li class="nav-item"><a href="#">宿泊予定</a></li>
                    <li class="nav-item"><a href="#">観光情報</a></li>
                    <li class="nav-item"><a href="#">よくあるご質問</a></li>
                    <li class="nav-item">
                        <a href="/contact/">お問い合わせ</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
