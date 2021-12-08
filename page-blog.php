<?php get_header(); ?>

<?php
$paged = $_GET['pagenum'];
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
    'post_type'=> 'post',
    'order'=>'DESC',
    'posts_per_page'=>3,
    'paged'=>$paged
);
$the_query = new WP_Query( $query_args );
if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;
        $title = max_excerpt_length(get_the_title( $post->ID ), 60);
        $desc = get_the_excerpt( $post->ID );
        //抜粋を取得
        $date = get_the_modified_date( 'Y-m-d', $post->ID );
        //更新日を取得
        $category = get_the_category( $post->ID )[0]->name;
        $link = get_permalink( $post->ID );
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
    };
?>
                                <p class="image" id="post-<?php the_ID();?>"<?php post_class();?>>
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
<?php
$page_url = $_SERVER['REQUEST_URI'];
$page_url = strtok( $page_url, '?' );
$the_category_id = null;
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);
?>
            </div>
        </div>
    </div>
</main>

<?php get_footer();
