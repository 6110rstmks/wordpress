<?php get_header();?>

<main class="thanks">
    <div class="cmn-mv"></div>
    <div class="breadcrumb">
<?php
breadcrumb( $post->ID );
?>
    </div>
    <section class="contact-thanks">
        <div class="inner">
            <div class="thanks-text">
                <p>お問い合わせありがとうございます。</p>
                <p class="a">内容を確認した後に、担当者よりご連絡を差し上げます。</p>
                <p class="a"></p>
                <div class="link"><a href="/">ホームへ戻る</a></div>
            </div>
        </div>
    </section>
</main>

<?php get_footer();


