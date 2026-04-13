<?php

/**
 * The template for displaying footer.
 *
 * @package MONA.Media / Website
 */

if (!defined('ABSPATH')) {
    die();
}

$current_permalink = mona_get_current_permalink();

$footer_top = get_field('footer_top', 'option');
$footer_main = get_field('footer_main', 'option');
$footer_bottom = get_field('footer_bottom', 'option');
$sticky_buttons = get_field('sticky_buttons', 'option');
?>
</main>

<?php if (! empty($footer_top['show'])
    || ! empty($footer_main['show'])
    || ! empty($footer_bottom['show'])) : ?>
    <footer class="ft">
        <div class="container">
            <?php if (! empty($footer_top['show'])) : ?>
                <div class="ft-top">
                    <div class="ft-top__flex row">
                        <?php if (! empty($footer_top['logo'])) : ?>
                            <div class="ft-top__left col">
                                <div class="ft-logo">
                                    <?php if (! empty($footer_top['logo_url'])) : ?>
                                        <a class="custom-logo-link" href="<?php echo esc_html($footer_top['logo_url']); ?>">
                                            <?php echo mona_get_image_by_id($footer_top['logo']); ?>
                                        </a>
                                    <?php else : ?>
                                        <div class="custom-logo-link">
                                            <?php echo mona_get_image_by_id($footer_top['logo']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (! empty($footer_top['form_shortcode'])
                            || has_shortcode($footer_top['form_shortcode'])) : ?>
                            <div class="ft-top__right col">
                                <div class="ft-form">
                                    <?php echo do_shortcode($footer_top['form_shortcode']); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>


            <?php if (! empty($footer_main['show'])) : ?>
                <div class="ft-bottom">
                    <div class="ft-bottom__flex row">
                        <?php if (! empty($footer_main['main']) 
                            || ! empty($footer_main['main']['show'])) : ?>
                            <div class="ft-item col">
                                <div class="wrapper">
                                    <?php if (! empty($footer_main['main']['contacts'])
                                        && is_array($footer_main['main']['contacts'])) : ?>
                                        <ul class="ft-info">
                                            <?php foreach ($footer_main['main']['contacts'] as $index => $item) : ?>
                                                <li class="ft-info__item">
                                                    <?php if (! empty($item['url'])) : ?>
                                                        <a class="ft-info__link" href="<?php echo esc_html($item['url']); ?>"
                                                            rel="nofollow">
                                                            <div class="iwt">
                                                                <div class="icon">
                                                                    <?php if (! empty($item['image'])) : ?>
                                                                        <?php echo mona_get_image_by_id($item['image']); ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <span class="txt"> <?php echo esc_html($item['text']); ?></span>
                                                            </div>
                                                        </a>
                                                    <?php else : ?>
                                                        <div class="ft-info__link">
                                                            <div class="iwt">
                                                                <div class="icon">
                                                                    <?php if (! empty($item['image'])) : ?>
                                                                        <?php echo mona_get_image_by_id($item['image']); ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <span class="txt"> <?php echo esc_html($item['text']); ?></span>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (! empty($footer_main['main']['socials'])
                                        && is_array($footer_main['main']['socials'])) : ?>
                                        <div class="ft-social">
                                            <div class="social">
                                                <div class="social-list">
                                                    <?php foreach ($footer_main['main']['socials'] as $index => $item) : ?>
                                                        <?php if (! empty($item['url'])) : ?>
                                                            <a class="social-link" href="<?php echo esc_html($item['url']); ?>"
                                                                rel="nofollow">
                                                                <?php echo mona_get_image_by_id($item['image']); ?>
                                                            </a>
                                                        <?php else : ?>
                                                            <div class="social-link">
                                                                <?php echo mona_get_image_by_id($item['image']); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php 
                            if (! empty($footer_main['subs'])
                                && is_array($footer_main['subs'])) {
                                foreach ($footer_main['subs'] as $column) {
                                    if (empty($column['show']) || empty($column['socials'])) continue;
                                    ?>
                                    <div class="ft-item col">
                                        <div class="wrapper">
                                            <ul class="menu-list">
                                                <?php foreach ($column['socials'] as $index => $link) : 
                                                    $is_active = $current_permalink == $link['link']['url'];
                                                    ?>
                                                    <li class="menu-item <?php echo $is_active ? 'current-menu-item' : ''; ?>">
                                                        <?php if (! empty($link['link'])
                                                            && is_array($link['link'])) : ?>
                                                            <a class="menu-link" href="<?php echo esc_url($link['link']['url']); ?>" 
                                                                target="<?php echo esc_attr($link['link']['target']); ?>">
                                                                <?php echo esc_html($link['link']['title']); ?>
                                                            </a>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (! empty($footer_bottom['show'])) : ?>
                <div class="ft-sign">
                    <div class="ft-sign__flex">
                        <?php if (! empty($footer_bottom['copyright'])) : ?>
                            <div class="ft-sign__left"><?php echo esc_html($footer_bottom['copyright']); ?></div>
                        <?php endif; ?>

                        <?php if (! empty($footer_bottom['certificates'])
                            && is_array($footer_bottom['certificates'])) : ?>
                            <div class="ft-sign__right">
                                <div class="flex">
                                    <?php foreach ($footer_bottom['certificates'] as $index => $item) : ?>
                                        <div class="img">
                                            <?php if (! empty($item['url'])) : ?>
                                                <a href="<?php echo esc_url($item['url']); ?>">
                                                    <?php echo mona_get_image_by_id($item['image']); ?>
                                                </a>
                                            <?php else : ?>
                                                <?php echo mona_get_image_by_id($item['image']); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </footer>
<?php endif; ?>

<div class="back-to-top backToTop">
    <svg id="totop-btn" viewBox="0 0 100 100" height="100" width="100">
        <circle class="progress-background" fill="#fff" stroke-width="10" stroke="#F1EAE2" r="45" cy="50" cx="50">
        </circle>
        <circle class="progress-bar" stroke-dashoffset="282.743" stroke-dasharray="282.743" fill="none"
            stroke-width="10" stroke="#E8313D" r="45" cy="50" cx="50"></circle>
    </svg>
    <div class="triangle">
        <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/ic-double-arrow.svg" alt="image" loading="lazy" />
    </div>
</div>

<?php if (! empty($sticky_buttons)
    && is_array($sticky_buttons)) : ?>
    <div class="sidefix">
        <?php foreach ($sticky_buttons as $index => $item) : ?>
            <div class="sidefix-item">
                <?php if (! empty($item['link'])) : ?>
                    <a class="sidefix-link" href="<?php echo esc_html($item['link']); ?>">
                        <?php echo mona_get_image_by_id($item['image']); ?>
                    </a>
                <?php else : ?>
                    <div class="sidefix-link">
                        <?php echo mona_get_image_by_id($item['image']); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>

</html>