<?php

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Location;

defined('ABSPATH') || exit;

add_action('acf/init', function () {
    register_extended_field_group([
        'title' => 'Thiết lập trang tin tức',
        'style' => 'default',
        'position' => 'acf_after_title',
        'location' => [
            Location::where('page_type', '==', 'posts_page'),
        ],
        'fields' => [
            Group::make('Section tin tức nổi bật', 'section_featured_posts')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                    Relationship::make('Các bài viết', 'posts')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->postTypes(['post'])
                        ->postStatus(['publish'])
                        ->filters([
                            'search', 'taxonomy',
                        ])
                        ->format('id'),
                    Repeater::make('Danh sách banner', 'banners')
                        ->maxRows(3)
                        ->layout('row')
                        ->fields([
                            Image::make('Ảnh', 'image')
                                ->helperText('Kích thước đề xuất: 400x280px')
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'svg', 'webp', 'avif',
                                ])
                                ->format('id')
                                ->required(),
                            Text::make('Tiêu đề', 'title'),
                            Text::make('Mô tả', 'description'),
                            Text::make('URL'),
                        ])
                ]),
        ],
    ]);
}, 10);