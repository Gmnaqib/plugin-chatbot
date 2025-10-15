<?php
// blocks/chatbot/db/mobile.php

defined('MOODLE_INTERNAL') || die();

$addons = [
    'block_chatbot' => [
        'handlers' => [
            'chatbotpage' => [ // Handler unik untuk blok Anda
                'delegate' => 'CoreCourseOptionsDelegate',
                'method' => 'mobile_view',
                'displaydata' => [
                    'title' => 'pluginname',
                    'class' => 'block_chatbot',
                    'icon' => 'i/chat',
                ],
                'priority' => 500,
            ],
        ],
        'lang' => [
            ['pluginname', 'block_chatbot'],
            ['settings', 'block_chatbot'],
        ]
    ]
];
