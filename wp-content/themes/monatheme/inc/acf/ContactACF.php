<?php

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Location;

defined('ABSPATH') || exit;

add_action('acf/init', function () {
    register_extended_field_group([
        'title' => 'Thiết lập trang liên hệ',
        'style' => 'default',
        'position' => 'acf_after_title',
        'hide_on_screen' => [
            'the_content',
        ],
        'location' => [
            Location::where('page_template', '==', 'page-template/template-contact.php'),
        ],
        'fields' => [
            Tab::make('Tab section form')
                ->placement('left'),
            Group::make('Section form', 'section_form')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Image::make('Logo')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->acceptedFileTypes([
                            'png', 'jpg', 'jpeg', 'gif',
                            'svg', 'webp', 'avif',
                        ])
                        ->format('id'),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                    Textarea::make('Mô tả', 'description')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->newLines('br'),
                    Repeater::make('Thông tin liên hệ', 'contacts')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->layout('block')
                        ->fields([
                            Image::make('Icon')
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'svg', 'webp', 'avif',
                                ])
                                ->format('id'),
                            Text::make('Tiêu đề', 'title')
                                ->column(33.33),
                            Text::make('Văn bản', 'text')
                                ->required()
                                ->column(33.33),
                            Text::make('URL')
                                ->column(33.33),
                        ]),
                    Text::make('Form shortcode', 'shortcode')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                ]),

            Tab::make('Tab section bản đồ')
                ->placement('left'),
            Repeater::make('Section bản đồ', 'section_maps')
                ->layout('block')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                    Textarea::make('Bản đồ', 'map')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                    Repeater::make('Thông tin liên hệ', 'contacts')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->layout('block')
                        ->fields([
                            Text::make('Tiêu đề', 'title')
                                ->column(33.33),
                            Text::make('Văn bản', 'text')
                                ->required()
                                ->column(33.33),
                            Text::make('URL')
                                ->column(33.33),
                        ]),
                Image::make('Ảnh', 'image')
                    ->conditionalLogic([
                        ConditionalLogic::where('show', '==', '1'),
                    ])
                    ->acceptedFileTypes([
                        'png', 'jpg', 'jpeg', 'gif',
                        'svg', 'webp', 'avif',
                    ])
                    ->format('id'),
                ]),
        ],
    ]);
}, 10);