<?php
/**
 * Template Name: Chính sách
 */

defined('ABSPATH') || exit;

$page_id = get_the_ID();
$page_permalink = get_the_permalink();

get_header();

mona_output_breadcrumb();
?>
<section class="sec-policy">
    <div class="policy ss-mg-b">
        <div class="container">
            <div class="layout-two row">
                <div class="layout-two-r col">
                    <div class="wrapper">
                        <div class="side-fixed">
                            <div class="side-fixed-wrap">
                                <?php 
                                $widgets = get_field('sidebar_policy', 'option');
                                if (! empty($widgets)) {
                                    foreach ($widgets as $widget) {
                                        switch ($widget['acf_fc_layout']) {
                                            case 'menu':
                                                if (empty($widget['show']) || empty($widget['menu'])) continue;
                                                ?>
                                                <div class="policy-cta">
                                                    <ul class="policy-cta__list">
                                                        <?php foreach ($widget['menu'] as $item) :
                                                            $is_active = $item['link']['url'] == $page_permalink;
                                                            ?>
                                                            <li class="policy-cta__item <?php echo $is_active ? 'active' : ''; ?>">
                                                                <a class="policy-cta__link" href="<?php echo esc_url($item['link']['url']); ?>" 
                                                                    target="<?php echo esc_attr($item['link']['target']); ?>">
                                                                    <?php echo esc_html($item['link']['title']); ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                                <?php
                                                break;
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="side-close"><i class="fas fa-times close icon"></i></div>
                        </div>
                        <div class="side-overlay"></div>
                    </div>
                </div>
                <div class="layout-two-l col">
                    <div class="wrapper">
                        <div class="side-open">
                            <div class="side-open-wrap"><i class="fa-solid fa-sidebar-flip"></i></div>
                        </div>
                        <div class="mona-content">
                            <?php the_title('<h1>', '</h1>'); ?>
                            <?php
                                if (get_the_content()) {
                                    the_content();
                                } else {
                                    echo '<p class="mona-empty">';
                                    esc_html_e('Nội dung sẽ sớm được cập nhật.', 'monamedia');
                                    echo '</p>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();