<?php

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Gallery;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\RadioButton;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Location;

defined('ABSPATH') || exit;

add_action('acf/init', function () {
    mona_regist_acf_field_group([
        'title' => 'Thiết lập trang chủ',
        'style' => 'default',
        'position' => 'acf_after_title',
        'hide_on_screen' => [
            'the_content',
        ],
        'location' => [
            Location::where('page_type', '==', 'front_page'),
        ],
        'fields' => [
            Tab::make('Tab section hero')
                ->placement('left'),
            Repeater::make('Banners')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Shortcode')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ])
                        ->required(),
                ]),

            Tab::make('Tab section danh mục nổi bật')
                ->placement('left'),
            Group::make('Section danh mục nổi bật', 'section_product_cat')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ]),
                    Taxonomy::make('Danh mục', 'categories')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ])
                        ->taxonomy('product_cat')
                        ->format('id')
                        ->appearance('checkbox'),
                ]),

            Tab::make('Tab section bộ sưu tập')
                ->placement('left'),
            Group::make('Section bộ sưu tập', 'section_collection')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ]),
                    Taxonomy::make('Danh mục', 'categories')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ])
                        ->taxonomy('product_cat')
                        ->format('id')
                        ->appearance('checkbox'),
                ]),

            Tab::make('Tab section sản phẩm mới ra mắt')
                ->placement('left'),
            Group::make('Section sản phẩm mới ra mắt', 'section_product')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ]),
                    Repeater::make('Slides')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ])
                        ->collapsed('show')
                        ->layout('block')
                        ->fields([
                            TrueFalse::make('Hiển thị', 'show')
                                ->stylized(),
                            Textarea::make('Mô tả', 'description')
                                ->conditionalLogic([
                                    ConditionalLogic::where('show', '==', '1')
                                ])
                                ->newLines('br'),
                            Link::make('Nút CTA', 'button_cta')
                                ->conditionalLogic([
                                    ConditionalLogic::where('show', '==', '1')
                                ]),
                            Image::make('Decor', 'background')
                                ->conditionalLogic([
                                    ConditionalLogic::where('show', '==', '1')
                                ])
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'svg', 'avif', 'webp',
                                ])
                                ->format('id'),
                            Repeater::make('Danh sách sản phẩm', 'products')
                                ->conditionalLogic([
                                    ConditionalLogic::where('show', '==', '1')
                                ])
                                ->required()
                                ->fields([
                                    Image::make('Ảnh', 'image')
                                        ->helperText('Kích thước đề xuất: 380x500px')
                                        ->acceptedFileTypes([
                                            'png', 'jpg', 'jpeg', 'gif',
                                            'svg', 'avif', 'webp',
                                        ])
                                        ->format('id')
                                        ->required(),
                                    Text::make('Tên sản phẩm', 'name'),
                                    Text::make('Giá cả', 'price'),
                                    Text::make('URL'),
                                ]),
                        ]),
                ]),

            Tab::make('Tab section gợi ý cho nàng')
                ->placement('left'),
            Group::make('Section gợi ý cho nàng', 'section_recommended')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ]),
                    Link::make('Nút CTA', 'button_cta')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ]),
                    Repeater::make('Danh mục sản phẩm', 'categories')   
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ])
                        ->fields([
                            Taxonomy::make('Danh mục', 'category')
                                ->taxonomy('product_cat')
                                ->format('id')
                                ->appearance('select'),
                        ]),
                ]),

            Tab::make('Tab section feedback khách hàng')
                ->placement('left'),
            Group::make('Section feedback khách hàng', 'section_feedback')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ]),
                    Repeater::make('Ảnh', 'images')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->fields([
                            Image::make('Ảnh', 'image')
                                ->helperText('Kích thước đề xuất: 385x550px')
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'svg', 'webp', 'avif',
                                ])
                                ->format('id')
                                ->required(),
                            Image::make('Icon')
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'svg', 'webp', 'avif',
                                ])
                                ->format('id'),
                            Text::make('Tác giả', 'author'),
                        ]),
                ]),

            Tab::make('Tab section cam kết')
                ->placement('left'),
            TrueFalse::make('Hiển thị', 'show_section_commit')
                ->helperText('Vào thiết lập theme -> Thiết lập chung -> Tab section cam kết')
                ->stylized(),

            Tab::make('Tab section giới thiệu')
                ->placement('left'),
            Group::make('Section giới thiệu', 'section_about')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Repeater::make('Danh sách', 'list')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ])
                        ->layout('block')
                        ->fields([
                            Image::make('Ảnh', 'image')
                                ->helperText('Kích thước đề xuất: 610x730px')
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'svg', 'avif', 'webp',
                                ])
                                ->format('id'),
                            Text::make('Tiêu đề', 'title')
                                ->required(),
                            Textarea::make('Mô tả', 'description')
                                ->newLines('br'),
                            Link::make('Nút CTA', 'button_cta'),
                        ]),
                ]),

            Tab::make('Tab section tin tức')
                ->placement('left'),
            Group::make('Section tin tức', 'section_news')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ]),
                    Relationship::make('Bài viết', 'posts')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1')
                        ])
                        ->postTypes(['post'])
                        ->postStatus(['publish'])
                        ->format('id'),
                ]),
        ],
    ], false);
}, 10);