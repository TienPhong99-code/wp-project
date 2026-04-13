<?php

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\FlexibleContent;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Location;

defined('ABSPATH') || exit;

add_action('acf/init', function () {
    register_extended_field_group([
        'title' => 'Thiết lập sidebar',
        'style' => 'default',
        'position' => 'acf_after_title',
        'location' => [
            Location::where('options_page', '==', 'sidebar-settings'),
        ],
        'fields' => [
            Tab::make('Tab chính sách')
                ->placement('left'),
            FlexibleContent::make('Sidebar chính sách', 'sidebar_policy')
                ->layouts([
                    Group::make('Menu')
                        ->fields([
                            TrueFalse::make('Hiển thị', 'show')
                                ->stylized(),
                            Repeater::make('Menu')
                                ->conditionalLogic([
                                    ConditionalLogic::where('show', '==', '1'),
                                ])
                                ->fields([
                                    Link::make('Liên kết', 'link')
                                        ->required(),
                                ]),
                        ]),
                ])
        ],
    ]);
}, 10);