<?php

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Location;

defined('ABSPATH') || exit;

add_action('acf/init', function () {
    register_extended_field_group([
        'title' => 'Thiết lập chung',
        'style' => 'default',
        'position' => 'acf_after_title',
        'location' => [
            Location::where('options_page', '==', 'theme-settings'),
        ],
        'fields' => [
            Tab::make('Tab section cam kết')
                ->placement('left'),
            Group::make('Section cam kết', 'section_commit')
                ->fields([
                    Image::make('Ảnh nền', 'background')
                        ->helperText('Kích thước đề xuất: 1750x900px')
                        ->acceptedFileTypes([
                            'png', 'jpg', 'jpeg', 'gif',
                            'svg', 'webp', 'avif',
                        ])
                        ->format('id'),
                    Text::make('Tiêu đề', 'title'),
                    Repeater::make('Danh sách', 'list')
                        ->layout('block')
                        ->collapsed('title')
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

            Tab::make('Tab section hỗ trợ')
                ->placement('left'),
            Repeater::make('Section hỗ trợ', 'section_support')
                ->maxRows(4)
                ->fields([
                    Image::make('Ảnh', 'image')
                        ->helperText('Kích thước đề xuất: 64x64px')
                        ->acceptedFileTypes([
                            'png', 'jpg', 'jpeg', 'gif',
                            'svg', 'webp', 'avif',
                        ])
                        ->format('id'),
                    Text::make('Tiêu đề', 'title')
                        ->required(),
                    Textarea::make('Mô tả', 'description')
                        ->newLines('br')
                        ->rows(2),
                ]),
        ],
    ]);
}, 10);

add_action('acf/init', function () {
    register_extended_field_group([
        'title'    => 'Thiết lập Header',
        'style'    => 'default',
        'position' => 'acf_after_title',
        'location' => [
            Location::where('options_page', '==', 'theme-settings'),
        ],
        'fields' => [
            Tab::make('Tab Header')
                ->placement('left'),
            TrueFalse::make('Hiển thị header', 'show_header')
                ->stylized()
                ->defaultValue(true),
            Text::make('Link ngôn ngữ VI', 'header_lang_vi')
                ->helperText('URL trang tiếng Việt, mặc định là trang chủ')
                ->conditionalLogic([
                    ConditionalLogic::where('show_header', '==', '1'),
                ]),
            Text::make('Link ngôn ngữ EN', 'header_lang_en')
                ->helperText('URL trang tiếng Anh')
                ->conditionalLogic([
                    ConditionalLogic::where('show_header', '==', '1'),
                ]),
        ],
    ]);
}, 11);