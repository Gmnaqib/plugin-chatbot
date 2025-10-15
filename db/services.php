<?php
// blocks/chatbot/db/services.php

defined('MOODLE_INTERNAL') || die();

$functions = [
    'block_chatbot_mobile_view' => [
        'classname' => 'block_chatbot\output\mobile',
        'methodname' => 'mobile_view',
        'description' => 'Returns the content of the chatbot block for mobile.',
        'type' => 'read',
        'ajax' => true,
        'capabilities' => 'moodle/block:view',
    ],
];
