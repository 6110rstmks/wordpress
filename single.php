<?php get_header();?>

<?php
global $NO_IMAGE_URL;
?>

<main class="single">
    <div class="breadcrumb">
<?php
breadcrumb( $post->ID );
?>
    </div>
    <div class="single-wrapper article-wrapper">
        <div class="inner">
<?php
//single.phpではメインループを使うものと覚えてしまう
//コンテンツは1つなのでループを回す必要はないように思えますが、single.phpのようなこテーページについてもループを使って表示するのがWordPressです。 -->
if ( have_posts() ):
    ////elseの処理があるのでif文を省略してはならない
    while ( have_posts() ):
        the_post();
        $content = get_the_content();
        //記事本文
        $category = get_the_category()[0]->name;
        ////カテゴリを取得（並び順で1番目にあるものを1つ）、カテゴリが複数設定されている場合でも初めの1つのみの取得
        $title = get_the_title();
        $date = get_the_modified_date( 'Y-m-d', $post->ID );
        //$postはそのページで必要となる投稿に関する情報が詰まったオブジェクト変数
        //the_date()が投稿の公開日を出力するのに対し、the_modified_date()投稿が修正された日付を出力
        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ?/*条件が正しい時の値→ */ get_the_post_thumbnail_url( $post->ID/*postには投稿の情報が入ったオブジェクト関数*/, 'medium' )/*サイズは、’thumbnail’, ‘medium’, ‘large’, ‘full’, の中から好きにしてください。*/ :/*条件がまちがっているときの値 */ get_template_directory_uri().$NO_IMAGE_URL;//get_template_directory_uriはテーマディレクトリのパスを出力する関数
        $thumbID = get_post_thumbnail_id( $post->ID );
        $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
        //アイキャッチIDからaltを取得、、altは画像などが表示できない場合に代わりに表示する文字列を定義するもの
        /*↓関連記事を表示するための設定 */
        $categorys = get_the_category();//カテゴリ
        $categoryList = '';
        //変数categorylistの中身を初期化、変数の宣言と同時に変数に値を代入することを変数の初期化といいます
        foreach( $categorys as $val ){//$categorysのデータを一つずつとりだして$valへいれてる
            $categoryList = ($categoryList) ? $categoryList.','.$val->slug : $categoryList.$val->slug;//.で文字列の連結(progate参照)
            //こちらスラッグを取得している、valはvalueの略
            //ここ理解できない（7.14)
        };
?>
            <header class="single-title">
            <!-- ↑ここは別にdivでもいい -->
                <div class="category">
                    <?php echo $category; ?>
                </div>
                <h1 class="main">
                    <?php echo $title;?>
                </h1>
            </header>
            <div class="entry">
                <article class="single-entry">
                    <!-- ブログの各記事はarticleタグでかくのがセオリー -->
                    <div class="wrapper">
                        <div class="info">
                            <!-- snsシェアボタン -->
                            <p class="time">
                                <time datetime="<?php echo $date ;?>"><?php echo $date ;?></time>
                            </p>
                        </div>
                        <div class="body">
                            <div class="image">
                                <img src="<?php echo $thumbnail;?>" alt="<?php echo $alt;?>">
                            </div>
<?php
echo $content;
?>
                        </div>
                    </div>
                </article>
<?php
    endwhile;
else:
    echo 'すいません。お探しの記事はありません';
endif;
?>
<!-- サイドバー -->
                <aside class="single-widget">
                    <!-- asideタグは補助的な内容を表す要素 メインループは使用したのでサブループを使用 -->
<?php
$query_args = array(
    'post_status'=> 'publish',
    'post_type'=> 'post',
    'order'=>'DESC',
    'posts_per_page'=>5,
    'orderby'=>'menu_order',
    'category_name'=>$categoryList
    //カテゴリーのスラッグ（カテゴリ名ではありません）を使用します
);
$the_query = new WP_Query( $query_args );
if( $the_query->have_posts() ):
?>
                    <div class="widget-relative widget-section">
                        <div class="title">関連記事</div>
                        <div class="list">
<?php
    while( $the_query->have_posts() ):
        $the_query->the_post();
        $link = get_permalink( $post->ID );
        //$postのなかに格納されているIDにアクセス
        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;
        $title = get_the_title( $post->ID );
?>
                            <div class="item">
                                <a href="<?php echo $link?>"></a>
                                <div class="image">
                                    <img src="<?php echo $thumbnail;?> " alt="">
                                </div>
                                <div class="title"><?php echo $title;?></div>
                            </div>
<?php
    endwhile;
?>
                        </div>
                    </div>
<?php
endif;
wp_reset_query();
?>
<?php
$query_args = array(
    'post_status' => 'publish',
    'post_types' => 'post',
    'order' => 'DESC',
    'post_per_pages' =>5,
    'tag' => 'recommend',
    //wordpressの投稿のタグにrecommendを設定する
);
$the_query = new WP_Query( $query_args );
if ( $the_query->have_posts() ):
?>
                            <div class="widget-relative widget-section">
                                <div class="title">おすすめの記事</div>
                                <div class="list">
<?php
    while( $the_query->have_posts() ):
        $the_query->the_post();
        $link = get_permalink( $post->ID );
        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium')) ? get_the_post_thumbnail_url( $post->ID, 'medium') : get_template_directory_uri().$NO_IMAGE_URL;
        $title = get_the_title( $post->ID );
?>
                                    <div class="item">
                                        <a href="<?php echo $link;?>"></a>
                                        <div class="image">
                                            <img src="<?php echo $thumbnail;?>" alt="">
                                        </div>
                                        <div class="title"><?php echo $title;?></div>
                                    </div>
<?php
    endwhile;
?>
                                </div>
                            </div>
<?php
endif;
wp_reset_query();
?>
                </aside>
            </div>
        </div>
    </div>
</main>

<?php get_footer();?>