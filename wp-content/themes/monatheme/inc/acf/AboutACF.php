<?php

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Gallery;
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
        'title' => 'Thiết lập trang giới thiệu',
        'style' => 'default',
        'position' => 'acf_after_title',
        'hide_on_screen' => [
            'the_content',
        ],
        'location' => [
            Location::where('page_template', '==', 'page-template/template-about.php',)
        ],
        'fields' => [
            Tab::make('Tab section giới thiệu')
                ->placement('left'),
            Group::make('Section giới thiệu', 'section_about')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Tiêu đề', 'title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                    Textarea::make('Mô tả', 'description')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->newLines('br'),
                    Repeater::make('Ảnh', 'gallery')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->fields([
                            Image::make('Ảnh', 'image')
                                ->helperText('Kích thước đề xuất: 500x750px')
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

            Tab::make('Tab section tầm nhìn')
                ->placement('left'),
            Group::make('Section tầm nhìn', 'section_vision')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Repeater::make('', 'list')
                        ->collapsed('title')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->layout('block')
                        ->fields([
                            Text::make('Tiêu đề', 'title')
                                ->required(),
                            Textarea::make('Mô tả', 'description')
                                ->newLines('br'),
                            Image::make('Ảnh', 'image')
                                ->helperText('Kích thước đề xuất: 500x750px')
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'svg', 'webp', 'avif',
                                ])
                                ->format('id'),
                        ]),
                ]),

            Tab::make('Tab section phong cách làm việc')
                ->placement('left'),
            Group::make('Section phong cách làm việc', 'section_work')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Repeater::make('Danh sách', 'list')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->layout('block')
                        ->fields([
                            Text::make('Tiêu đề', 'title'),
                            Textarea::make('Mô tả', 'description')
                                ->newLines('br'),
                            Image::make('Ảnh', 'image')
                                ->helperText('Kích thước đề xuất: 400x720px')
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'svg', 'webp', 'avif',
                                ])
                                ->format('id')
                                ->required(),
                        ]),
                ]),

            Tab::make('Tab section cam kết')
                ->placement('left'),
            TrueFalse::make('Hiển thị', 'show_section_commit')
                ->helperText('Vào thiết lập theme -> Thiết lập chung -> Tab section cam kết')
                ->stylized(),
        ],
    ]);
}, 10);