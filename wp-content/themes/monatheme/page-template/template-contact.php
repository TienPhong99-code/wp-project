<?php

/**
 * Template Name: Liên hệ
 */

defined('ABSPATH') || exit;

$page_id = get_the_ID();
$section_form = get_field('section_form', $page_id);
$section_maps = get_field('section_maps', $page_id);

get_header();

the_title('<h1 class="hide-sitename">', '</h1>');
mona_output_breadcrumb();
?>

<?php if (! empty($section_form['show'])) : ?>
    <section class="sec-contact-form">
        <div class="contact-form ss-mg-b">
            <div class="container">
                <div class="contact-form__flex row">
                    <div class="contact-form__left col">
                        <div class="wrapper">
                            <?php if (! empty($section_form['logo'])) : ?>
                                <div class="logo">
                                    <?php echo mona_get_image_by_id($section_form['logo']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (! empty($section_form['title'])
                                || ! empty($section_form['description'])) : ?>
                                <div class="mona-content">
                                    <?php if (! empty($section_form['title'])) : ?>
                                        <h3><?php echo esc_html($section_form['title']); ?></h3>
                                    <?php endif; ?>

                                    <?php if (! empty($section_form['description'])) : ?>
                                        <p><?php echo wp_kses($section_form['description'], [
                                            'br' => true,
                                        ]); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (! empty($section_form['contacts'])
                                && is_array($section_form['contacts'])) : ?>
                                <ul class="contact-address">
                                    <?php foreach ($section_form['contacts'] as $index => $item) : ?>
                                        <li class="contact-address__item">
                                            <div class="iwt">
                                                <?php if (! empty($item['icon'])) : ?>
                                                    <div class="icon">
                                                        <?php echo mona_get_image_by_id($item['icon']); ?>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="b-gr">
                                                    <?php if (! empty($item['title'])) : ?>
                                                        <p class="name"
                                                            ><?php echo esc_html($item['title']); ?></p>
                                                    <?php endif; ?>

                                                    <p class="val">
                                                        <?php if (! empty($item['url'])) : ?>
                                                            <a href="<?php echo esc_html($item['url']); ?>"
                                                                target="_blank" rel="nofollow">
                                                                <?php echo esc_html($item['text']); ?>
                                                            </a>
                                                        <?php else : ?>
                                                            <?php echo esc_html($item['text']); ?>
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (! empty($section_form['shortcode'])
                        || has_shortcode($section_form['shortcode'], 'contact-form-7')) : ?>
                        <div class="contact-form__right col">
                            <div class="wrapper">
                                <div class="mainForm normal">
                                    <?php echo do_shortcode($section_form['shortcode']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (
    ! empty($section_maps)
    && is_array($section_maps)
) : ?>
    <section class="sec-contact-map">
        <div class="contact-map ss-mg">
            <div class="container">
                <div class="contact-map__box">
                    <?php foreach ($section_maps as $index => $section) :
                        if (empty($section['show'])) continue;
                    ?>
                        <div class="contact-map__block">
                            <div class="flex row">
                                <div class="flex-left col">
                                    <div class="wrapper">
                                        <?php if (! empty($section['map'])) : ?>
                                            <div class="img">
                                                <div class="img-inner">
                                                    <?php
                                                    echo wp_kses($section['map'], [
                                                        'iframe' => [
                                                            'src'            => [],
                                                            'width'          => [],
                                                            'height'         => [],
                                                            'frameborder'    => [],
                                                            'allow'          => [],
                                                            'allowfullscreen' => [],
                                                            'loading'        => [],
                                                            'referrerpolicy' => [],
                                                            'sandbox'        => [],
                                                            'style'          => [],
                                                            'class'          => [],
                                                            'id'             => [],
                                                            'title'          => [],
                                                        ],
                                                    ]);
                                                    ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="info">
                                            <div class="info-wrapper">
                                                <?php if (! empty($section['title'])) : ?>
                                                    <p class="tt"><?php echo esc_html($section['title']); ?></p>
                                                <?php endif; ?>

                                                <?php if (
                                                    ! empty($section['contacts'])
                                                    && is_array($section['contacts'])
                                                ) : ?>
                                                    <div class="b-gr">
                                                        <?php foreach ($section['contacts'] as $index => $item) : ?>
                                                            <div class="lines">
                                                                <?php if (! empty($item['title'])) : ?>
                                                                    <p class="name"><?php echo esc_html($item['title']); ?></p>
                                                                <?php endif; ?>

                                                                <p class="val">
                                                                    <?php if (! empty($item['url'])) : ?>
                                                                        <a href="<?php echo esc_html($item['url']); ?>"
                                                                            target="_blank" rel="nofollow">
                                                                            <?php echo esc_html($item['text']); ?>
                                                                        </a>
                                                                    <?php else : ?>
                                                                        <?php echo esc_html($item['text']); ?>
                                                                    <?php endif; ?>
                                                                </p>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if (! empty($section['image'])) : ?>
                                    <div class="flex-right col">
                                        <div class="wrapper">
                                            <div class="img">
                                                <div class="img-inner">
                                                    <?php echo mona_get_image_by_id($section['image']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php
get_footer();
