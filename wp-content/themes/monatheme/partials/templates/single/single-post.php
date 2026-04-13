<?php

/**
 * This is template for single post
 * 
 * @author MONA.Media / Website
 */

if (! defined('ABSPATH')) {
    die;
}

$post_id = get_the_ID();
$post_type = get_post_type();
$primary_cat = mona_get_primary_term($post_id);

$permalink = get_the_permalink();
$link_encoded = urlencode($permalink);

get_header();

mona_output_breadcrumb();
?>
<?php if (has_post_thumbnail($post_id)) : ?>
    <section class="sec-news-bn">
        <div class="news-bn">
            <div class="bg">
                <?php the_post_thumbnail(); ?>
            </div>
            <div class="news-bn__content"></div>
        </div>
    </section>
<?php endif; ?>

<section class="sec-news-dt">
    <div class="news-dt ss-mg">
        <div class="container">
            <div class="news-dt__head">
                <div class="title-gr center mb-24">
                    <?php the_title('<h1 class="title title-40">', '</h1>'); ?>

                    <div class="news-dt__author">
                        <?php
                            if ($primary_cat && ! is_wp_error($primary_cat)) {
                                ?>
                                <p class="name">
                                    <a href="<?php echo get_term_link($primary_cat->term_id); ?>">
                                        <?php echo esc_html($primary_cat->name); ?>
                                    </a>
                                </p>
                                <?php
                            }
                        ?>
                        <p class="date"><?php echo sprintf(
                            __('Đăng ngày %s', 'monamedia'),
                            get_the_date('d/m/Y')
                        ); ?></p>
                    </div>
                </div>
            </div>
            <div class="news-dt__content">
                <div class="news-dt__social">
                    <div class="social social-detail">
                        <div class="social-list">
                            <a class="social-link copyJS" href="<?php echo $permalink; ?>">
                                <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/ic-dt-share.svg" alt="image" loading="lazy" />
                            </a>
                            <a class="social-link" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link_encoded; ?>" target="_blank" rel="noopener">
                                <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/ic-dt-fb.svg" alt="image" loading="lazy" />
                            </a>
                            <a class="social-link" href="https://x.com/intent/tweet?url=<?php echo $link_encoded; ?>" target="_blank" rel="noopener">
                                <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/ic-dt-x.svg" alt="image" loading="lazy" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mona-content">
                    <?php
                        if (get_the_content()) {
                            the_content();
                        } else {
                            echo '<p class="mona-empty">';
                            esc_html_e('Nội dung sẽ sớm được cập nhật', 'monamedia');
                            echo '</p>';
                        }
                    ?>
                </div>

                <?php 
                    $tags = get_terms([
                        'taxonomy' => 'post_tag',
                        'object_ids' => [$post_id],
                        'fields' => 'id=>name',
                    ]);

                    if ($tags && ! is_wp_error($tags)) {
                        ?>
                        <div class="news-dt__kw">
                            <span class="txt"><?php esc_html_e('Từ khoá', 'monamedia'); ?></span>
                            <ul class="news-dt__kw-list">
                                <?php foreach ($tags as $id => $name) : ?>
                                    <li class="news-dt__kw-it">
                                        <a class="news-dt__kw-link" href="<?php echo get_term_link($id); ?>"
                                            >#<?php echo esc_html($name); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
$options = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'post__not_in' => [$post_id],
    'posts_per_page' => 6,
    'fields' => 'ids',
];

if ($cat_ids) {
    $options['tax_query'] = [
        [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $cat_ids,
        ],
    ];
}

$query = new WP_Query($options);
if ($query->have_posts()) {
?>
    <section class="sec-homes-dmnb homes-news">
        <div class="homes-dmnb ss-mg">
            <div class="container">
                <div class="head-hori mb-24">
                    <h2 class="title title-36 add-class t-medium text-hori" data-spl="data-spl"><?php esc_html_e('Có thể bạn sẽ thích', 'monamedia'); ?></h2>
                    <?php if (MONA_PAGE_BLOG) : ?>
                        <div class="btn-box">
                            <a class="btn white" href="<?php echo get_permalink(MONA_PAGE_BLOG); ?>"><span class="txt"><?php esc_html_e('Xem tất cả', 'monamedia'); ?></span></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="homes-dmnb__slider checkViewJS fadeUp" data-mirror="false" data-offset="1.2">
                    <div class="homes-dmnb__sw relative">
                        <div class="swiper row gap-res rows-3">
                            <div class="swiper-wrapper">
                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <div class="swiper-slide col">
                                        <?php get_template_part('partials/components/loops/item', 'post'); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
<?php
}
wp_reset_postdata();
?>
<?php
get_footer();
