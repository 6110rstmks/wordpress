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
if ( have_posts() ):
    while ( have_posts() ):
        the_post();
        $content = get_the_content();
        $category = get_the_category()[0]->name;
        $title = get_the_title();
        $date = get_the_modified_date( 'Y-m-d', $post->ID );
        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;
        $thumbID = get_post_thumbnail_id( $post->ID );
        $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
        $categorys = get_the_category();//カテゴリ
        $categoryList = '';
        foreach( $categorys as $val ){
            $categoryList = ($categoryList) ? $categoryList.','.$val->slug : $categoryList.$val->slug;//.で文字列の連結(progate参照)
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
                    <div class="wrapper">
                        <div class="info">
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
<?php
$query_args = array(
    'post_status'=> 'publish',
    'post_type'=> 'post',
    'order'=>'DESC',
    'posts_per_page'=>5,
    'orderby'=>'menu_order',
    'category_name'=>$categoryList
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
