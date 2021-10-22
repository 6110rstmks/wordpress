<!-- page-blogのblogはスラッグのことです、archive.phpでもおけ -->

<?php get_header(); ?>

<?php
$paged = $_GET['pagenum'];
//$_GET」でURLに付与されたパラメータを取得できます
//$_GET['pagenum']とした場合、例えば「?pagenum=2」のイコールの右側部分、つまり「２」が取得できます。
//記事のどれをストックするかとか、ページネーションの動作のために、遷移先のページ番号をURLにパラメータとして追加しています。
//[]の中のpagenumはそもそも定義されているもの
//疑問(7.13)＄paged=$_GET[]はpage-blog.phpの93行目らへんで定義しちゃだめなの？$pagedはページネーションだからそのほうがわかりやすいと思う
//→ループの中の記事のとりだしにも使うのでここで定義しといた方がいいね

global $NO_IMAGE_URL;
?>
<main class="article">
    <!-- 投稿一覧ページ -->
    <div class="cmn-mv"></div>
    <div class="breadcrumb">
<?php
breadcrumb( $post->ID );
?>
    </div>
    <div class="article-section cmn-section">
        <div class="inner">
            <h2 class="cmn-title">
                <p class="main">ブログ</p>
                <span class="sub">blog</span>
            </h2>
            <div class="article-cont">
                <ul class="article-list">
<?php
$query_args = array(
    'post_status'=> 'publish',
    'post_type'=> 'post',//投稿ページ、ちなみにpostがデフォルト値
    'order'=>'DESC',//最高から最低へ降順.値はASCとDESC
    'posts_per_page'=>3,
    'paged'=>$paged
    //page-blogの4行目で定義されています、どのページかってこと
);
$the_query = new WP_Query( $query_args );
if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;
        $title = max_excerpt_length(get_the_title( $post->ID ), 60);
        //記事タイトルを取得し、文字数60に制限するために用いる（functions.php）
        //タイトルが60字以内ならそのままの文字数で出力する
        $desc = get_the_excerpt( $post->ID );
        //抜粋を取得
        $date = get_the_modified_date( 'Y-m-d', $post->ID );
        //更新日を取得
        $category = get_the_category( $post->ID )[0]->name;
        //カテゴリを取得（並び順で1番目にあるものを1つ）
        //カテゴリーのオブジェクトの配列の先頭要素（０はひとつめ）にname(仕様書でオブジェクトに入れれる値はきまっている）いれる
        $link = get_permalink( $post->ID );
        //これでsingle.phpのやつにとべる、front-page.phpのお知らせの$link = get_permalink($post->ID);も同じ
        //つまりget_permalinkはsingle.php専用であると考えておけばよい
        //メインループと比較して、サブループで$post->IDをつかうっぽい
        //投稿または固定ページの パーマリンク を取得
?>
                    <li class="article-item">
                        <a class="article-flex" href="<?php echo $link;?>">
                            <div class="article-text">
                                <p class="time">
                                    <time datetime="<?php echo $date;?>">
                                        <?php echo $date; ?>
                                    </time>
                                </p>
                                <div class="title">
                                    <?php echo $title;?>
                                </div>
                                <div class="desc">
                                    <?php echo $desc; ?>
                                </div>
                            </div>
                            <div class="article-image">
<?php
    if ( $category ){
        echo '<p class="category">'.$category.'</p>';//
    };//<!-- ↑画像の左上にカテゴリ名がある（お知らせ）（採用）など -->
    ////$categoryは上記のサブループ内で定義したやつ
?>
                                <p class="image" id="post-<?php the_ID();?>"<?php post_class();?>>
                                <!-- id="post-<？php the_ID();？>"<？php post_class;は各画像にクラス名をあてるための記述 -->
                                    <img src="<?php echo $thumbnail; ?>" alt="">
                                </p>
                            </div>
                        </a>
                    </li>
<?php
    endwhile;
endif;
WP_reset_query();
?>
                </ul>
            </div>
            <div class="article-pager">
        <!-- ページネーションを表示、結論コピペしたら表示できる -->
<?php
$page_url = $_SERVER['REQUEST_URI'];
//ページurlを取得, $_SERVER['REQUEST_URI']というものがサーバー変数にはある
//いいかたを変えると現在のURI（ドメイン以下のパス）を取得するサーバー変数です。
// 例えばhttp://www.flatflag.nir87.com/url-963?id=256 であれば /url-963?id=256をとりだす
//PHPが稼働しているウェブサーバーが生成するヘッダ情報、パス情報、スクリプトの位置のような情報を提供
//$_SERVER['REQUEST_URI']はページをアクセスするために指定されたURIを提供する
$page_url = strtok( $page_url, '?' );
//URLについているパラメータは切り捨て
//http://www.php-ref.com/bapi/02_strtok.html   ←これ参照
//うえのやつで例にすると、 url-963とid=256のみがとりだされる
$the_category_id = null;
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);
//ページネーションを表示（functions.php)
//$pagedは5行目らへんで定義する
//7.14わからない
?>
            </div>
        </div>
    </div>
</main>

<?php get_footer();//終了タグをかかないことが推奨されている