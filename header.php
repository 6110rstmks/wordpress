<?php
global $_post,$_HEADER;

// URLを取得
$http = is_ssl() ? 'https' : 'http' . '://';
//三項演算子↑

$_HEADER['url'] = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
//https://www.flatflag.nir87.com/url-963 確認する
//https://wepicks.net/phpref-server/  も確認する

//ディスクリプションを取得
$_HEADER['description'] = wp_trim_words /*キストの先頭から指定された数の単語を切り出し、切り出した文字列を返す*/( strip_shortcodes( $post->post_content/*投稿オブジェクト(global $post)から投稿の中身を */  ), 55 );
//$_HEADER['description]はここで定義した関数でもともと存在する関数ではない

//ogp画像を取得
$_HEADER['og_image'] = get_the_post_thumbnail_url($post->ID);


//ページタイトルを取得
if(is_single() || is_page()) {
    $_HEADER['title'] = (get_the_title($post->ID)) ? get_the_title($post->ID) : get_bloginfo('name');
} else {
    $_HEADER['title'] = get_bloginfo('name');
}

$og_image .= '?' . time(); // UNIXTIMEのタイムスタンプをパラメータとして付与（OGPのキャッシュ対策）
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- OGPを設定するための記述↓ -->
    <!-- OGP設定をしていなかった場合、Facebook側が自動的に説明文や画像を表示してしまい、ページ内容がユーザーに正しく伝わらなくなります。 -->
    <meta property="og:title" content="<?php echo $_HEADER['title']; ?>">
    <!--  -->
    <meta property="og:type" content="blog">
    <!--  -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="og:url" content="<?php echo $_HEADER['url']; ?>">
    <meta property="og:image" content="<?php echo $_HEADER['og_image'].$og_image; ?>">
    <!-- 画像 -->
    <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
    <!-- サイト名 -->
    <meta property="og:description" content="<?php echo $_HEADER['description']; ?>">
    <!-- ページの説明文を指定します -->
    <meta property="og:locale" content="ja_JP">

    <meta name="description" content="<?php echo $_HEADER['description']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_HEADER['title'];?></title>

    <link rel="canonical" href="<?php echo $_HEADER['url'];?>">
    <!-- canonical（カノニカル）属性とは、Google、Yahoo!、MSNなどの大手検索エンジンがサポートするURLを正規化するためのタグです。 -->
    <?php wp_head(); ?>
</head>
<body>
<!-- ヘッダー -->
    <header class="header">
        <div class="header-fixed">
            <h1 class="header-logo"><a href="/"><img src="<?php echo get_template_directory_uri();?>/image/logo.png" alt="極楽亭"></a></h1>
            <button class="nav-btn" id="nav-btn" type="button" aria-label="メニュー"><span></span><span></span><span></span></button>
            <!-- aria-label属性は要素に対してラベル付けを行うものであり、buttonタグにメニューのラベルを充てている -->
        </div>
        <div class="nav header-nav" id="nav">
            <nav class="nav-wrap">
                <ul class="nav-list">
                    <li class="nav-item"><a href="#">宿泊予定</a></li>
                    <li class="nav-item"><a href="#">観光情報</a></li>
                    <li class="nav-item"><a href="#">よくあるご質問</a></li>
                    <li class="nav-item">
                        <a href="/contact/">お問い合わせ</a>
                        <!-- <a href="<？php echo bloginfo('url')/contact/;?>">お問い合わせ</a> -->
                    </li>
                </ul>
            </nav>
        </div>
    </header>