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
use Extended\ACF\Fields\URL;
use Extended\ACF\Location;

defined('ABSPATH') || exit;

add_action('acf/init', function () {
    register_extended_field_group([
        'title' => 'Thiết lập footer',
        'style' => 'default',
        'position' => 'acf_after_title',
        'location' => [
            Location::where('options_page', '==', 'theme-settings'),
        ],
        'fields' => [
            Tab::make('Tab footer trên')
                ->placement('left'),
            Group::make('Footer trên', 'footer_top')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Image::make('Logo')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->column(50)
                        ->acceptedFileTypes([
                            'png', 'jpg', 'jpeg', 'gif',
                            'webp', 'avif', 'svg',
                        ])
                        ->format('id'),
                    URL::make('Đường dẫn logo', 'logo_url')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->column(50)
                        ->default(home_url()),
                    Text::make('Form shortcode')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                ]),

            Tab::make('Tab footer chính')
                ->placement('left'),
            Group::make('Footer chính', 'footer_main')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Tab::make('Tab cột chính')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                    Group::make('Cột chính', 'main')
                        ->fields([
                            TrueFalse::make('Hiển thị', 'show')
                                ->stylized(),
                            Repeater::make('Thông tin liên hệ', 'contacts')
                                ->conditionalLogic([
                                    ConditionalLogic::where('show', '==', '1'),
                                ])
                                ->fields([
                                    Image::make('Ảnh', 'image')
                                        ->acceptedFileTypes([
                                            'png', 'jpg', 'jpeg', 'gif',
                                            'webp', 'avif', 'svg',
                                        ])
                                        ->format('id'),
                                    Text::make('Văn bản', 'text')
                                        ->required(),
                                    Text::make('Đường dẫn', 'url'),
                                ]),
                            Repeater::make('Các liên kết ngoài', 'socials')
                                ->conditionalLogic([
                                    ConditionalLogic::where('show', '==', '1'),
                                ])
                                ->fields([
                                    Image::make('Ảnh', 'image')
                                        ->acceptedFileTypes([
                                            'png', 'jpg', 'jpeg', 'gif',
                                            'webp', 'avif', 'svg',
                                        ])
                                        ->format('id')
                                        ->required(),
                                    Text::make('Đường dẫn', 'url'),
                                ]),
                        ]),

                    Tab::make('Tab cột phụ')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                    Repeater::make('Cột phụ', 'subs')
                        ->layout('block')
                        ->maxRows(2)
                        ->fields([
                            TrueFalse::make('Hiển thị', 'show')
                                ->stylized(),
                            Repeater::make('Các liên kết ngoài', 'socials')
                                ->conditionalLogic([
                                    ConditionalLogic::where('show', '==', '1'),
                                ])
                                ->fields([
                                    Link::make('Liên kết', 'link')
                                        ->required(),
                                ]),
                        ]),
                ]),

            Tab::make('Tab footer dưới')
                ->placement('left'),
            Group::make('Footer dưới', 'footer_bottom')
                ->fields([
                    TrueFalse::make('Hiển thị', 'show')
                        ->stylized(),
                    Text::make('Bản quyền', 'copyright')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ]),
                    Repeater::make('Các chứng chỉ', 'certificates')
                        ->conditionalLogic([
                            ConditionalLogic::where('show', '==', '1'),
                        ])
                        ->fields([
                            Image::make('Ảnh', 'image')
                                ->acceptedFileTypes([
                                    'png', 'jpg', 'jpeg', 'gif',
                                    'webp', 'avif', 'svg',
                                ])
                                ->format('id')
                                ->required(),
                            URL::make('Đường dẫn', 'url'),
                        ]),
                ]),
 
            Tab::make('Tab nút sticky')
                ->placement('left'),
            Repeater::make('Các nút sticky', 'sticky_buttons')
                ->fields([
                    Image::make('Ảnh', 'image')
                        ->acceptedFileTypes([
                            'png', 'jpg', 'jpeg', 'gif',
                            'webp', 'avif', 'svg',
                        ])
                        ->format('id')
                        ->required(),
                    Text::make('Đường dẫn', 'link'),
                ]),
        ],
    ]);
}, 10);