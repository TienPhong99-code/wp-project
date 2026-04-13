<?php
defined('ABSPATH') || exit;

if (! function_exists('mona_ajax_get_posts')) {
    function mona_ajax_get_posts() {
        try {
            if (! check_ajax_referer('mona-ajax-security', 'security', false)) {
                throw new Exception(__('Hành động không được xác thực', 'monamedia'));
            }

            $response = [
                'success' => true,
                'data' => [],
            ];

            $posts_per_page = filter_input(INPUT_POST, 'posts_per_page', FILTER_VALIDATE_INT);
            if (! $posts_per_page) {
                $posts_per_page = MONA_POSTS_PER_PAGE;
            }

            $paged = filter_input(INPUT_POST, 'paged', FILTER_VALIDATE_INT);
            if (! $paged) {
                $paged = 1;
            }

            $args = [
                'post_type' => 'post',
                'post_status' => 'publish',
                'offset' => ($paged - 1) * $posts_per_page,
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'fields' => 'ids',
                'meta_query' => ['relation' => 'AND'],
                'tax_query' => ['relation' => 'AND'],
                'orderby' => ['date' => 'DESC'],
            ];

            /**
             * Input format
             * 
             * [
             *     'category' => [1, 2],
             *     'post_tag' => [1, 2],
             * ]
             */
            if (! empty($_POST['taxonomies']) && is_array($_POST['taxonomies'])) {
                foreach ($_POST['taxonomies'] as $taxonomy => $terms) {
                    if (! is_array($terms)) continue;

                    $args['tax_query'][] = [
                        'taxonomy' => sanitize_text_field($taxonomy),
                        'field' => 'term_id',
                        'terms' => array_map(function ($term) {
                            return sanitize_text_field($term);
                        }, $terms),
                    ];
                }
            }

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                $response['data']['posts'] = [];
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();

                    $response['data']['posts'][] = [
                        'id' => $post_id,
                        'title' => get_the_title($post_id),
                        'thumbnail' => get_the_post_thumbnail($post_id, 'full'),
                        'permalink' => get_the_permalink($post_id),
                        'date' => get_the_date('d/m/Y', $post_id),
                        'author' => get_the_author($post_id),
                    ];
                }

                $response['data']['pagination_html'] = mona_pagination_links($query, $paged);
            } else {
                $response['data']['empty_message'] = __('Không có bài viết nào được tìm thấy', 'monamedia');
            }
            
            wp_send_json($response);
        } catch (\Throwable $th) {
            wp_send_json([
                'success' => false,
                'errors' => [
                    __('Đã xảy ra sự cố', 'monamedia'),
                    // $th->getMessage(), // Debug
                ],
            ]);
        }

        wp_die();
    }
}